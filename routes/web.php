<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuperAdmin\TenantController;

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
    
    Route::get('/dashboard', function () {
        return view('superadmin.dashboard');
    })->name('dashboard');

    Route::resource('tenants', TenantController::class);
});

Route::middleware(['auth', 'role:Company Admin'])->group(function () {
    
    Route::get('/dashboard', function () {
        return view('dashboard'); // Dashboard normal de la empresa
    })->name('dashboard');

});

require __DIR__.'/auth.php';
