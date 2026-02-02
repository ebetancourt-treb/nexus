<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuperAdmin\CompanyController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:Super Admin'])->prefix('super-admin')->name('superadmin.')->group(function () {
    
    // Panel Dashboard del Super Admin
    Route::get('/dashboard', function () {
        return view('superadmin.dashboard');
    })->name('dashboard');

    // Gestión de Empresas (Aquí usarás el controller que creamos antes)
    Route::resource('companies', CompanyController::class);
});

// Grupo de rutas para los Clientes (Empresas)
Route::middleware(['auth', 'role:Company Admin'])->group(function () {
    
    Route::get('/dashboard', function () {
        return view('dashboard'); // Dashboard normal de la empresa
    })->name('dashboard');

    // Aquí irán tus módulos futuros (Productos, Ventas, etc.)
    // Route::resource('products', ProductController::class);
});

require __DIR__.'/auth.php';
