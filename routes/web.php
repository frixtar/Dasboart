<?php

use Illuminate\Support\Facades\Route;

Route::get('/controlador', [\App\Http\Controllers\HolaController::class, 'index']);
