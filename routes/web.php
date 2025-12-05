<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\SaleController;
use Illuminate\Support\Facades\Route;

// 🔹 Primera ruta: manda al login
Route::get('/', function () {
    return redirect()->route('login');
});

// 🔹 Todo lo demás requiere autenticación
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', function () { 
        return view('dashboard'); 
    })->name('dashboard');

    // Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // CRUDs
    Route::resource('products', ProductController::class);
    Route::resource('clientes', ClientController::class);
    Route::resource('sales', SaleController::class);

    // KPIs
    Route::get('/kpis', function () {
        return view('kpis.index');
    })->name('kpis.index');

});

require __DIR__.'/auth.php';
