<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class POSController extends Controller
{
    public function index()
    {
        // Cargamos todos los productos para tenerlos listos (Optimización básica)
        // En un futuro, si son miles, usaremos paginación o búsqueda AJAX.
        $products = Product::where('stock', '>', 0)->get();
        return view('pos.index', compact('products'));
    }
}