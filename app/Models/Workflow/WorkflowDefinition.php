<?php

namespace App\Models\Workflow;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WorkflowDefinition extends Model
{
    use BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'type',
        'name',
        'version',
        'is_active',
        'is_system',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'is_system' => 'boolean',
        ];
    }

    public function steps(): HasMany
    {
        return $this->hasMany(WorkflowStep::class)->orderBy('sort_order');
    }

    /**
     * Obtiene el workflow activo para un tipo y tenant.
     * Prioriza el custom del tenant, fallback al del sistema.
     */
    public static function resolveForTenant(string $type, ?int $tenantId): ?self
    {
        // Primero buscar custom del tenant
        if ($tenantId) {
            $custom = static::withoutGlobalScope('tenant')
                ->where('tenant_id', $tenantId)
                ->where('type', $type)
                ->where('is_active', true)
                ->latest('version')
                ->first();

            if ($custom) {
                return $custom;
            }
        }

        // Fallback al workflow del sistema
        return static::withoutGlobalScope('tenant')
            ->whereNull('tenant_id')
            ->where('type', $type)
            ->where('is_system', true)
            ->where('is_active', true)
            ->latest('version')
            ->first();
    }
}
