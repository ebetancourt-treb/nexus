<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Movement;
use App\Models\Product;
use App\Models\StockLevel;
use App\Models\Warehouse;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $tenant = auth()->user()->tenant;
        $subscription = $tenant?->activeSubscription;
        $plan = $subscription?->plan;

        // Stats
        $stats = [
            'warehouses' => Warehouse::count(),
            'warehouses_limit' => $plan?->max_warehouses ?? 0,
            'products' => Product::count(),
            'products_limit' => $plan?->max_skus ?? 0,
            'users' => $tenant->users()->count(),
            'users_limit' => $plan?->max_users ?? 0,
            'movements_today' => Movement::whereDate('created_at', today())->count(),
            'total_units' => StockLevel::sum('qty_on_hand'),
            'inventory_value' => StockLevel::join('products', 'stock_levels.product_id', '=', 'products.id')
                ->selectRaw('SUM(stock_levels.qty_on_hand * products.cost_price) as value')
                ->value('value') ?? 0,
        ];

        // Últimos movimientos (actividad reciente)
        $recentMovements = Movement::with(['user', 'warehouse'])
            ->latest()
            ->take(10)
            ->get();

        // Alertas de stock bajo
        $lowStockAlerts = Product::where('reorder_point', '>', 0)
            ->where('is_active', true)
            ->get()
            ->filter(fn ($product) => $product->isLowStock())
            ->take(10);

        // Gráfica: movimientos por día (últimos 14 días)
        $movementsByDay = Movement::where('created_at', '>=', now()->subDays(13)->startOfDay())
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as total'),
                DB::raw("SUM(CASE WHEN type IN ('receiving', 'transfer_in', 'return') THEN 1 ELSE 0 END) as entries"),
                DB::raw("SUM(CASE WHEN type IN ('dispatch', 'transfer_out') THEN 1 ELSE 0 END) as exits"),
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Rellenar días sin movimientos con 0
        $chartData = collect();
        for ($i = 13; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $dayData = $movementsByDay->firstWhere('date', $date);
            $chartData->push([
                'date' => now()->subDays($i)->format('d M'),
                'entries' => $dayData?->entries ?? 0,
                'exits' => $dayData?->exits ?? 0,
            ]);
        }

        // Trial info
        $trialDaysLeft = null;
        if ($subscription?->isTrialing()) {
            $trialDaysLeft = (int) now()->diffInDays($subscription->trial_ends_at, false);
        }

        return view('tenant.dashboard', compact(
            'tenant',
            'subscription',
            'plan',
            'stats',
            'recentMovements',
            'lowStockAlerts',
            'chartData',
            'trialDaysLeft',
        ));
    }
}
