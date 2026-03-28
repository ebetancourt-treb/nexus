<?php

namespace App\Models;

use App\Traits\Auditable;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DispatchOrder extends Model
{
    use HasFactory, BelongsToTenant, Auditable;

    protected $fillable = [
        'tenant_id', 'warehouse_id', 'created_by', 'confirmed_by',
        'order_number', 'customer_name', 'customer_reference',
        'status', 'notes', 'reserved_at', 'picking_started_at', 'picked_at', 'dispatched_at',
    ];

    protected function casts(): array
    {
        return [
            'reserved_at' => 'datetime',
            'picking_started_at' => 'datetime',
            'picked_at' => 'datetime',
            'dispatched_at' => 'datetime',
        ];
    }

    public function warehouse(): BelongsTo { return $this->belongsTo(Warehouse::class); }
    public function createdBy(): BelongsTo { return $this->belongsTo(User::class, 'created_by'); }
    public function confirmedBy(): BelongsTo { return $this->belongsTo(User::class, 'confirmed_by'); }
    public function lines(): HasMany { return $this->hasMany(DispatchOrderLine::class); }

    public function generateOrderNumber(): string
    {
        $last = static::where('tenant_id', $this->tenant_id)
            ->whereYear('created_at', now()->year)
            ->max('order_number');
        $seq = $last ? (int) substr($last, -4) + 1 : 1;
        return 'DS-' . now()->format('Y') . '-' . str_pad($seq, 4, '0', STR_PAD_LEFT);
    }

    public function isFullyPicked(): bool
    {
        return $this->lines->every(fn ($line) => $line->is_picked);
    }
}
