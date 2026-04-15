<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Subscription;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Laravel\Cashier\Cashier;

class StripeController extends Controller
{
    public function plans(): View
    {
        $tenant = auth()->user()->tenant;
        $plans = Plan::where('is_active', true)->orderBy('sort_order')->get();
        $currentPlan = $tenant->currentPlan();
        $subscription = $tenant->activeSubscription;

        // Verificar si tiene suscripción activa de Stripe (por stripe_id en stripe_subscriptions)
        $hasStripeSubscription = false;
        $stripeOnGracePeriod = false;

        if ($tenant->stripe_id) {
            $stripeSub = \DB::table('stripe_subscriptions')
                ->where('tenant_id', $tenant->id)
                ->where('type', 'default')
                ->whereIn('stripe_status', ['active', 'past_due'])
                ->first();
            $hasStripeSubscription = (bool) $stripeSub;

            if (!$stripeSub) {
                $canceledSub = \DB::table('stripe_subscriptions')
                    ->where('tenant_id', $tenant->id)
                    ->where('type', 'default')
                    ->whereNotNull('ends_at')
                    ->where('ends_at', '>', now())
                    ->first();
                $stripeOnGracePeriod = (bool) $canceledSub;
                $hasStripeSubscription = $stripeOnGracePeriod;
            }
        }

        return view('tenant.billing.plans', compact(
            'plans', 'currentPlan', 'subscription', 'hasStripeSubscription', 'stripeOnGracePeriod', 'tenant'
        ));
    }

