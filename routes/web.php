<?php

use App\Http\Controllers\SuperAdmin\AuditLogController;
use App\Http\Controllers\SuperAdmin\SubscriptionManagementController;
use App\Http\Controllers\SuperAdmin\SuperAdminDashboardController;
use App\Http\Controllers\SuperAdmin\TenantManagementController;
use App\Http\Controllers\Tenant\CategoryController;
use App\Http\Controllers\Tenant\DashboardController;
use App\Http\Controllers\Tenant\DispatchOrderController;
use App\Http\Controllers\Tenant\MovementController;
use App\Http\Controllers\Tenant\ProductController;
use App\Http\Controllers\Tenant\ProductSearchController;
use App\Http\Controllers\Tenant\StockController;
use App\Http\Controllers\Tenant\StripeController;
use App\Http\Controllers\Tenant\TenantProfileController;
use App\Http\Controllers\Tenant\WarehouseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// ── Landing pública ──
Route::get('/', function () {
    return view('welcome');
});

// ── Redirect inteligente post-login ──
Route::get('/dashboard', function () {
    $user = auth()->user();

    if ($user->isSuperAdmin()) {
        return redirect()->route('superadmin.dashboard');
    }

    return redirect()->route('tenant.dashboard');

})->middleware(['auth', 'verified'])->name('dashboard');

// ── Rutas del SuperAdmin (Treblum) ──
Route::middleware(['auth'])
    ->prefix('super-admin')
    ->name('superadmin.')
    ->group(function () {

        // Middleware manual: verificar que sea superadmin
        Route::middleware([\App\Http\Middleware\EnsureSuperAdmin::class])->group(function () {

            Route::get('/dashboard', [SuperAdminDashboardController::class, 'index'])->name('dashboard');

            // Tenants
            Route::get('/tenants', [TenantManagementController::class, 'index'])->name('tenants.index');
            Route::get('/tenants/{tenant}', [TenantManagementController::class, 'show'])->name('tenants.show');
            Route::patch('/tenants/{tenant}/toggle', [TenantManagementController::class, 'toggleActive'])->name('tenants.toggle');

            // Suscripciones
            Route::get('/subscriptions', [SubscriptionManagementController::class, 'index'])->name('subscriptions.index');
            Route::patch('/subscriptions/{subscription}/change-plan', [SubscriptionManagementController::class, 'changePlan'])->name('subscriptions.change-plan');
            Route::patch('/subscriptions/{subscription}/extend-trial', [SubscriptionManagementController::class, 'extendTrial'])->name('subscriptions.extend-trial');

            // Audit logs
            Route::get('/audit-logs', [AuditLogController::class, 'index'])->name('audit-logs.index');
        });
    });

