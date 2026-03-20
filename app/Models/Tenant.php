<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Tenant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'rfc',
        'phone',
        'logo_path',
        'is_active',
        'settings',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'settings' => 'array',
        ];
    }

    // ── Relationships ──

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function warehouses(): HasMany
    {
        return $this->hasMany(Warehouse::class);
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    public function activeSubscription(): HasOne
    {
        return $this->hasOne(Subscription::class)
            ->whereIn('status', ['active', 'trialing'])
            ->latest();
    }

    public function integrations(): HasMany
    {
        return $this->hasMany(Integration::class);
    }

    public function apiTokens(): HasMany
    {
        return $this->hasMany(ApiToken::class);
    }

    // ── Helpers ──

    public function currentPlan(): ?Plan
    {
        return $this->activeSubscription?->plan;
    }

    public function hasFeature(string $featureKey): bool
    {
        $plan = $this->currentPlan();

        if (! $plan) {
            return false;
        }

        return $plan->features()
            ->where('feature_key', $featureKey)
            ->where('enabled', true)
            ->exists();
    }

    public function isWithinLimit(string $limitField, int $currentCount): bool
    {
        $plan = $this->currentPlan();

        if (! $plan) {
            return false;
        }

        $limit = $plan->{$limitField};

        return $limit === -1 || $currentCount < $limit; // -1 = ilimitado
    }

    public function getSetting(string $key, mixed $default = null): mixed
    {
        return data_get($this->settings, $key, $default);
    }
}
