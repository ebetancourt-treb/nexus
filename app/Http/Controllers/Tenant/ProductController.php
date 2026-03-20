<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $query = Product::with('category')
            ->withSum(['stockLevels as total_stock' => fn ($q) => $q->where('status', 'available')], 'qty_available');

        // Búsqueda
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%")
                  ->orWhere('barcode', 'like', "%{$search}%");
            });
        }

        // Filtro por categoría
        if ($categoryId = $request->input('category')) {
            $query->where('category_id', $categoryId);
        }

        // Filtro por estado
        if ($request->input('status') === 'active') {
            $query->where('is_active', true);
        } elseif ($request->input('status') === 'inactive') {
            $query->where('is_active', false);
        }

        // Filtro stock bajo
        if ($request->input('low_stock')) {
            $query->where('reorder_point', '>', 0)
                ->whereHas('stockLevels', function ($q) {
                    $q->havingRaw('SUM(qty_available) <= products.reorder_point');
                });
        }

        $products = $query->latest()->paginate(25)->withQueryString();
        $categories = Category::orderBy('name')->get();

        // Contadores para filtros
        $totalProducts = Product::count();
        $activeProducts = Product::where('is_active', true)->count();

        return view('tenant.products.index', compact(
            'products', 'categories', 'totalProducts', 'activeProducts'
        ));
    }

    public function create(): View
    {
        $tenant = auth()->user()->tenant;
        $plan = $tenant->currentPlan();
        $currentCount = Product::count();

        if ($plan && !$tenant->isWithinLimit('max_skus', $currentCount)) {
            return view('tenant.products.limit-reached', [
                'limit' => $plan->max_skus,
                'planName' => $plan->name,
            ]);
        }

        $categories = Category::orderBy('name')->get();

        return view('tenant.products.create', compact('categories'));
    }

    public function store(StoreProductRequest $request): RedirectResponse
    {
        $tenant = auth()->user()->tenant;
        $plan = $tenant->currentPlan();
        $currentCount = Product::count();

        if ($plan && !$tenant->isWithinLimit('max_skus', $currentCount)) {
            return back()->withErrors(['limit' => 'Has alcanzado el límite de productos de tu plan.']);
        }

        Product::create($request->validated());

        return redirect()->route('tenant.products.index')
            ->with('success', 'Producto creado correctamente.');
    }

    public function show(Product $product): View
    {
        $product->load(['category', 'lots' => fn ($q) => $q->latest()->take(10)]);

        $stockByWarehouse = $product->stockLevels()
            ->with('warehouse')
            ->selectRaw('warehouse_id, SUM(qty_on_hand) as total_on_hand, SUM(qty_available) as total_available, SUM(qty_reserved) as total_reserved')
            ->groupBy('warehouse_id')
            ->get();

        $recentMovements = $product->movementLines()
            ->with(['movement.user', 'movement.warehouse'])
            ->latest('id')
            ->take(15)
            ->get();

        return view('tenant.products.show', compact('product', 'stockByWarehouse', 'recentMovements'));
    }

    public function edit(Product $product): View
    {
        $categories = Category::orderBy('name')->get();

        return view('tenant.products.edit', compact('product', 'categories'));
    }

    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
    {
        $product->update($request->validated());

        return redirect()->route('tenant.products.index')
            ->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        if ($product->stockLevels()->where('qty_on_hand', '>', 0)->exists()) {
            return back()->withErrors(['delete' => 'No puedes eliminar un producto con stock. Ajusta el inventario a 0 primero.']);
        }

        $product->delete(); // Soft delete

        return redirect()->route('tenant.products.index')
            ->with('success', 'Producto eliminado correctamente.');
    }
}
