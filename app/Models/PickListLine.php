<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PickListLine extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'pick_list_id',
        'product_id',
        'location_id',
        'lot_id',
        'qty_requested',
        'qty_picked',
        'sort_order',
        'is_picked',
    ];

    protected function casts(): array
    {
        return [
            'qty_requested' => 'decimal:2',
            'qty_picked' => 'decimal:2',
            'is_picked' => 'boolean',
        ];
    }

    public function pickList(): BelongsTo
    {
        return $this->belongsTo(PickList::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function lot(): BelongsTo
    {
        return $this->belongsTo(Lot::class);
    }
}
