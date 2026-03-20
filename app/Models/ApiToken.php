<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ApiToken extends Model
{
    use BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'name',
        'token_hash',
        'abilities',
        'last_used_at',
        'expires_at',
    ];

    protected $hidden = [
        'token_hash',
    ];

    protected function casts(): array
    {
        return [
            'abilities' => 'array',
            'last_used_at' => 'datetime',
            'expires_at' => 'datetime',
        ];
    }

    /**
     * Genera un nuevo token y retorna el plain text (solo visible una vez)
     */
    public static function createForTenant(int $tenantId, string $name, array $abilities = ['*']): array
    {
        $plainToken = Str::random(64);

        $token = static::create([
            'tenant_id' => $tenantId,
            'name' => $name,
            'token_hash' => hash('sha256', $plainToken),
            'abilities' => $abilities,
            'expires_at' => now()->addYear(),
        ]);

        return [
            'token' => $token,
            'plain_text' => $plainToken, // Mostrar una vez al usuario
        ];
    }

    public function isExpired(): bool
    {
        return $this->expires_at?->isPast() ?? false;
    }

    public function can(string $ability): bool
    {
        return in_array('*', $this->abilities ?? []) || in_array($ability, $this->abilities ?? []);
    }
}
