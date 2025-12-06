<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\POSController;     // <--- Agregamos esto
use App\Http\Controllers\SaleController;    // <--- Agregamos esto
use App\Models\Product; 
use App\Models\User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. Redirección Inteligente (Lógica de entrada)
Route::get('/', function () {
    if (auth()->check()) {
        // Si es cajero, va a vender
        if (auth()->user()->role === 'cajero') {
            return redirect()->route('pos.index');
        }
        // Si es admin, va al dashboard
        return redirect()->route('dashboard');
    }
    // Si no está logueado, al login
    return redirect()->route('login');
});

// 2. Dashboard (Estadísticas)
Route::get('/dashboard', function () {
    $totalProducts = Product::count();
    $totalCashiers = User::where('role', 'cajero')->count();
    $lowStockProducts = Product::where('stock', '<=', 10)->get();

    return view('dashboard', compact('totalProducts', 'totalCashiers', 'lowStockProducts'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    
    Route::resource('products', ProductController::class);
    Route::resource('cashiers', CashierController::class);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/pos', [POSController::class, 'index'])->name('pos.index');
    
    Route::post('/sales', [SaleController::class, 'store'])->name('sales.store');
});

require __DIR__.'/auth.php';