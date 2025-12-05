<?php

namespace App\Http\Controllers;

use App\Models\Product; // <--- No olvides importar el modelo
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Muestra la lista de productos
    public function index()
    {
        $products = Product::all(); // Trae todo de la BD
        return view('products.index', compact('products'));
    }

    // Muestra el formulario para crear
    public function create()
    {
        return view('products.create');
    }
public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('products.edit', compact('product'));
    }

    // Procesa la actualización en la base de datos
    public function update(Request $request, $id)
    {
        // Validación
        $request->validate([
            // Validamos que el código de barras sea único, pero ignoramos el ID actual
            // para que no marque error si no cambiamos el código.
            'barcode' => 'required|unique:products,barcode,'.$id, 
            'name'    => 'required',
            'price'   => 'required|numeric',
            'stock'   => 'required|integer',
        ]);

        // Buscar y actualizar
        $product = Product::findOrFail($id);
        
        $product->update([
            'barcode' => $request->barcode,
            'name'    => $request->name,
            'price'   => $request->price,
            'stock'   => $request->stock,
            // Convertimos el checkbox (que envía 'on' o nada) a booleano (1 o 0)
            'has_iva' => $request->has('has_iva'), 
        ]);

        return redirect()->route('products.index')
                         ->with('success', 'Producto actualizado correctamente.');
    }
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('products.index')
                         ->with('success', 'Producto eliminado correctamente.');
    }
    // Guarda el producto en la BD (Ya lo tenías, lo repito por si acaso)
    public function store(Request $request)
    {
        $request->validate([
            'barcode' => 'required|unique:products,barcode',
            'name' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
        ]);

        Product::create($request->all());

        return redirect()->route('products.index')
                         ->with('success', 'Producto guardado correctamente.');
    }
}