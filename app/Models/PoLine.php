<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PoLine extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'purchase_order_id',
        'product_id',
        'qty_ordered',
        'qty_received',
        'unit_cost',
        'line_total',
    ];

    protected function casts(): array
    {
        return [
            'qty_ordered' => 'decimal:2',
            'qty_received' => 'decimal:2',
            'unit_cost' => 'decimal:4',
            'line_total' => 'decimal:2',
        ];
    }

    public function purchaseOrder(): BelongsTo
    {
        return $this->belongsTo(PurchaseOrder::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function qtyPending(): float
    {
        return max(0, $this->qty_ordered - $this->qty_received);
    }
}
