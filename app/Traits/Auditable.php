<?php

namespace App\Traits;

use App\Models\AuditLog;

trait Auditable
{
    public static function bootAuditable(): void
    {
        static::created(function ($model) {
            static::logAudit($model, 'created');
        });

        static::updated(function ($model) {
            $dirty = $model->getDirty();
            unset($dirty['updated_at'], $dirty['remember_token']);

            if (empty($dirty)) {
                return;
            }

            static::logAudit($model, 'updated', $model->getOriginal(), $dirty);
        });

        static::deleted(function ($model) {
            static::logAudit($model, 'deleted');
        });
    }

    private static function logAudit($model, string $event, ?array $oldValues = null, ?array $newValues = null): void
    {
        try {
            $user = auth()->user();

            // Determinar tenant_id — requerido por la constraint de la BD
            $tenantId = $model->tenant_id
                ?? $user?->tenant_id
                ?? (app()->bound('current_tenant_id') ? app('current_tenant_id') : null);

            // Si no hay tenant_id, no podemos insertar (constraint NOT NULL)
            if (!$tenantId) {
                return;
            }

            AuditLog::withoutGlobalScopes()->create([
                'tenant_id' => $tenantId,
                'user_id' => $user?->id,
                'auditable_type' => get_class($model),
                'auditable_id' => $model->getKey(),
                'event' => $event,
                'old_values' => $oldValues,
                'new_values' => $newValues,
                'ip_address' => request()?->ip(),
                'user_agent' => request()?->userAgent(),
                'created_at' => now(),
            ]);
        } catch (\Throwable $e) {
            // Nunca dejar que el audit log rompa la operación principal
            logger()->warning('Audit log failed: ' . $e->getMessage());
        }
    }
}
