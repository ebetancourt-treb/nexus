<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use App\Traits\HasWarehouse;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CycleCount extends Model
{
    use BelongsToTenant, HasWarehouse;

    protected $fillable = [
        'tenant_id',
        'warehouse_id',
        'assigned_to',
        'approved_by',
        'reference',
        'status',
        'scheduled_at',
        'started_at',
        'completed_at',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'scheduled_at' => 'date',
            'started_at' => 'datetime',
            'completed_at' => 'datetime',
        ];
    }

    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function approvedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function lines(): HasMany
    {
        return $this->hasMany(CycleCountLine::class);
    }

    public function totalVariance(): float
    {
        return $this->lines->sum('variance') ?? 0;
    }
}
