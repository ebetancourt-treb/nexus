<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CycleCountLine extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'cycle_count_id',
        'product_id',
        'location_id',
        'lot_id',
        'expected_qty',
        'counted_qty',
        'variance',
        'adjustment_created',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'expected_qty' => 'decimal:2',
            'counted_qty' => 'decimal:2',
            'variance' => 'decimal:2',
            'adjustment_created' => 'boolean',
        ];
    }

    public function cycleCount(): BelongsTo
    {
        return $this->belongsTo(CycleCount::class);
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
