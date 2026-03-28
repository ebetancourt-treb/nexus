<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DispatchOrderLine extends Model
{
    protected $fillable = [
        'dispatch_order_id', 'product_id', 'lot_id',
        'quantity_requested', 'quantity_picked', 'is_picked', 'location_note',
    ];

    protected function casts(): array
    {
        return ['is_picked' => 'boolean', 'quantity_requested' => 'decimal:2', 'quantity_picked' => 'decimal:2'];
    }

    public function dispatchOrder(): BelongsTo { return $this->belongsTo(DispatchOrder::class); }
    public function product(): BelongsTo { return $this->belongsTo(Product::class); }
    public function lot(): BelongsTo { return $this->belongsTo(Lot::class); }
}
