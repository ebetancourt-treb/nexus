<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductUomConversion extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'product_id',
        'from_uom',
        'to_uom',
        'factor',
        'barcode',
    ];

    protected function casts(): array
    {
        return [
            'factor' => 'decimal:4',
        ];
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
