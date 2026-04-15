<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Cashier\Cashier;

class CashierServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Usar Tenant como modelo billable
        Cashier::useCustomerModel(\App\Models\Tenant::class);

        // Usar nuestra tabla custom para suscripciones de Stripe
        Cashier::useSubscriptionModel(\App\Models\StripeSubscription::class);
    }
}