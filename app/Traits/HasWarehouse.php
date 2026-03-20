<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Warehouse;

trait HasWarehouse
{
    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }

    /**
     * Filtra por el almacén activo en sesión
     */
    public function scopeInActiveWarehouse(Builder $builder): Builder
    {
        $warehouseId = session('active_warehouse_id');

        if ($warehouseId) {
            $builder->where($builder->getModel()->getTable() . '.warehouse_id', $warehouseId);
        }

        return $builder;
    }
}
