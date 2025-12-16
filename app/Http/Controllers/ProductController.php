<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier; // Mantenemos la importación de Proveedores
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'supplier']);

        // Tu lógica de búsqueda
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('barcode', 'LIKE', "%{$search}%");
            });
        }
        $products = $query->latest()->paginate(50);

        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        $suppliers = Supplier::all(); // Necesario para el selector de proveedores
        return view('products.create', compact('categories', 'suppliers'));
    }

    public function store(Request $request)
    {
        // 1. Reglas de Validación Personalizadas (Fusionadas)
        $rules = [
            'barcode' => ['required', 'numeric', 'digits:12', 'unique:products,barcode'],
            'name'    => ['required', 'string', 'min:3', 'max:20'],
            'category_id'=> ['required', 'exists:categories,id'],
            'supplier_id' => ['nullable', 'exists:suppliers,id'], // Mantenemos validación de proveedor
            'price'   => ['required', 'numeric', 'min:0', 'max:99999'],
            'stock'   => ['required', 'integer', 'min:0', 'max:1000'],
            'expiration_date' => ['required', 'date', 'after:today'],
        ];

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

        // Preparamos los datos incluyendo el checkbox de IVA
        $data = $request->all();
        $data['has_iva'] = $request->has('has_iva');

        Product::create($data);

        return redirect()->route('products.index')->with('success', 'Producto guardado exitosamente.');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $suppliers = Supplier::all(); // Necesario para el selector en edit
        return view('products.edit', compact('product', 'categories', 'suppliers'));
    }

    public function update(Request $request, Product $product)
    {
        $rules = [
            'barcode' => ['required', 'numeric', 'digits:12', 'unique:products,barcode,'.$product->id],
            'name'    => ['required', 'string', 'min:3', 'max:20'],
            'category_id'=> ['required', 'exists:categories,id'],
            'supplier_id' => ['nullable', 'exists:suppliers,id'],
            'price'   => ['required', 'numeric', 'min:0', 'max:99999'],
            'stock'   => ['required', 'integer', 'min:0', 'max:1000'],
            'expiration_date' => ['required', 'date', 'after:today'],
        ];

        $messages = [
            'barcode.digits' => 'El código debe tener exactamente 12 dígitos.',
            'name.max'       => 'El nombre no puede tener más de 20 caracteres.',
            'stock.max'      => 'El stock máximo es 1000.',
            'category_id.required' => 'La categoría es obligatoria.',
            'expiration_date.required' => 'La fecha de caducidad es obligatoria.',
            'expiration_date.after' => 'La fecha de caducidad debe ser posterior a hoy.',
        ];

        $request->validate($rules, $messages);

        $product->update([
            'barcode' => $request->barcode,
            'name'    => $request->name,
            'category_id'=> $request->category_id,
            'supplier_id'=> $request->supplier_id,
            'price'   => $request->price,
            'stock'   => $request->stock,
            'expiration_date' => $request->expiration_date,
            'has_iva' => $request->has('has_iva'), 
        ]);

        return redirect()->route('products.index')->with('success', 'Producto actualizado.');
    }

    public function destroy(Product $product)
    {
        // Tu lógica de permisos
        if (!auth()->user()->can_delete_products && auth()->user()->role !== 'administrador') {
            abort(403, 'No tienes permisos para eliminar.');
        }
        
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Producto eliminado.');
    }
}