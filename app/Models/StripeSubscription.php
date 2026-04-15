<?php

namespace App\Models;

use Laravel\Cashier\Subscription as CashierSubscription;

class StripeSubscription extends CashierSubscription
{
    protected $table = 'stripe_subscriptions';

    public function items(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(StripeSubscriptionItem::class, 'subscription_id');
    }
}