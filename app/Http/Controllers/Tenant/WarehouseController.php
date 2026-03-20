<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWarehouseRequest;
use App\Http\Requests\UpdateWarehouseRequest;
use App\Models\Warehouse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class WarehouseController extends Controller
{
    public function index(): View
    {
        $warehouses = Warehouse::withCount(['locations', 'stockLevels', 'movements'])
            ->latest()
            ->paginate(20);

        return view('tenant.warehouses.index', compact('warehouses'));
    }

    public function create(): View
    {
        // Verificar límite del plan
        $tenant = auth()->user()->tenant;
        $plan = $tenant->currentPlan();
        $currentCount = Warehouse::count();

        if ($plan && !$tenant->isWithinLimit('max_warehouses', $currentCount)) {
            return view('tenant.warehouses.limit-reached', [
                'limit' => $plan->max_warehouses,
                'planName' => $plan->name,
            ]);
        }

        return view('tenant.warehouses.create');
    }

    public function store(StoreWarehouseRequest $request): RedirectResponse
    {
        // Doble verificación del límite (por si acaso)
        $tenant = auth()->user()->tenant;
        $plan = $tenant->currentPlan();
        $currentCount = Warehouse::count();

        if ($plan && !$tenant->isWithinLimit('max_warehouses', $currentCount)) {
            return back()->withErrors(['limit' => 'Has alcanzado el límite de almacenes de tu plan.']);
        }

        $data = $request->validated();

        // Si es el primero, hacerlo default
        if ($currentCount === 0) {
            $data['is_default'] = true;
        }

        Warehouse::create($data);

        return redirect()->route('tenant.warehouses.index')
            ->with('success', 'Almacén creado correctamente.');
    }

    public function edit(Warehouse $warehouse): View
    {
        return view('tenant.warehouses.edit', compact('warehouse'));
    }

    public function update(UpdateWarehouseRequest $request, Warehouse $warehouse): RedirectResponse
    {
        $warehouse->update($request->validated());

        return redirect()->route('tenant.warehouses.index')
            ->with('success', 'Almacén actualizado correctamente.');
    }

    public function destroy(Warehouse $warehouse): RedirectResponse
    {
        // No permitir eliminar si tiene stock
        if ($warehouse->stockLevels()->where('qty_on_hand', '>', 0)->exists()) {
            return back()->withErrors(['delete' => 'No puedes eliminar un almacén con inventario. Transfiere o ajusta el stock primero.']);
        }

        // No permitir eliminar el último almacén
        if (Warehouse::count() <= 1) {
            return back()->withErrors(['delete' => 'No puedes eliminar tu único almacén.']);
        }

        // Si era el default, asignar otro como default
        if ($warehouse->is_default) {
            Warehouse::where('id', '!=', $warehouse->id)->first()?->update(['is_default' => true]);
        }

        $warehouse->delete();

        return redirect()->route('tenant.warehouses.index')
            ->with('success', 'Almacén eliminado correctamente.');
    }

    public function setDefault(Warehouse $warehouse): RedirectResponse
    {
        // Quitar default de todos
        Warehouse::where('is_default', true)->update(['is_default' => false]);

        // Asignar nuevo default
        $warehouse->update(['is_default' => true]);

        // Actualizar almacén activo en sesión
        session(['active_warehouse_id' => $warehouse->id]);

        return back()->with('success', $warehouse->name . ' es ahora tu almacén principal.');
    }
}
