<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Services\OdooService;
use Illuminate\Support\Facades\Log;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    protected $odoo;
    public function __construct(OdooService $odoo)
    {
        $this->odoo = $odoo;
    }

    public function odooIndex(Request $request): View
    {
        $odooProducts = [];
        $error = null;

        try {
            // Hacemos la consulta en tiempo real al ERP
            $odooProducts = $this->odoo->executeKw(
                'product.template',
                'search_read',
                [
                    [] // Filtro vacío = traer todos
                ],
                [
                    'fields' => ['name', 'qty_available', 'list_price', 'barcode', 'default_code'],
                    'limit' => 50 // Limitamos a 50 para que la demo cargue rapidísimo
                ]
            );
        } catch (\Exception $e) {
            Log::error('Error conectando a Odoo en demo: ' . $e->getMessage());
            $error = 'No se pudo establecer conexión con el ERP en este momento.';
        }

        return view('tenant.products.odoo_index', compact('odooProducts', 'error'));
    }


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
        $canTrackLots = $tenant->hasFeature('lots.enabled');
        $canTrackSerials = $tenant->hasFeature('serials.enabled');

        return view('tenant.products.create', compact('categories', 'canTrackLots', 'canTrackSerials'));
    }

    public function store(StoreProductRequest $request): RedirectResponse
    {
        $tenant = auth()->user()->tenant;
        $plan = $tenant->currentPlan();
        $currentCount = Product::count();

        if ($plan && !$tenant->isWithinLimit('max_skus', $currentCount)) {
            return back()->withErrors(['limit' => 'Has alcanzado el límite de productos de tu plan.']);
        }

        // Validar features de tracking
        if ($request->boolean('track_lots') && !$tenant->hasFeature('lots.enabled')) {
            return back()->withErrors(['track_lots' => 'Tu plan no incluye control por lotes. Actualiza tu plan para activar esta opción.'])->withInput();
        }

        if ($request->boolean('track_serials') && !$tenant->hasFeature('serials.enabled')) {
            return back()->withErrors(['track_serials' => 'Tu plan no incluye control por número de serie. Actualiza tu plan para activar esta opción.'])->withInput();
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
        $tenant = auth()->user()->tenant;
        $categories = Category::orderBy('name')->get();
        $canTrackLots = $tenant->hasFeature('lots.enabled');
        $canTrackSerials = $tenant->hasFeature('serials.enabled');

        return view('tenant.products.edit', compact('product', 'categories', 'canTrackLots', 'canTrackSerials'));
    }

    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
    {
        $tenant = auth()->user()->tenant;

        // Validar features de tracking (solo si se están activando, no si ya estaban)
        if ($request->boolean('track_lots') && !$product->track_lots && !$tenant->hasFeature('lots.enabled')) {
            return back()->withErrors(['track_lots' => 'Tu plan no incluye control por lotes.'])->withInput();
        }

        if ($request->boolean('track_serials') && !$product->track_serials && !$tenant->hasFeature('serials.enabled')) {
            return back()->withErrors(['track_serials' => 'Tu plan no incluye control por número de serie.'])->withInput();
        }

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

    public function simularCreacionOdoo(Request $request): RedirectResponse
    {
        try {
            
            $random = rand(100, 999); 

            $nuevoProductoId = $this->odoo->executeKw(
                'product.template',
                'create',
                [
                    [ 
                        'name' => 'Producto de Prueba desde Treblum ' . $random,
                        'is_storable' => true,
                        'list_price' => 150.00,
                        'standard_price' => 100.00,
                        'default_code' => 'DEMO-TB-' . $random,
                        'barcode' => '750123456' . $random,
                    ]
                ]
            );

            return back()->with('success', '¡Magia! Producto creado en Odoo exitosamente. El ID en el ERP es: ' . $nuevoProductoId);
            
        } catch (\Exception $e) {
            Log::error('Error creando en Odoo: ' . $e->getMessage());
            return back()->withErrors(['odoo' => 'Error al comunicar con Odoo: Revisa los logs.']);
        }
    }
}
