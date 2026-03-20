<?php

namespace Database\Seeders;

use App\Models\Plan;
use App\Models\PlanFeature;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;


class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cache de permisos
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $this->seedPermissions();
        $this->seedRoles();
        $this->seedPlans();
        $this->seedSuperAdmin();
    }

    private function seedPermissions(): void
    {
        $permissions = [
            // Productos
            'products.view',
            'products.create',
            'products.edit',
            'products.delete',
            'products.import',
            'products.export',

            // Almacenes
            'warehouses.view',
            'warehouses.create',
            'warehouses.edit',
            'warehouses.delete',

            // Ubicaciones
            'locations.view',
            'locations.manage',

            // Movimientos
            'movements.view',
            'movements.create',
            'movements.confirm',
            'movements.cancel',

            // Lotes
            'lots.view',
            'lots.manage',

            // Stock
            'stock.view',
            'stock.adjust',

            // Proveedores
            'suppliers.view',
            'suppliers.create',
            'suppliers.edit',
            'suppliers.delete',

            // Órdenes de compra
            'purchase_orders.view',
            'purchase_orders.create',
            'purchase_orders.edit',
            'purchase_orders.receive',
            'purchase_orders.cancel',

            // Transferencias
            'transfers.view',
            'transfers.create',
            'transfers.receive',

            // Conteos cíclicos
            'cycle_counts.view',
            'cycle_counts.create',
            'cycle_counts.execute',
            'cycle_counts.approve',

            // Pick lists
            'pick_lists.view',
            'pick_lists.create',
            'pick_lists.execute',

            // Reportes
            'reports.view',
            'reports.export',

            // Usuarios del tenant
            'users.view',
            'users.create',
            'users.edit',
            'users.delete',

            // Configuración del tenant
            'settings.view',
            'settings.edit',

            // Integraciones
            'integrations.view',
            'integrations.manage',

            // API tokens
            'api_tokens.view',
            'api_tokens.manage',

            // Workflows
            'workflows.view',
            'workflows.manage',
        ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission, 'web');
        }
    }

    private function seedRoles(): void
    {
        // Roles globales (sin team_id, para el superadmin de Treblum)
        Role::findOrCreate('Super Admin', 'web');

        // Roles template para tenants — se crean sin team_id
        // Al crear un tenant, se clonan con el team_id correspondiente
        $companyAdmin = Role::findOrCreate('Company Admin', 'web');
        $companyAdmin->syncPermissions(Permission::all());

        $warehouseManager = Role::findOrCreate('Warehouse Manager', 'web');
        $warehouseManager->syncPermissions([
            'products.view', 'products.create', 'products.edit', 'products.export',
            'warehouses.view',
            'locations.view', 'locations.manage',
            'movements.view', 'movements.create', 'movements.confirm', 'movements.cancel',
            'lots.view', 'lots.manage',
            'stock.view', 'stock.adjust',
            'suppliers.view', 'suppliers.create', 'suppliers.edit',
            'purchase_orders.view', 'purchase_orders.create', 'purchase_orders.edit', 'purchase_orders.receive',
            'transfers.view', 'transfers.create', 'transfers.receive',
            'cycle_counts.view', 'cycle_counts.create', 'cycle_counts.execute', 'cycle_counts.approve',
            'pick_lists.view', 'pick_lists.create', 'pick_lists.execute',
            'reports.view', 'reports.export',
        ]);

        $operator = Role::findOrCreate('Operator', 'web');
        $operator->syncPermissions([
            'products.view',
            'warehouses.view',
            'locations.view',
            'movements.view', 'movements.create',
            'lots.view',
            'stock.view',
            'transfers.view',
            'pick_lists.view', 'pick_lists.execute',
            'cycle_counts.execute',
        ]);

        $viewer = Role::findOrCreate('Viewer', 'web');
        $viewer->syncPermissions([
            'products.view',
            'warehouses.view',
            'stock.view',
            'movements.view',
            'reports.view',
        ]);
    }

    private function seedPlans(): void
    {
        // ── Starter ──
        $starter = Plan::create([
            'name' => 'Starter',
            'slug' => 'starter',
            'price_monthly' => 349.00,
            'price_yearly' => 3490.00,
            'max_warehouses' => 1,
            'max_skus' => 1000,
            'max_users' => 3,
            'sort_order' => 1,
        ]);

        $starterFeatures = [
            'products.basic' => true,
            'barcode.scan' => true,
            'stock.alerts' => true,
            'reports.basic' => true,
            'export.excel' => true,
            'lots.enabled' => false,
            'serials.enabled' => false,
            'transfers.enabled' => false,
            'purchase_orders.auto' => false,
            'suppliers.enabled' => false,
            'integrations.ecommerce' => false,
            'integrations.erp' => false,
            'workflows.configurable' => false,
            'cycle_counts.enabled' => false,
            'pick_lists.enabled' => false,
            'api.enabled' => false,
            'multi_currency' => false,
            'reports.advanced' => false,
        ];

        foreach ($starterFeatures as $key => $enabled) {
            PlanFeature::create(['plan_id' => $starter->id, 'feature_key' => $key, 'enabled' => $enabled]);
        }

        // ── Profesional ──
        $profesional = Plan::create([
            'name' => 'Profesional',
            'slug' => 'profesional',
            'price_monthly' => 899.00,
            'price_yearly' => 8990.00,
            'max_warehouses' => 3,
            'max_skus' => -1,
            'max_users' => 10,
            'sort_order' => 2,
        ]);

        $profesionalFeatures = [
            'products.basic' => true,
            'barcode.scan' => true,
            'stock.alerts' => true,
            'reports.basic' => true,
            'export.excel' => true,
            'lots.enabled' => true,
            'serials.enabled' => true,
            'transfers.enabled' => true,
            'purchase_orders.auto' => true,
            'suppliers.enabled' => true,
            'integrations.ecommerce' => true,
            'integrations.erp' => false,
            'workflows.configurable' => true,
            'cycle_counts.enabled' => false,
            'pick_lists.enabled' => false,
            'api.enabled' => false,
            'multi_currency' => false,
            'reports.advanced' => true,
        ];

        foreach ($profesionalFeatures as $key => $enabled) {
            PlanFeature::create(['plan_id' => $profesional->id, 'feature_key' => $key, 'enabled' => $enabled]);
        }

        // ── Enterprise ──
        $enterprise = Plan::create([
            'name' => 'Enterprise',
            'slug' => 'enterprise',
            'price_monthly' => 2499.00,
            'price_yearly' => 24990.00,
            'max_warehouses' => -1,
            'max_skus' => -1,
            'max_users' => -1,
            'sort_order' => 3,
        ]);

        $enterpriseFeatures = [
            'products.basic' => true,
            'barcode.scan' => true,
            'stock.alerts' => true,
            'reports.basic' => true,
            'export.excel' => true,
            'lots.enabled' => true,
            'serials.enabled' => true,
            'transfers.enabled' => true,
            'purchase_orders.auto' => true,
            'suppliers.enabled' => true,
            'integrations.ecommerce' => true,
            'integrations.erp' => true,
            'workflows.configurable' => true,
            'cycle_counts.enabled' => true,
            'pick_lists.enabled' => true,
            'api.enabled' => true,
            'multi_currency' => true,
            'reports.advanced' => true,
        ];

        foreach ($enterpriseFeatures as $key => $enabled) {
            PlanFeature::create(['plan_id' => $enterprise->id, 'feature_key' => $key, 'enabled' => $enabled]);
        }
    }

    private function seedSuperAdmin(): void
    {
        $user = User::create([
            'name' => 'Administrador Treblum',
            'email' => env('SUPER_ADMIN_EMAIL', 'admin@treblum.com'),
            'password' => Hash::make(env('SUPER_ADMIN_PASSWORD', 'changeme')),
            'tenant_id' => null,
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        // Setear team_id en 0 para roles globales (superadmin sin tenant)
        app(\Spatie\Permission\PermissionRegistrar::class)->setPermissionsTeamId(0);
        $user->assignRole('Super Admin');

    }
}
