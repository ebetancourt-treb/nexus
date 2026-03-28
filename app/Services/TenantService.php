<?php

namespace App\Services;

use App\Models\Plan;
use App\Models\Subscription;
use App\Models\Tenant;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class TenantService
{
    /**
     * Crea un tenant completo: empresa + admin + suscripción trial + almacén default.
     * Retorna el User admin creado.
     */
    public function createTenantWithTrial(array $data): User
    {
        return DB::transaction(function () use ($data) {

            // 1. Crear tenant
            $tenant = Tenant::create([
                'name' => $data['company_name'],
                'slug' => $this->generateUniqueSlug($data['company_name']),
                'is_active' => true,
                'settings' => [
                    'timezone' => 'America/Mexico_City',
                    'currency' => 'MXN',
                    'date_format' => 'd/m/Y',
                ],
            ]);

            // 2. Crear usuario admin
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'tenant_id' => $tenant->id,
                'is_active' => true,
            ]);

            // 3. Asignar rol Company Admin scoped al tenant
            app(PermissionRegistrar::class)->setPermissionsTeamId($tenant->id);

            // Crear el rol para este tenant si no existe
            $role = Role::findOrCreate('Company Admin', 'web');
            $user->assignRole($role);

            // 4. Crear suscripción trial con el plan elegido
            $planSlug = $data['plan'] ?? 'profesional';
            $plan = Plan::where('slug', $planSlug)->first()
                ?? Plan::where('slug', 'starter')->firstOrFail();

            Subscription::create([
                'tenant_id' => $tenant->id,
                'plan_id' => $plan->id,
                'status' => 'trialing',
                'trial_ends_at' => now()->addDays(7),
                'billing_cycle' => 'monthly',
            ]);

            // 5. Crear almacén default
            // Bindear tenant_id al container para que BelongsToTenant funcione
            app()->instance('current_tenant_id', $tenant->id);

            Warehouse::create([
                'tenant_id' => $tenant->id,
                'name' => 'Almacén Principal',
                'code' => 'ALM-01',
                'rotation_strategy' => 'fifo',
                'is_active' => true,
                'is_default' => true,
            ]);

            return $user;
        });
    }

    /**
     * Genera un slug único basado en el nombre de la empresa.
     */
    private function generateUniqueSlug(string $name): string
    {
        $slug = Str::slug($name);
        $original = $slug;
        $counter = 1;

        while (Tenant::where('slug', $slug)->exists()) {
            $slug = $original . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}
