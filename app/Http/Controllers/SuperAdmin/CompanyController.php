<?php
namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CompanyController extends Controller
{
    // Listar Empresas registradas
    public function index()
    {
        // Aquí NO usamos el trait BelongsToTenant porque Tenant es el modelo "padre"
        $companies = Tenant::with('users')->get(); 
        return view('superadmin.companies.index', compact('companies'));
    }

    // Guardar nueva empresa y su admin
    public function store(Request $request)
    {
        // 1. Validamos datos de la empresa Y del usuario admin
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'company_domain' => 'nullable|string|max:255', // Opcional
            'admin_name' => 'required|string|max:255',
            'admin_email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
        ]);

        try {
            DB::transaction(function () use ($validated) {
                // A. Crear la Empresa (Tenant)
                $tenant = Tenant::create([
                    'name' => $validated['company_name'],
                    'domain' => $validated['company_domain'] ?? null,
                ]);

                // B. Crear el Usuario Admin vinculado a esa Empresa
                $user = User::create([
                    'name' => $validated['admin_name'],
                    'email' => $validated['admin_email'],
                    'password' => Hash::make($validated['password']),
                    'tenant_id' => $tenant->id, // <--- Aquí ocurre la magia
                ]);

                // C. Asignar el Rol de "Admin" (usando Spatie)
                // Asegúrate de tener este rol creado en tu seeder de roles
                $user->assignRole('Company Admin'); 
            });

            return redirect()->route('superadmin.companies.index')
                             ->with('success', 'Empresa y Administrador creados correctamente.');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al crear la empresa: ' . $e->getMessage()]);
        }
    }
}