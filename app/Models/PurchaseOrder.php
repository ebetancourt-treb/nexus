<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use App\Traits\HasWarehouse;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PurchaseOrder extends Model
{
    use HasFactory, BelongsToTenant, HasWarehouse;

    protected $fillable = [
        'tenant_id',
        'supplier_id',
        'warehouse_id',
        'po_number',
        'status',
        'expected_at',
        'received_at',
        'currency',
        'exchange_rate',
        'subtotal',
        'tax',
        'total',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'expected_at' => 'date',
            'received_at' => 'date',
            'exchange_rate' => 'decimal:6',
            'subtotal' => 'decimal:2',
            'tax' => 'decimal:2',
            'total' => 'decimal:2',
        ];
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function lines(): HasMany
    {
        return $this->hasMany(PoLine::class);
    }

    public function isFullyReceived(): bool
    {
        return $this->lines->every(fn ($line) => $line->qty_received >= $line->qty_ordered);
    }
}
