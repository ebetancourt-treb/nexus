<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use App\Traits\HasWarehouse;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PickList extends Model
{
    use BelongsToTenant, HasWarehouse;

    protected $fillable = [
        'tenant_id',
        'warehouse_id',
        'assigned_to',
        'reference',
        'type',
        'status',
        'started_at',
        'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'started_at' => 'datetime',
            'completed_at' => 'datetime',
        ];
    }

    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function lines(): HasMany
    {
        return $this->hasMany(PickListLine::class);
    }

    public function progress(): float
    {
        $total = $this->lines->count();

        if ($total === 0) {
            return 0;
        }

        return round($this->lines->where('is_picked', true)->count() / $total * 100, 1);
    }
}
