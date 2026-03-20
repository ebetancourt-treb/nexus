<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;

class Integration extends Model
{
    use BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'platform',
        'credentials',
        'config',
        'status',
        'last_synced_at',
        'last_error',
    ];

    protected function casts(): array
    {
        return [
            'credentials' => 'encrypted:array',
            'config' => 'array',
            'last_synced_at' => 'datetime',
        ];
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function markSynced(): void
    {
        $this->update([
            'last_synced_at' => now(),
            'last_error' => null,
        ]);
    }

    public function markError(string $error): void
    {
        $this->update([
            'status' => 'error',
            'last_error' => $error,
        ]);
    }
}
