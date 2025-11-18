<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () { return view('dashboard'); })->name('dashboard');

    Route::resource('products', ProductController::class);
    Route::resource('clients', ClientController::class);
    Route::resource('sales', SaleController::class);
});


require __DIR__.'/auth.php';
