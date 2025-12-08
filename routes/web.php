<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\POSController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\DashboardController;
use App\Models\Product;
use App\Models\User; // <--- Necesario para contar cajeros
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. Redirección Inteligente al entrar al sitio
Route::get('/', function () {
    if (auth()->check()) {
        if (auth()->user()->role === 'cajero') {
            return redirect()->route('pos.index');
        }
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

// 2. RUTA DE INICIO (DASHBOARD GENERAL)
// Aquí es donde arreglamos el error: Calculamos y pasamos todas las variables.
Route::get('/dashboard', function () {
    
    // Contadores para las tarjetas
    $totalProducts = Product::count();
    $totalCashiers = User::where('role', 'cajero')->count();
    $lowStockProducts = Product::where('stock', '<=', 10)->get();

    // Enviamos TODO a la vista
    return view('dashboard', compact('totalProducts', 'totalCashiers', 'lowStockProducts'));

})->middleware(['auth', 'verified'])->name('dashboard');


// 3. GRUPO PROTEGIDO (Funciones del Sistema)
Route::middleware('auth')->group(function () {
    
    // Reportes Avanzados (Controlador dedicado)
    Route::get('/reports', [DashboardController::class, 'index'])->name('reports.index');

    // Gestión (Admin)
    Route::resource('products', ProductController::class);
    Route::resource('cashiers', CashierController::class);

    // Perfil de Usuario
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Punto de Venta (POS)
    Route::get('/pos', [POSController::class, 'index'])->name('pos.index');
    Route::post('/sales', [SaleController::class, 'store'])->name('sales.store');
});

require __DIR__.'/auth.php';