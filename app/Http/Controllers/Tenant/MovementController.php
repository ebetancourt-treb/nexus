<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Lot;
use App\Models\Movement;
use App\Models\MovementLine;
use App\Models\Product;
use App\Models\Warehouse;
use App\Services\StockService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class MovementController extends Controller
{
    public function __construct(
        private StockService $stockService
    ) {}

    public function index(Request $request): View
    {
        $query = Movement::with(['user', 'warehouse'])
            ->withCount('lines');

        if ($search = $request->input('search')) {
            $query->where('reference', 'like', "%{$search}%");
        }

        if ($type = $request->input('type')) {
            $query->where('type', $type);
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        if ($warehouseId = $request->input('warehouse')) {
            $query->where('warehouse_id', $warehouseId);
        }

        $movements = $query->latest()->paginate(25)->withQueryString();
        $warehouses = Warehouse::where('is_active', true)->get();

        return view('tenant.movements.index', compact('movements', 'warehouses'));
    }

    /**
     * Formulario de nueva recepción.
     */
    public function createReceiving(): View
    {
        $warehouses = Warehouse::where('is_active', true)->get();
        $products = Product::where('is_active', true)->orderBy('name')->get();

        $productsJson = $products->map(function ($p) {
            return [
                'id' => $p->id,
                'name' => $p->name,
                'sku' => $p->sku,
                'track_lots' => $p->track_lots,
            ];
        })->values();

        return view('tenant.movements.create-receiving', compact('warehouses', 'products', 'productsJson'));
    }

    /**
     * Guardar recepción (con soporte multi-lote en un solo movimiento).
     */
    public function storeReceiving(Request $request): RedirectResponse
    {
        $request->validate([
            'warehouse_id' => ['required', 'exists:warehouses,id'],
            'reference' => ['nullable', 'string', 'max:50'],
            'notes' => ['nullable', 'string', 'max:500'],
            'lines' => ['required', 'array', 'min:1'],
            'lines.*.product_id' => ['required', 'exists:products,id'],
            'lines.*.quantity' => ['required', 'numeric', 'min:0.01'],
            'lines.*.unit_cost' => ['nullable', 'numeric', 'min:0'],
            'lines.*.lot_number' => ['nullable', 'string', 'max:50'],
            'lines.*.expires_at' => ['nullable', 'date'],
        ]);

        try {
            DB::transaction(function () use ($request) {
                $movement = Movement::create([
                    'warehouse_id' => $request->warehouse_id,
                    'user_id' => auth()->id(),
                    'type' => 'receiving',
                    'reference' => $request->reference,
                    'notes' => $request->notes,
                    'status' => 'draft',
                ]);

                foreach ($request->lines as $lineData) {
                    $lotId = null;

                    // Si el producto tiene tracking de lotes y se proporcionó número
                    if (!empty($lineData['lot_number'])) {
                        $product = Product::find($lineData['product_id']);

                        $lot = Lot::firstOrCreate(
                            [
                                'tenant_id' => auth()->user()->tenant_id,
                                'product_id' => $lineData['product_id'],
                                'lot_number' => $lineData['lot_number'],
                            ],
                            [
                                'expires_at' => $lineData['expires_at'] ?? null,
                                'status' => 'released',
                            ]
                        );

                        $lotId = $lot->id;
                    }

                    MovementLine::create([
                        'movement_id' => $movement->id,
                        'product_id' => $lineData['product_id'],
                        'lot_id' => $lotId,
                        'quantity' => abs($lineData['quantity']),
                        'unit_cost' => $lineData['unit_cost'] ?? 0,
                    ]);
                }

                // Confirmar automáticamente
                $movement->load('lines.product');
                $this->stockService->confirmMovement($movement);
            });

            return redirect()->route('tenant.movements.index')
                ->with('success', 'Recepción registrada y stock actualizado correctamente.');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al registrar la recepción: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Formulario de nuevo despacho.
     */
    public function createDispatch(): View
    {
        $warehouses = Warehouse::where('is_active', true)->get();
        $products = Product::where('is_active', true)->orderBy('name')->get();

        $productsJson = $products->map(function ($p) {
            return [
                'id' => $p->id,
                'name' => $p->name,
                'sku' => $p->sku,
            ];
        })->values();

        return view('tenant.movements.create-dispatch', compact('warehouses', 'products', 'productsJson'));
    }

    /**
     * Guardar despacho (salida de mercancía).
     */
    public function storeDispatch(Request $request): RedirectResponse
    {
        $request->validate([
            'warehouse_id' => ['required', 'exists:warehouses,id'],
            'reference' => ['nullable', 'string', 'max:50'],
            'notes' => ['nullable', 'string', 'max:500'],
            'lines' => ['required', 'array', 'min:1'],
            'lines.*.product_id' => ['required', 'exists:products,id'],
            'lines.*.quantity' => ['required', 'numeric', 'min:0.01'],
        ]);

        // Verificar stock antes de crear
        foreach ($request->lines as $lineData) {
            if (!$this->stockService->hasEnoughStock(
                auth()->user()->tenant_id,
                $lineData['product_id'],
                $request->warehouse_id,
                $lineData['quantity']
            )) {
                $product = Product::find($lineData['product_id']);
                return back()->withErrors([
                    'error' => "Stock insuficiente para {$product->name}."
                ])->withInput();
            }
        }

        try {
            DB::transaction(function () use ($request) {
                $movement = Movement::create([
                    'warehouse_id' => $request->warehouse_id,
                    'user_id' => auth()->id(),
                    'type' => 'dispatch',
                    'reference' => $request->reference,
                    'notes' => $request->notes,
                    'status' => 'draft',
                ]);

                foreach ($request->lines as $lineData) {
                    MovementLine::create([
                        'movement_id' => $movement->id,
                        'product_id' => $lineData['product_id'],
                        'quantity' => abs($lineData['quantity']),
                    ]);
                }

                $movement->load('lines.product');
                $this->stockService->confirmMovement($movement);
            });

            return redirect()->route('tenant.movements.index')
                ->with('success', 'Despacho registrado y stock actualizado correctamente.');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al registrar el despacho: ' . $e->getMessage()])->withInput();
        }
    }

    public function show(Movement $movement): View
    {
        $movement->load(['user', 'warehouse', 'lines.product', 'lines.lot', 'lines.location']);

        return view('tenant.movements.show', compact('movement'));
    }
}
