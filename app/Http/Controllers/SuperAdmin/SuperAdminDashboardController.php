<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Movement;
use App\Models\Product;
use App\Models\Subscription;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class SuperAdminDashboardController extends Controller
{
    public function index(): View
    {
        // Métricas principales
        $totalTenants = Tenant::count();
        $activeTenants = Tenant::where('is_active', true)->count();
        $totalUsers = User::whereNotNull('tenant_id')->count();

        // Trials por vencer (próximos 7 días)
        $trialsExpiringSoon = Subscription::where('status', 'trialing')
            ->whereBetween('trial_ends_at', [now(), now()->addDays(7)])
            ->count();

        $activeTrials = Subscription::where('status', 'trialing')
            ->where('trial_ends_at', '>', now())
            ->count();

        $expiredTrials = Subscription::where('status', 'trialing')
            ->where('trial_ends_at', '<=', now())
            ->count();

        // MRR (Monthly Recurring Revenue) — solo suscripciones activas/pagadas
        $mrr = Subscription::where('status', 'active')
            ->join('plans', 'subscriptions.plan_id', '=', 'plans.id')
            ->sum('plans.price_monthly');

        // Movimientos totales plataforma
        $totalMovements = Movement::count();
        $movementsToday = Movement::whereDate('created_at', today())->count();
        $movementsThisMonth = Movement::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        // Productos totales plataforma
        $totalProducts = Product::count();

        // Tenants más recientes
        $recentTenants = Tenant::with(['subscriptions.plan'])
            ->withCount('users')
            ->latest()
            ->take(10)
            ->get();

        // Registros por día (últimos 30 días)
        $registrationsByDay = Tenant::where('created_at', '>=', now()->subDays(29)->startOfDay())
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as total'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $chartData = collect();
        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $dayData = $registrationsByDay->firstWhere('date', $date);
            $chartData->push([
                'date' => now()->subDays($i)->format('d M'),
                'total' => $dayData?->total ?? 0,
            ]);
        }

        return view('superadmin.dashboard', compact(
            'totalTenants', 'activeTenants', 'totalUsers',
            'trialsExpiringSoon', 'activeTrials', 'expiredTrials',
            'mrr', 'totalMovements', 'movementsToday', 'movementsThisMonth',
            'totalProducts', 'recentTenants', 'chartData'
        ));
    }
}