// ── Rutas del Tenant (empresa cliente) ──
Route::middleware(['auth', 'verified', 'set_warehouse'])

    ->prefix('app')
    ->name('tenant.')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('/profile', [TenantProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [TenantProfileController::class, 'update'])->name('profile.update');
        Route::put('/profile/password', [TenantProfileController::class, 'updatePassword'])->name('profile.password');
        Route::put('/profile/company', [TenantProfileController::class, 'updateCompany'])->name('profile.company');
        Route::delete('/profile', [TenantProfileController::class, 'destroy'])->name('profile.destroy');

        // Almacenes
        Route::resource('warehouses', WarehouseController::class)->except(['show']);
        Route::patch('warehouses/{warehouse}/set-default', [WarehouseController::class, 'setDefault'])->name('warehouses.set-default');

        // Productos
        Route::resource('products', ProductController::class);

        // Categorías (CRUD completo)
        Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
        Route::post('categories', [CategoryController::class, 'store'])->name('categories.store');
        Route::put('categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

        // Existencias
        Route::get('stock', [StockController::class, 'index'])->name('stock.index');

        // API: búsqueda de productos (para scanner/barcode)
        Route::get('api/products/search', [ProductSearchController::class, 'search'])->name('products.search');

        // API: seriales disponibles de un producto en un almacén
        Route::get('api/products/{product}/serials', function (Request $request, \App\Models\Product $product) {
            $warehouseId = $request->input('warehouse_id');
            $serials = \App\Models\SerialNumber::where('product_id', $product->id)
                ->where('status', 'available')
                ->when($warehouseId, fn ($q) => $q->where('warehouse_id', $warehouseId))
                ->orderBy('serial_number')
                ->pluck('serial_number');
            return response()->json($serials);
        })->name('products.serials');

        // Movimientos
        Route::get('movements', [MovementController::class, 'index'])->name('movements.index');
        Route::get('movements/receiving/create', [MovementController::class, 'createReceiving'])->name('movements.create-receiving');
        Route::post('movements/receiving', [MovementController::class, 'storeReceiving'])->name('movements.store-receiving');
        Route::get('movements/dispatch/create', [MovementController::class, 'createDispatch'])->name('movements.create-dispatch');
        Route::post('movements/dispatch', [MovementController::class, 'storeDispatch'])->name('movements.store-dispatch');
        Route::get('movements/{movement}', [MovementController::class, 'show'])->name('movements.show');

        // Órdenes de despacho (farmacéutico)
        Route::get('dispatch-orders', [DispatchOrderController::class, 'index'])->name('dispatch-orders.index');
        Route::get('dispatch-orders/create', [DispatchOrderController::class, 'create'])->name('dispatch-orders.create');
        Route::post('dispatch-orders', [DispatchOrderController::class, 'store'])->name('dispatch-orders.store');
        Route::get('dispatch-orders/{dispatch_order}', [DispatchOrderController::class, 'show'])->name('dispatch-orders.show');
        Route::get('dispatch-orders/{dispatch_order}/select-lots', [DispatchOrderController::class, 'selectLots'])->name('dispatch-orders.select-lots');
        Route::post('dispatch-orders/{dispatch_order}/lines', [DispatchOrderController::class, 'addLine'])->name('dispatch-orders.add-line');
        Route::delete('dispatch-orders/{dispatch_order}/lines/{line}', [DispatchOrderController::class, 'removeLine'])->name('dispatch-orders.remove-line');
        Route::patch('dispatch-orders/{dispatch_order}/start-picking', [DispatchOrderController::class, 'startPicking'])->name('dispatch-orders.start-picking');
        Route::get('dispatch-orders/{dispatch_order}/picking', [DispatchOrderController::class, 'picking'])->name('dispatch-orders.picking');
        Route::patch('dispatch-orders/{dispatch_order}/lines/{line}/picked', [DispatchOrderController::class, 'markPicked'])->name('dispatch-orders.mark-picked');
        Route::patch('dispatch-orders/{dispatch_order}/dispatch', [DispatchOrderController::class, 'dispatch'])->name('dispatch-orders.dispatch');
        Route::patch('dispatch-orders/{dispatch_order}/cancel', [DispatchOrderController::class, 'cancel'])->name('dispatch-orders.cancel');
        Route::get('dispatch-orders/{dispatch_order}/picking-pdf', function (\App\Models\DispatchOrder $dispatch_order) {
            $dispatch_order->load('lines.product', 'lines.lot', 'warehouse');
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('tenant.dispatch-orders.picking-pdf', ['order' => $dispatch_order]);
            return $pdf->stream("picking-{$dispatch_order->order_number}.pdf");
        })->name('dispatch-orders.picking-pdf');
        Route::get('dispatch-orders/{dispatch_order}/exit-pdf', function (\App\Models\DispatchOrder $dispatch_order) {
            $dispatch_order->load('lines.product', 'lines.lot', 'warehouse', 'confirmedBy');
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('tenant.dispatch-orders.exit-pdf', ['order' => $dispatch_order]);
            return $pdf->stream("salida-{$dispatch_order->order_number}.pdf");
        })->name('dispatch-orders.exit-pdf');

        // Órdenes de despacho (flujo farmacéutico)
        Route::get('dispatch-orders', [DispatchOrderController::class, 'index'])->name('dispatch-orders.index');
        Route::get('dispatch-orders/create', [DispatchOrderController::class, 'create'])->name('dispatch-orders.create');
        Route::post('dispatch-orders', [DispatchOrderController::class, 'store'])->name('dispatch-orders.store');
        Route::get('dispatch-orders/{dispatch_order}', [DispatchOrderController::class, 'show'])->name('dispatch-orders.show');
        Route::get('dispatch-orders/{dispatch_order}/select-lots', [DispatchOrderController::class, 'selectLots'])->name('dispatch-orders.select-lots');
        Route::post('dispatch-orders/{dispatch_order}/lines', [DispatchOrderController::class, 'addLine'])->name('dispatch-orders.add-line');
        Route::delete('dispatch-orders/{dispatch_order}/lines/{line}', [DispatchOrderController::class, 'removeLine'])->name('dispatch-orders.remove-line');
        Route::post('dispatch-orders/{dispatch_order}/reserve', [DispatchOrderController::class, 'reserve'])->name('dispatch-orders.reserve');
        Route::post('dispatch-orders/{dispatch_order}/start-picking', [DispatchOrderController::class, 'startPicking'])->name('dispatch-orders.start-picking');
        Route::get('dispatch-orders/{dispatch_order}/picking', [DispatchOrderController::class, 'picking'])->name('dispatch-orders.picking');
        Route::post('dispatch-orders/{dispatch_order}/lines/{line}/pick', [DispatchOrderController::class, 'pickLine'])->name('dispatch-orders.pick-line');
        Route::post('dispatch-orders/{dispatch_order}/confirm', [DispatchOrderController::class, 'confirmDispatch'])->name('dispatch-orders.confirm');
        Route::post('dispatch-orders/{dispatch_order}/cancel', [DispatchOrderController::class, 'cancel'])->name('dispatch-orders.cancel');

        // Billing / Stripe
        Route::get('billing/plans', [StripeController::class, 'plans'])->name('billing.plans');
        Route::post('billing/checkout/{plan}', [StripeController::class, 'checkout'])->name('billing.checkout');
        Route::get('billing/success', [StripeController::class, 'success'])->name('billing.success');
        Route::get('billing/portal', [StripeController::class, 'portal'])->name('billing.portal');
        Route::post('billing/change-plan/{plan}', [StripeController::class, 'changePlan'])->name('billing.change-plan');
        Route::post('billing/cancel', [StripeController::class, 'cancel'])->name('billing.cancel');
        Route::post('billing/resume', [StripeController::class, 'resume'])->name('billing.resume');
    });

// Webhook de Stripe (sin auth, sin CSRF)
Route::post('stripe/webhook', [\App\Http\Controllers\StripeWebhookController::class, 'handleWebhook'])->name('stripe.webhook');

Route::middleware('auth')->group(function () {
    Route::get('verify-email', [\App\Http\Controllers\Auth\EmailVerificationController::class, 'show'])->name('verification.notice');
    Route::post('verify-email', [\App\Http\Controllers\Auth\EmailVerificationController::class, 'verify'])->name('verification.verify');
    Route::post('verify-email/send', [\App\Http\Controllers\Auth\EmailVerificationController::class, 'send'])->name('verification.send');
});

require __DIR__.'/auth.php';
