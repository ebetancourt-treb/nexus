<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use App\Traits\HasWarehouse;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockLevel extends Model
{
    use BelongsToTenant, HasWarehouse;

    protected $fillable = [
        'tenant_id',
        'product_id',
        'warehouse_id',
        'location_id',
        'lot_id',
        'qty_on_hand',
        'qty_reserved',
        'qty_available',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'qty_on_hand' => 'decimal:2',
            'qty_reserved' => 'decimal:2',
            'qty_available' => 'decimal:2',
        ];
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

    /**
     * Recalcula qty_available desde on_hand - reserved
     */
    public function recalculate(): self
    {
        $this->qty_available = max(0, $this->qty_on_hand - $this->qty_reserved);
        return $this;
    }
}
