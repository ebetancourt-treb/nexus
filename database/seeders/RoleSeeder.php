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
        $roleAdmin = Role::create(['name=>' => 'Admin']);
        $roleCompanyAdmin = Role::create(['name' => 'Company Admin']);
        
        // 2. Crear TU Usuario Super Admin
        $user = User::create([
            'name' => 'Administrador Treblum',
            'email' => 'admin@treblum.com', 
            'password' => Hash::make('WbrE5%7p'), 
            'tenant_id' => null, 
        ]);
        $user->assignRole($roleSuperAdmin);
    }
}
