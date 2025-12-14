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
        $rules = [
            'barcode' => ['required', 'numeric', 'digits_between:8,14', 'unique:products,barcode'],
            'name'    => ['required', 'string', 'min:3'],
            'category_id'=> ['required', 'exists:categories,id'],
            'price'   => ['required', 'numeric', 'min:0'],
            'stock'   => ['required', 'integer', 'min:0'],
            'expiration_date' => ['nullable', 'date', 'after:today'],
        ];

        $messages = [
            'category_id.required' => 'Debes seleccionar una categoría.',
        ];

        $request->validate($rules, $messages);

        Product::create($request->all());

        return redirect()->route('products.index')->with('success', 'Producto guardado.');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all(); 
        
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'barcode' => ['required', 'numeric', 'digits_between:8,14', 'unique:products,barcode,'.$id],
            'name'    => ['required', 'string', 'min:3', 'max:20'],
            'category_id'=> ['required', 'exists:categories,id'],
            'price'   => ['required', 'numeric', 'min:0'],
            'stock'   => ['required', 'integer', 'min:0'],
            'expiration_date' => ['nullable', 'date'], 
        ];

        $request->validate($rules);

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
            abort(403);
        }
        Product::findOrFail($id)->delete();
        return redirect()->route('products.index')->with('success', 'Producto eliminado.');
    }
}