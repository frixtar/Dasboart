<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Mostrar listado de productos/autos
     */
    public function index()
    {
        $products = Product::latest()->get();
        return view('products.index', compact('products'));
    }

    /**
     * Form para crear auto
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Guardar auto nuevo
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'nullable|numeric',
            'vin' => 'nullable|string|max:255',
            'plate' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:255',
            'mileage' => 'nullable|numeric',
            'price' => 'nullable|numeric',
            'cost' => 'nullable|numeric',
            'status' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048', // 2MB
        ]);

        // Guardar imagen si existe
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($validated);

        return redirect()->route('products.index')
            ->with('success', 'Auto agregado correctamente.');
    }

    /**
     * Form para editar auto
     */
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    /**
     * Actualizar auto
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'nullable|numeric',
            'vin' => 'nullable|string|max:255',
            'plate' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:255',
            'mileage' => 'nullable|numeric',
            'price' => 'nullable|numeric',
            'cost' => 'nullable|numeric',
            'status' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        // Si subió una nueva imagen
        if ($request->hasFile('image')) {

            // Eliminar la anterior si existe
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($validated);

        return redirect()->route('products.index')
            ->with('success', 'Auto actualizado correctamente.');
    }

    /**
     * Eliminar auto
     */
    public function destroy(Product $product)
    {
        // Eliminar imagen si existe
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Auto eliminado correctamente.');
    }
}
