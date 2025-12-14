<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->get();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // 1. Reglas de Validación Personalizadas
        $rules = [
            // Barcode: Exactamente 12 dígitos
            'barcode' => ['required', 'numeric', 'digits:12', 'unique:products,barcode'],
            
            // Nombre: Mínimo 3, Máximo 20 caracteres
            'name'    => ['required', 'string', 'min:3', 'max:20'],
            
            // Categoría: Obligatoria
            'category_id'=> ['required', 'exists:categories,id'],
            
            // Precio: Numérico, Positivo, Máximo 99999 (5 dígitos enteros)
            'price'   => ['required', 'numeric', 'min:0', 'max:99999'],
            
            // Stock: Entero, Mínimo 0, Máximo 1000
            'stock'   => ['required', 'integer', 'min:0', 'max:1000'],
            
            // Fecha: Obligatoria y debe ser futura (para evitar vender caducados de entrada)
            'expiration_date' => ['required', 'date', 'after:today'],
        ];

        // 2. Mensajes de Error en Español
        $messages = [
            'barcode.digits' => 'El código debe tener exactamente 12 dígitos.',
            'barcode.unique' => 'Este código de barras ya está registrado.',
            'barcode.numeric'=> 'El código solo debe contener números.',
            
            'name.min'       => 'El nombre es muy corto (mínimo 3 letras).',
            'name.max'       => 'El nombre es muy largo (máximo 20 letras).',
            
            'price.max'      => 'El precio no puede exceder 5 dígitos ($99,999).',
            'price.numeric'  => 'El precio debe ser un número válido.',
            
            'stock.max'      => 'El stock máximo permitido es 1000 unidades.',
            'stock.integer'  => 'El stock debe ser un número entero.',
            
            'category_id.required' => 'Debes seleccionar una categoría.',
            'expiration_date.required' => 'La fecha de caducidad es obligatoria.',
            'expiration_date.after' => 'La fecha de caducidad debe ser posterior a hoy.',
        ];

        $request->validate($rules, $messages);

        Product::create($request->all());

        return redirect()->route('products.index')->with('success', 'Producto guardado exitosamente.');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        // Reglas para Actualizar (similares, pero ignorando ID propio en barcode y sin after:today en fecha)
        $rules = [
            'barcode' => ['required', 'numeric', 'digits:12', 'unique:products,barcode,'.$id],
            'name'    => ['required', 'string', 'min:3', 'max:20'],
            'category_id'=> ['required', 'exists:categories,id'],
            'price'   => ['required', 'numeric', 'min:0', 'max:99999'],
            'stock'   => ['required', 'integer', 'min:0', 'max:1000'],
            'expiration_date' => ['required', 'date'], // Obligatoria, pero permitimos fechas pasadas al editar
        ];

        $messages = [
            'barcode.digits' => 'El código debe tener exactamente 12 dígitos.',
            'name.max'       => 'El nombre no puede tener más de 20 caracteres.',
            'stock.max'      => 'El stock máximo es 1000.',
            'category_id.required' => 'La categoría es obligatoria.',
            'expiration_date.required' => 'La fecha de caducidad es obligatoria.',
        ];

        $request->validate($rules, $messages);

        $product = Product::findOrFail($id);
        
        $product->update([
            'barcode' => $request->barcode,
            'name'    => $request->name,
            'category_id'=> $request->category_id,
            'price'   => $request->price,
            'stock'   => $request->stock,
            'expiration_date' => $request->expiration_date,
            'has_iva' => $request->has('has_iva'), 
        ]);

        return redirect()->route('products.index')->with('success', 'Producto actualizado.');
    }

    public function destroy($id)
    {
        if (!auth()->user()->can_delete_products && auth()->user()->role !== 'administrador') {
            abort(403, 'No tienes permisos para eliminar.');
        }
        Product::findOrFail($id)->delete();
        return redirect()->route('products.index')->with('success', 'Producto eliminado.');
    }
}