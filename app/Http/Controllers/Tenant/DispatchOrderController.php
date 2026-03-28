<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\DispatchOrder;
use App\Models\DispatchOrderLine;
use App\Models\Lot;
use App\Models\Movement;
use App\Models\MovementLine;
use App\Models\Product;
use App\Models\StockLevel;
use App\Models\Warehouse;
use App\Services\StockService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DispatchOrderController extends Controller
{
    public function __construct(private StockService $stockService) {}

    public function index(Request $request): View
    {
        $query = DispatchOrder::with(['warehouse', 'createdBy'])->withCount('lines');
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('customer_name', 'like', "%{$search}%")
                  ->orWhere('order_number', 'like', "%{$search}%")
                  ->orWhere('customer_reference', 'like', "%{$search}%");
            });
        }
        if ($status = $request->input('status')) { $query->where('status', $status); }
        $orders = $query->latest()->paginate(25)->withQueryString();
        return view('tenant.dispatch-orders.index', compact('orders'));
    }

    public function create(): View
    {
        $warehouses = Warehouse::where('is_active', true)->get();
        return view('tenant.dispatch-orders.create', compact('warehouses'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'warehouse_id' => ['required', 'exists:warehouses,id'],
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_reference' => ['nullable', 'string', 'max:100'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);
        $order = new DispatchOrder($request->only('warehouse_id', 'customer_name', 'customer_reference', 'notes'));
        $order->created_by = auth()->id();
        $order->tenant_id = auth()->user()->tenant_id;
        $order->status = 'draft';
        $order->order_number = $order->generateOrderNumber();
        $order->save();
        return redirect()->route('tenant.dispatch-orders.select-lots', $order)->with('success', 'Orden creada. Selecciona los productos y lotes.');
    }

    public function selectLots(DispatchOrder $dispatchOrder): View
    {
        if (!in_array($dispatchOrder->status, ['draft', 'reserved'])) {
            return redirect()->route('tenant.dispatch-orders.show', ['dispatch_order' => $dispatchOrder->id]);
        }
        $dispatchOrder->load('lines.product', 'lines.lot');
        $products = Product::where('is_active', true)->orderBy('name')->get();

        // Stock por lote en este almacén
        $stockByProduct = StockLevel::where('warehouse_id', $dispatchOrder->warehouse_id)
            ->where('qty_available', '>', 0)
            ->with(['product', 'lot'])
            ->orderBy('product_id')
            ->get()
            ->groupBy('product_id');

        return view('tenant.dispatch-orders.select-lots', compact('dispatchOrder', 'products', 'stockByProduct'));
    }

    public function addLine(Request $request, DispatchOrder $order): RedirectResponse
    {
        $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'lot_id' => ['nullable', 'exists:lots,id'],
            'quantity' => ['required', 'numeric', 'min:0.01'],
        ]);

        $product = Product::find($request->product_id);

        $stockQuery = StockLevel::where('tenant_id', auth()->user()->tenant_id)
            ->where('product_id', $request->product_id)
            ->where('warehouse_id', $order->warehouse_id);
        if ($request->lot_id) { $stockQuery->where('lot_id', $request->lot_id); }
        else { $stockQuery->whereNull('lot_id'); }
        $stock = $stockQuery->first();

        if (!$stock || $stock->qty_available < $request->quantity) {
            return back()->withErrors(['error' => "Stock insuficiente para {$product->name}. Disponible: " . ($stock?->qty_available ?? 0)])->withInput();
        }

        // Alerta FEFO
        $fefoWarning = null;
        if ($request->lot_id) {
            $selectedLot = Lot::find($request->lot_id);
            if ($selectedLot?->expires_at) {
                $closerLot = Lot::where('product_id', $request->product_id)
                    ->where('id', '!=', $request->lot_id)
                    ->whereNotNull('expires_at')
                    ->where('expires_at', '<', $selectedLot->expires_at)
                    ->whereHas('stockLevels', fn ($q) => $q->where('warehouse_id', $order->warehouse_id)->where('qty_available', '>', 0))
                    ->orderBy('expires_at')->first();
                if ($closerLot) {
                    $fefoWarning = "Atención: existe el lote {$closerLot->lot_number} con caducidad más próxima ({$closerLot->expires_at->format('d/m/Y')}) que el seleccionado ({$selectedLot->expires_at->format('d/m/Y')}).";
                }
            }
        }

        DB::transaction(function () use ($request, $order, $stock) {
            DispatchOrderLine::create([
                'dispatch_order_id' => $order->id,
                'product_id' => $request->product_id,
                'lot_id' => $request->lot_id,
                'quantity_requested' => $request->quantity,
            ]);
            $stock->qty_reserved += $request->quantity;
            $stock->recalculate();
            $stock->save();
            if ($order->status === 'draft') {
                $order->update(['status' => 'reserved', 'reserved_at' => now()]);
            }
        });

        $msg = "{$product->name} x {$request->quantity} agregado y reservado.";
        if ($fefoWarning) { $msg .= " ⚠️ {$fefoWarning}"; }
        return back()->with('success', $msg);
    }

    public function removeLine(DispatchOrder $order, DispatchOrderLine $line): RedirectResponse
    {
        if ($order->status === 'dispatched') { return back()->withErrors(['error' => 'Orden ya despachada.']); }

        DB::transaction(function () use ($order, $line) {
            $stock = StockLevel::where('product_id', $line->product_id)
                ->where('warehouse_id', $order->warehouse_id)
                ->where('lot_id', $line->lot_id)->first();
            if ($stock) {
                $stock->qty_reserved = max(0, $stock->qty_reserved - $line->quantity_requested);
                $stock->recalculate();
                $stock->save();
            }
            $line->delete();
            if ($order->lines()->count() === 0) {
                $order->update(['status' => 'draft', 'reserved_at' => null]);
            }
        });
        return back()->with('success', 'Línea eliminada y stock liberado.');
    }

    public function startPicking(DispatchOrder $order): RedirectResponse
    {
        if ($order->lines->isEmpty()) { return back()->withErrors(['error' => 'Agrega productos primero.']); }
        $order->update(['status' => 'picking', 'picking_started_at' => now()]);
        return redirect()->route('tenant.dispatch-orders.picking', $order)->with('success', 'Picking iniciado.');
    }

    public function picking(DispatchOrder $order): View
    {
        $order->load('lines.product', 'lines.lot', 'warehouse');
        return view('tenant.dispatch-orders.picking', compact('order'));
    }

    public function markPicked(Request $request, DispatchOrder $order, DispatchOrderLine $line): RedirectResponse
    {
        $request->validate(['quantity_picked' => ['required', 'numeric', 'min:0', 'max:' . $line->quantity_requested]]);
        $line->update(['quantity_picked' => $request->quantity_picked, 'is_picked' => true]);

        $order->load('lines');
        if ($order->isFullyPicked()) {
            $order->update(['status' => 'picked', 'picked_at' => now()]);
            return redirect()->route('tenant.dispatch-orders.show', $order)->with('success', 'Picking completo. Listo para despachar.');
        }
        return back()->with('success', 'Línea confirmada.');
    }

    public function dispatch(DispatchOrder $order): RedirectResponse
    {
        if ($order->status !== 'picked') { return back()->withErrors(['error' => 'Completa el picking primero.']); }

        try {
            DB::transaction(function () use ($order) {
                $movement = Movement::create([
                    'warehouse_id' => $order->warehouse_id, 'user_id' => auth()->id(),
                    'type' => 'dispatch', 'reference' => $order->order_number,
                    'notes' => "Despacho a {$order->customer_name}", 'status' => 'draft',
                ]);
                foreach ($order->lines as $line) {
                    MovementLine::create([
                        'movement_id' => $movement->id, 'product_id' => $line->product_id,
                        'lot_id' => $line->lot_id, 'quantity' => $line->quantity_picked,
                    ]);
                    $stock = StockLevel::where('product_id', $line->product_id)
                        ->where('warehouse_id', $order->warehouse_id)
                        ->where('lot_id', $line->lot_id)->first();
                    if ($stock) {
                        $stock->qty_reserved = max(0, $stock->qty_reserved - $line->quantity_requested);
                        $stock->save();
                    }
                }
                $movement->load('lines.product');
                $this->stockService->confirmMovement($movement);
                $order->update(['status' => 'dispatched', 'confirmed_by' => auth()->id(), 'dispatched_at' => now()]);
            });
            return redirect()->route('tenant.dispatch-orders.show', $order)->with('success', 'Despachado correctamente.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error: ' . $e->getMessage()]);
        }
    }

    public function show(DispatchOrder $order): View
    {
        $order->load(['warehouse', 'createdBy', 'confirmedBy', 'lines.product', 'lines.lot']);
        return view('tenant.dispatch-orders.show', compact('order'));
    }

    public function cancel(DispatchOrder $order): RedirectResponse
    {
        if ($order->status === 'dispatched') { return back()->withErrors(['error' => 'No se puede cancelar una orden despachada.']); }
        DB::transaction(function () use ($order) {
            foreach ($order->lines as $line) {
                $stock = StockLevel::where('product_id', $line->product_id)
                    ->where('warehouse_id', $order->warehouse_id)
                    ->where('lot_id', $line->lot_id)->first();
                if ($stock) {
                    $stock->qty_reserved = max(0, $stock->qty_reserved - $line->quantity_requested);
                    $stock->recalculate();
                    $stock->save();
                }
            }
            $order->update(['status' => 'canceled']);
        });
        return redirect()->route('tenant.dispatch-orders.index')->with('success', 'Orden cancelada.');
    }
}
