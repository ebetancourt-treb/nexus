<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Http\Requests\StoreTenantRequest;
use App\Http\Requests\UpdateTenantRequest;

class TenantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_name' => 'required|string',
            'admin_name' => 'required|string',
            'admin_email' => 'required|email|unique:users,email',
            'password' => 'required',
        ]);

        DB::transaction(function () use ($validated) {
            // 2. Crear el Tenant
            $tenant = Tenant::create(['name' => $validated['company_name']]);

            // 3. Crear el Usuario Admin vinculado a ese Tenant
            $user = User::create([
                'name' => $validated['admin_name'],
                'email' => $validated['admin_email'],
                'password' => Hash::make($validated['password']),
                'tenant_id' => $tenant->id, // <--- Vinculación clave
            ]);

            // 4. Asignar Rol de Spatie (Admin de Empresa)
            $user->assignRole('Company Admin');
        });

        return redirect()->back()->with('success', 'Empresa y Administrador creados.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tenant $tenant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tenant $tenant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTenantRequest $request, Tenant $tenant)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tenant $tenant)
    {
        //
    }
}
