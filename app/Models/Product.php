<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, BelongsToTenant, SoftDeletes;

    protected $fillable = [
        'tenant_id',
        'category_id',
        'name',
        'sku',
        'barcode',
        'description',
        'unit_of_measure',
        'cost_price',
        'sale_price',
        'reorder_point',
        'reorder_qty',
        'track_lots',
        'track_serials',
        'weight',
        'volume',
        'is_active',
        'custom_attributes',
    ];

    protected function casts(): array
    {
        return [
            'cost_price' => 'decimal:4',
            'sale_price' => 'decimal:4',
            'weight' => 'decimal:3',
            'volume' => 'decimal:3',
            'track_lots' => 'boolean',
            'track_serials' => 'boolean',
            'is_active' => 'boolean',
            'custom_attributes' => 'array',
        ];
    }

    // ── Relationships ──

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function lots(): HasMany
    {
        return $this->hasMany(Lot::class);
    }

    public function serialNumbers(): HasMany
    {
        return $this->hasMany(SerialNumber::class);
    }

    public function stockLevels(): HasMany
    {
        return $this->hasMany(StockLevel::class);
    }

    public function movementLines(): HasMany
    {
        return $this->hasMany(MovementLine::class);
    }

    public function uomConversions(): HasMany
    {
        return $this->hasMany(ProductUomConversion::class);
    }

    // ── Helpers ──

    /**
     * Stock total disponible sumando todos los almacenes
     */
    public function totalAvailable(): float
    {
        return $this->stockLevels()
            ->where('status', 'available')
            ->sum('qty_available');
    }

    /**
     * ¿Está por debajo del punto de reorden?
     */
    public function isLowStock(): bool
    {
        return $this->reorder_point > 0 && $this->totalAvailable() <= $this->reorder_point;
    }
}
