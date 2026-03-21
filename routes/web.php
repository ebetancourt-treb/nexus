<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SuperAdmin\AuditLogController;
use App\Http\Controllers\SuperAdmin\SubscriptionManagementController;
use App\Http\Controllers\SuperAdmin\SuperAdminDashboardController;
use App\Http\Controllers\SuperAdmin\TenantManagementController;
use App\Http\Controllers\Tenant\CategoryController;
use App\Http\Controllers\Tenant\DashboardController;
use App\Http\Controllers\Tenant\MovementController;
use App\Http\Controllers\Tenant\ProductController;
use App\Http\Controllers\Tenant\ProductSearchController;
use App\Http\Controllers\Tenant\StockController;
use App\Http\Controllers\Tenant\WarehouseController;
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
Route::middleware(['auth', 'set_warehouse'])
    ->prefix('app')
    ->name('tenant.')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('tenant.profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

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

        // Movimientos
        Route::get('movements', [MovementController::class, 'index'])->name('movements.index');
        Route::get('movements/receiving/create', [MovementController::class, 'createReceiving'])->name('movements.create-receiving');
        Route::post('movements/receiving', [MovementController::class, 'storeReceiving'])->name('movements.store-receiving');
        Route::get('movements/dispatch/create', [MovementController::class, 'createDispatch'])->name('movements.create-dispatch');
        Route::post('movements/dispatch', [MovementController::class, 'storeDispatch'])->name('movements.store-dispatch');
        Route::get('movements/{movement}', [MovementController::class, 'show'])->name('movements.show');
    });

require __DIR__.'/auth.php';
