<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transfer extends Model
{
    use HasFactory, BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'from_warehouse_id',
        'to_warehouse_id',
        'out_movement_id',
        'in_movement_id',
        'status',
        'notes',
    ];

    public function fromWarehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class, 'from_warehouse_id');
    }

    public function toWarehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class, 'to_warehouse_id');
    }

    public function outMovement(): BelongsTo
    {
        return $this->belongsTo(Movement::class, 'out_movement_id');
    }

    public function inMovement(): BelongsTo
    {
        return $this->belongsTo(Movement::class, 'in_movement_id');
    }
}
