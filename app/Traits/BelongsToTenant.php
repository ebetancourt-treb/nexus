<?php

namespace App\Traits;

use App\Models\Tenant;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToTenant
{
    public static function bootBelongsToTenant(): void
    {
        // AUTO-SCOPE: filtra por tenant actual en todas las queries
        static::addGlobalScope('tenant', function (Builder $builder) {
            $tenantId = app()->bound('current_tenant_id')
                ? app('current_tenant_id')
                : null;

            if ($tenantId) {
                $builder->where($builder->getModel()->getTable() . '.tenant_id', $tenantId);
            }
        });

        // AUTO-FILL: asigna tenant_id al crear un registro
        static::creating(function (Model $model) {
            if (empty($model->tenant_id) && app()->bound('current_tenant_id')) {
                $model->tenant_id = app('current_tenant_id');
            }
        });
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * Scope para queries sin tenant (superadmin)
     */
    public function scopeWithoutTenant(Builder $builder): Builder
    {
        return $builder->withoutGlobalScope('tenant');
    }
}
