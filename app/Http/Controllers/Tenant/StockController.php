<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\StockLevel;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class StockController extends Controller
{
    public function index(Request $request): View
    {
        $warehouseId = $request->input('warehouse');
        $warehouses = Warehouse::where('is_active', true)->get();

        // Si no se seleccionó almacén, usar el activo en sesión o el default
        if (!$warehouseId) {
            $warehouseId = session('active_warehouse_id')
                ?? Warehouse::where('is_default', true)->value('id')
                ?? $warehouses->first()?->id;
        }

        $query = StockLevel::select(
                'product_id',
                'warehouse_id',
                DB::raw('SUM(qty_on_hand) as total_on_hand'),
                DB::raw('SUM(qty_reserved) as total_reserved'),
                DB::raw('SUM(qty_available) as total_available'),
            )
            ->with(['product.category', 'warehouse'])
            ->groupBy('product_id', 'warehouse_id');

        if ($warehouseId && $warehouseId !== 'all') {
            $query->where('warehouse_id', $warehouseId);
        }

        // Búsqueda por producto
        if ($search = $request->input('search')) {
            $query->whereHas('product', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%")
                  ->orWhere('barcode', 'like', "%{$search}%");
            });
        }

        // Filtro por categoría
        if ($categoryId = $request->input('category')) {
            $query->whereHas('product', fn ($q) => $q->where('category_id', $categoryId));
        }

        // Filtro stock bajo
        if ($request->input('low_stock')) {
            $query->havingRaw('SUM(qty_available) <= 0')
                ->orHavingRaw('SUM(qty_available) <= (SELECT reorder_point FROM products WHERE products.id = stock_levels.product_id AND reorder_point > 0)');
        }

        $stockItems = $query->orderBy('total_on_hand', 'desc')->paginate(30)->withQueryString();
        $categories = Category::orderBy('name')->get();

        // Resumen general
        $summary = StockLevel::when($warehouseId && $warehouseId !== 'all', fn ($q) => $q->where('warehouse_id', $warehouseId))
            ->selectRaw('COUNT(DISTINCT product_id) as total_products, SUM(qty_on_hand) as total_units, SUM(qty_available) as total_available')
            ->first();

        return view('tenant.stock.index', compact(
            'stockItems', 'warehouses', 'categories', 'warehouseId', 'summary'
        ));
    }
}
