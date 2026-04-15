<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmailVerificationCode extends Model
{
    protected $fillable = ['user_id', 'code', 'expires_at', 'used'];

    protected function casts(): array
    {
        return [
            'expires_at' => 'datetime',
            'used' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }

    public function isValid(): bool
    {
        return !$this->used && !$this->isExpired();
    }

    /**
     * Genera un código de 6 dígitos para un usuario.
     */
    public static function generateFor(User $user): self
    {
        // Invalidar códigos anteriores
        static::where('user_id', $user->id)->where('used', false)->update(['used' => true]);

        return static::create([
            'user_id' => $user->id,
            'code' => str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT),
            'expires_at' => now()->addMinutes(15),
        ]);
    }
}
