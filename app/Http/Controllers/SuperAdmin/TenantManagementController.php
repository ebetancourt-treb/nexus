<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Movement;
use App\Models\Product;
use App\Models\StockLevel;
use App\Models\Tenant;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TenantManagementController extends Controller
{
    public function index(Request $request): View
    {
        $query = Tenant::with(['subscriptions.plan'])
            ->withCount(['users', 'warehouses']);

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('company_name', 'like', "%{$search}%")
                  ->orWhere('rfc', 'like', "%{$search}%");
            });
        }

        if ($status = $request->input('status')) {
            if ($status === 'active') $query->where('is_active', true);
            if ($status === 'inactive') $query->where('is_active', false);
        }

        if ($plan = $request->input('plan')) {
            $query->whereHas('subscriptions', fn ($q) => $q->whereHas('plan', fn ($p) => $p->where('slug', $plan)));
        }

        if ($request->input('trial_expiring')) {
            $query->whereHas('subscriptions', fn ($q) =>
                $q->where('status', 'trialing')
                  ->whereBetween('trial_ends_at', [now(), now()->addDays(7)])
            );
        }

        $tenants = $query->latest()->paginate(25)->withQueryString();

        return view('superadmin.tenants.index', compact('tenants'));
    }

    public function show(Tenant $tenant): View
    {
        $tenant->load(['subscriptions.plan', 'users']);

        // Stats del tenant (sin global scope — accedemos directo)
        $stats = [
            'users' => User::where('tenant_id', $tenant->id)->count(),
            'warehouses' => Warehouse::where('tenant_id', $tenant->id)->count(),
            'products' => Product::where('tenant_id', $tenant->id)->count(),
            'total_movements' => Movement::where('tenant_id', $tenant->id)->count(),
            'total_units' => StockLevel::where('tenant_id', $tenant->id)->sum('qty_on_hand'),
            'movements_this_month' => Movement::where('tenant_id', $tenant->id)
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
        ];

        $recentMovements = Movement::where('tenant_id', $tenant->id)
            ->with(['user', 'warehouse'])
            ->latest()
            ->take(10)
            ->get();

        return view('superadmin.tenants.show', compact('tenant', 'stats', 'recentMovements'));
    }

    public function toggleActive(Tenant $tenant): RedirectResponse
    {
        $tenant->update(['is_active' => !$tenant->is_active]);

        $status = $tenant->is_active ? 'activado' : 'desactivado';
        return back()->with('success', "Tenant {$tenant->company_name} {$status} correctamente.");
    }
}