    public function checkout(Plan $plan)
    {
        $tenant = auth()->user()->tenant;

        if (!$plan->stripe_price_id) {
            return back()->withErrors(['error' => 'Este plan no tiene precio en Stripe configurado.']);
        }

        // Si ya tiene suscripción Stripe, redirigir al portal
        $existingSub = \DB::table('stripe_subscriptions')
            ->where('tenant_id', $tenant->id)
            ->where('stripe_status', 'active')
            ->first();

        if ($existingSub) {
            return $tenant->redirectToBillingPortal(route('tenant.billing.plans'));
        }

        return $tenant->newSubscription('default', $plan->stripe_price_id)
            ->checkout([
                'success_url' => route('tenant.billing.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('tenant.billing.plans'),
                'locale' => 'es',
            ]);
    }

    public function success(Request $request): RedirectResponse
    {
        $tenant = auth()->user()->tenant;

        // Esperar a que Stripe procese
        sleep(3);

        // Buscar la suscripción directamente en Stripe
        if ($tenant->stripe_id) {
            try {
                $stripe = new \Stripe\StripeClient(config('cashier.secret'));
                $stripeSubs = $stripe->subscriptions->all([
                    'customer' => $tenant->stripe_id,
                    'status' => 'active',
                    'limit' => 1,
                ]);

                if (count($stripeSubs->data) > 0) {
                    $stripeSub = $stripeSubs->data[0];
                    $priceId = $stripeSub->items->data[0]->price->id ?? null;
                    $itemId = $stripeSub->items->data[0]->id ?? null;
                    $productId = $stripeSub->items->data[0]->price->product ?? null;

                    // Guardar/actualizar en stripe_subscriptions
                    \DB::table('stripe_subscriptions')->updateOrInsert(
                        ['tenant_id' => $tenant->id, 'type' => 'default'],
                        [
                            'stripe_id' => $stripeSub->id,
                            'stripe_status' => $stripeSub->status,
                            'stripe_price' => $priceId,
                            'quantity' => 1,
                            'trial_ends_at' => null,
                            'ends_at' => null,
                            'updated_at' => now(),
                            'created_at' => now(),
                        ]
                    );

                    // Guardar/actualizar subscription item
                    $localSub = \DB::table('stripe_subscriptions')
                        ->where('tenant_id', $tenant->id)
                        ->where('type', 'default')
                        ->first();

                    if ($localSub && $itemId) {
                        \DB::table('stripe_subscription_items')->updateOrInsert(
                            ['subscription_id' => $localSub->id],
                            [
                                'stripe_id' => $itemId,
                                'stripe_product' => $productId ?? '',
                                'stripe_price' => $priceId,
                                'quantity' => 1,
                                'updated_at' => now(),
                                'created_at' => now(),
                            ]
                        );
                    }

                    // Sincronizar plan interno de BlumOps
                    $plan = Plan::where('stripe_price_id', $priceId)->first();
                    if ($plan) {
                        $internalSub = Subscription::where('tenant_id', $tenant->id)->latest()->first();
                        if ($internalSub) {
                            $internalSub->update([
                                'plan_id' => $plan->id,
                                'status' => 'active',
                                'trial_ends_at' => null,
                                'current_period_start' => now(),
                                'current_period_end' => now()->addMonth(),
                            ]);
                        }
                    }
                }
            } catch (\Exception $e) {
                \Log::error('Stripe sync failed: ' . $e->getMessage());
            }
        }

        return redirect()->route('tenant.billing.plans')
            ->with('success', '¡Pago exitoso! Tu plan ha sido activado.');
    }

    public function portal()
    {
        $tenant = auth()->user()->tenant;
        return $tenant->redirectToBillingPortal(route('tenant.billing.plans'));
    }

    public function changePlan(Plan $plan): RedirectResponse
    {
        $tenant = auth()->user()->tenant;

        if (!$plan->stripe_price_id) {
            return back()->withErrors(['error' => 'Plan sin precio de Stripe.']);
        }

        // Buscar suscripción activa en Stripe
        $stripeSub = \DB::table('stripe_subscriptions')
            ->where('tenant_id', $tenant->id)
            ->where('type', 'default')
            ->where('stripe_status', 'active')
            ->first();

        if (!$stripeSub) {
            return redirect()->route('tenant.billing.checkout', $plan);
        }

        try {
            $stripe = new \Stripe\StripeClient(config('cashier.secret'));

            // Obtener el subscription item actual
            $sub = $stripe->subscriptions->retrieve($stripeSub->stripe_id);
            $itemId = $sub->items->data[0]->id;

            // Swap al nuevo precio
            $stripe->subscriptions->update($stripeSub->stripe_id, [
                'items' => [['id' => $itemId, 'price' => $plan->stripe_price_id]],
                'proration_behavior' => 'create_prorations',
            ]);

            // Actualizar local
            \DB::table('stripe_subscriptions')
                ->where('id', $stripeSub->id)
                ->update(['stripe_price' => $plan->stripe_price_id, 'updated_at' => now()]);

            \DB::table('stripe_subscription_items')
                ->where('subscription_id', $stripeSub->id)
                ->update(['stripe_price' => $plan->stripe_price_id, 'updated_at' => now()]);

            // Sincronizar plan interno
            $internalSub = Subscription::where('tenant_id', $tenant->id)->latest()->first();
            if ($internalSub) {
                $internalSub->update([
                    'plan_id' => $plan->id,
                    'status' => 'active',
                ]);
            }

            return back()->with('success', "Plan cambiado a {$plan->name} correctamente.");
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al cambiar plan: ' . $e->getMessage()]);
        }
    }

    public function cancel(): RedirectResponse
    {
        $tenant = auth()->user()->tenant;

        $stripeSub = \DB::table('stripe_subscriptions')
            ->where('tenant_id', $tenant->id)
            ->where('type', 'default')
            ->where('stripe_status', 'active')
            ->first();

        if ($stripeSub) {
            try {
                $stripe = new \Stripe\StripeClient(config('cashier.secret'));
                $stripe->subscriptions->update($stripeSub->stripe_id, [
                    'cancel_at_period_end' => true,
                ]);

                $sub = $stripe->subscriptions->retrieve($stripeSub->stripe_id);
                \DB::table('stripe_subscriptions')
                    ->where('id', $stripeSub->id)
                    ->update([
                        'ends_at' => date('Y-m-d H:i:s', $sub->current_period_end),
                        'updated_at' => now(),
                    ]);
            } catch (\Exception $e) {
                return back()->withErrors(['error' => 'Error: ' . $e->getMessage()]);
            }
        }

        return back()->with('success', 'Tu suscripción se cancelará al final del período actual.');
    }

    public function resume(): RedirectResponse
    {
        $tenant = auth()->user()->tenant;

        $stripeSub = \DB::table('stripe_subscriptions')
            ->where('tenant_id', $tenant->id)
            ->where('type', 'default')
            ->first();

        if ($stripeSub && $stripeSub->ends_at) {
            try {
                $stripe = new \Stripe\StripeClient(config('cashier.secret'));
                $stripe->subscriptions->update($stripeSub->stripe_id, [
                    'cancel_at_period_end' => false,
                ]);

                \DB::table('stripe_subscriptions')
                    ->where('id', $stripeSub->id)
                    ->update(['ends_at' => null, 'updated_at' => now()]);
            } catch (\Exception $e) {
                return back()->withErrors(['error' => 'Error: ' . $e->getMessage()]);
            }
        }

        return back()->with('success', 'Tu suscripción ha sido reactivada.');
    }
}
