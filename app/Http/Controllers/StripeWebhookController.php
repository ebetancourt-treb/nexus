<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Subscription;
use App\Models\Tenant;
use Laravel\Cashier\Http\Controllers\WebhookController as CashierController;
use Illuminate\Support\Facades\Log;

class StripeWebhookController extends CashierController
{
    /**
     * Cuando se crea una suscripción nueva en Stripe.
     */
    public function handleCustomerSubscriptionCreated(array $payload): void
    {
        parent::handleCustomerSubscriptionCreated($payload);

        $this->syncBlumOpsPlan($payload);
    }

    /**
     * Cuando se actualiza una suscripción (cambio de plan, renovación).
     */
    public function handleCustomerSubscriptionUpdated(array $payload): void
    {
        parent::handleCustomerSubscriptionUpdated($payload);

        $this->syncBlumOpsPlan($payload);
    }

    /**
     * Cuando se cancela/elimina una suscripción.
     */
    public function handleCustomerSubscriptionDeleted(array $payload): void
    {
        parent::handleCustomerSubscriptionDeleted($payload);

        $stripeCustomerId = $payload['data']['object']['customer'] ?? null;

        if (!$stripeCustomerId) {
            return;
        }

        $tenant = Tenant::where('stripe_id', $stripeCustomerId)->first();

        if ($tenant) {
            $internalSub = $tenant->subscriptions()->latest()->first();
            if ($internalSub) {
                $internalSub->update(['status' => 'canceled']);
            }
            Log::info("BlumOps: Suscripción cancelada para tenant {$tenant->id}");
        }
    }

    /**
     * Cuando un pago falla (tarjeta rechazada, fondos insuficientes).
     */
    public function handleInvoicePaymentFailed(array $payload): void
    {
        $stripeCustomerId = $payload['data']['object']['customer'] ?? null;

        if (!$stripeCustomerId) {
            return;
        }

        $tenant = Tenant::where('stripe_id', $stripeCustomerId)->first();

        if ($tenant) {
            $internalSub = $tenant->subscriptions()->latest()->first();
            if ($internalSub) {
                $internalSub->update(['status' => 'past_due']);
            }
            Log::warning("BlumOps: Pago fallido para tenant {$tenant->id}");
        }
    }

    /**
     * Sincronizar plan interno de BlumOps con Stripe.
     */
    private function syncBlumOpsPlan(array $payload): void
    {
        $stripeCustomerId = $payload['data']['object']['customer'] ?? null;
        $stripePriceId = $payload['data']['object']['items']['data'][0]['price']['id'] ?? null;
        $stripeStatus = $payload['data']['object']['status'] ?? null;

        if (!$stripeCustomerId || !$stripePriceId) {
            return;
        }

        $tenant = Tenant::where('stripe_id', $stripeCustomerId)->first();
        $plan = Plan::where('stripe_price_id', $stripePriceId)->first();

        if (!$tenant || !$plan) {
            Log::warning("BlumOps webhook: tenant o plan no encontrado. Customer: {$stripeCustomerId}, Price: {$stripePriceId}");
            return;
        }

        // Mapear status de Stripe a status interno
        $statusMap = [
            'active' => 'active',
            'trialing' => 'trialing',
            'past_due' => 'past_due',
            'canceled' => 'canceled',
            'unpaid' => 'past_due',
        ];

        $internalStatus = $statusMap[$stripeStatus] ?? 'active';

        $internalSub = $tenant->subscriptions()->latest()->first();

        if ($internalSub) {
            $internalSub->update([
                'plan_id' => $plan->id,
                'status' => $internalStatus,
                'current_period_start' => now(),
                'current_period_end' => now()->addMonth(),
            ]);
        } else {
            Subscription::create([
                'tenant_id' => $tenant->id,
                'plan_id' => $plan->id,
                'status' => $internalStatus,
                'current_period_start' => now(),
                'current_period_end' => now()->addMonth(),
                'billing_cycle' => 'monthly',
            ]);
        }

        Log::info("BlumOps: Plan sincronizado para tenant {$tenant->id} → {$plan->name} ({$internalStatus})");
    }
}
