<?php

use App\Http\Controllers\ProfileController; // <--- IMPORTANTE: Agrega esto
use App\Http\Controllers\ProductController;
use App\Models\Product; 
use App\Models\User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    // Si el usuario ya inició sesión, mándalo directo al Dashboard
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    // Si no ha iniciado sesión, mándalo al Login
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    $totalProducts = Product::count();
    
    $totalCashiers = User::where('role', 'cajero')->count();
    
    $lowStockProducts = Product::where('stock', '<=', 10)->get();

    return view('dashboard', compact('totalProducts', 'totalCashiers', 'lowStockProducts'));
})->middleware(['auth', 'verified'])->name('dashboard');

// Grupo de rutas protegidas (Solo usuarios logueados)
Route::middleware('auth')->group(function () {
    
    // Rutas para PRODUCTOS
    Route::resource('products', ProductController::class);

    // Rutas para PERFIL
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('cashiers', App\Http\Controllers\CashierController::class);
});


require __DIR__.'/auth.php';