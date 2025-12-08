<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Muestra la lista de productos
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    // Muestra el formulario para crear
    public function create()
    {
        return view('products.create');
    }

    // GUARDA EL PRODUCTO (VALIDACIÓN ESTRICTA)
    public function store(Request $request)
    {
        // 1. Reglas de Validación
        $rules = [
            'barcode' => ['required', 'numeric', 'digits:12', 'unique:products,barcode'],
            'name'    => ['required', 'string', 'regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ]/'], // Debe empezar con letra
            'price'   => ['required', 'numeric', 'min:0'],
            'stock'   => ['required', 'integer', 'min:0'],
        ];

        // 2. Mensajes de Error Personalizados
        $messages = [
            'barcode.required' => 'El código de barras es obligatorio.',
            'barcode.numeric'  => 'El código de barras solo debe contener números.',
            'barcode.digits'   => 'El código de barras debe tener exactamente 12 dígitos.',
            'barcode.unique'   => 'Este código de barras ya está registrado.',
            
            'name.required'    => 'El nombre del producto es obligatorio.',
            'name.regex'       => 'El nombre debe comenzar con una letra.',
            
            'price.required'   => 'El precio es obligatorio.',
            'price.numeric'    => 'El precio debe ser un número válido.',
            'price.min'        => 'El precio no puede ser negativo.',
            
            'stock.required'   => 'El stock es obligatorio.',
            'stock.integer'    => 'El stock debe ser un número entero (sin decimales).',
            'stock.min'        => 'El stock no puede ser negativo.',
        ];

        // Ejecutar validación
        $request->validate($rules, $messages);

        // Si pasa, guardamos
        Product::create($request->all());

        return redirect()->route('products.index')
                         ->with('success', 'Producto creado exitosamente.');
    }

    // Muestra el formulario de edición
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('products.edit', compact('product'));
    }

    // ACTUALIZA EL PRODUCTO (VALIDACIÓN ESTRICTA)
    public function update(Request $request, $id)
    {
        // 1. Reglas (Ignoramos el ID actual en la validación unique)
        $rules = [
            'barcode' => ['required', 'numeric', 'digits:12', 'unique:products,barcode,'.$id],
            'name'    => ['required', 'string', 'regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ]/'],
            'price'   => ['required', 'numeric', 'min:0'],
            'stock'   => ['required', 'integer', 'min:0'],
        ];

        // 2. Mensajes (Los mismos de arriba)
        $messages = [
            'barcode.digits'   => 'El código de barras debe tener exactamente 12 dígitos.',
            'barcode.unique'   => 'Este código de barras ya pertenece a otro producto.',
            'name.regex'       => 'El nombre debe comenzar con una letra.',
            'price.numeric'    => 'El precio debe ser un número.',
            'stock.integer'    => 'El stock debe ser un número entero.',
        ];

        $request->validate($rules, $messages);

        // Buscar y actualizar
        $product = Product::findOrFail($id);
        
        $product->update([
            'barcode' => $request->barcode,
            'name'    => $request->name,
            'price'   => $request->price,
            'stock'   => $request->stock,
            'has_iva' => $request->has('has_iva'), 
        ]);

        return redirect()->route('products.index')
                         ->with('success', 'Producto actualizado correctamente.');
    }

    // Eliminar producto
    public function destroy($id)
    {
        // Solo permitimos eliminar si el usuario tiene permiso (Extra seguridad)
        if (!auth()->user()->can_delete_products && auth()->user()->role !== 'administrador') {
            abort(403, 'No tienes permiso para eliminar productos.');
        }

        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('products.index')
                         ->with('success', 'Producto eliminado.');
    }
}