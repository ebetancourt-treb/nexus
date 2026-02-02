<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // 1. Crear Roles
        $roleSuperAdmin = Role::create(['name' => 'Super Admin']);
        $roleCompanyAdmin = Role::create(['name' => 'Company Admin']);
        
        // 2. Crear TU Usuario Super Admin
        $user = User::create([
            'name' => 'Administrador Global',
            'email' => 'admin@treblum.com',
            'password' => Hash::make('password'), 
            'tenant_id' => null, 
        ]);

        $user->assignRole($roleSuperAdmin);
    }
}