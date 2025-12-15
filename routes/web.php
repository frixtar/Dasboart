<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\CategoryController; // Controlador de Categorías
use App\Http\Controllers\POSController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\DashboardController;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        if (auth()->user()->role === 'cajero') {
            return redirect()->route('pos.index');
        }
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});
Route::get('/dashboard', function () {
    $totalProducts = Product::count();
    $totalCashiers = User::where('role', 'cajero')->count();
    $lowStockProducts = Product::where('stock', '<=', 10)->get();
    return view('dashboard', compact('totalProducts', 'totalCashiers', 'lowStockProducts'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/reports', [DashboardController::class, 'index'])->name('reports.index');
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::resource('cashiers', CashierController::class);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/pos', [POSController::class, 'index'])->name('pos.index');
    Route::post('/sales', [SaleController::class, 'store'])->name('sales.store');
    Route::get('/sales/{sale}/ticket', [SaleController::class, 'ticket'])->name('sales.ticket');
});

require __DIR__.'/auth.php';