<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Muestra la lista de categorías.
     */
    public function index()
    {
        // Obtenemos todas las categorías ordenadas por las más recientes
        // Usamos 'withCount' para saber cuántos productos tiene cada una sin hacer muchas consultas
        $categories = Category::withCount('products')->orderBy('created_at', 'desc')->get();
        
        return view('categories.index', compact('categories'));
    }

    /**
     * Muestra el formulario para crear una nueva categoría.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Almacena una nueva categoría en la base de datos.
     */
    public function store(Request $request)
    {
        // 1. Validaciones
        $validated = $request->validate([
            'name' => 'required|string|max:50|unique:categories,name',
            'description' => 'nullable|string|max:255',
        ], [
            'name.required' => 'El nombre de la categoría es obligatorio.',
            'name.unique' => 'Ya existe una categoría con este nombre.',
            'name.max' => 'El nombre no puede tener más de 50 caracteres.',
        ]);

        // 2. Crear Categoría
        Category::create($validated);

        // 3. Redireccionar
        return redirect()->route('categories.index')
                         ->with('success', 'Categoría creada exitosamente.');
    }

    /**
     * Muestra el formulario para editar una categoría específica.
     */
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    /**
     * Actualiza la categoría en la base de datos.
     */
    public function update(Request $request, Category $category)
    {
        // 1. Validaciones (Ignoramos el ID actual para la regla unique)
        $validated = $request->validate([
            'name' => 'required|string|max:50|unique:categories,name,' . $category->id,
            'description' => 'nullable|string|max:255',
        ], [
            'name.required' => 'El nombre de la categoría es obligatorio.',
            'name.unique' => 'Ya existe otra categoría con este nombre.',
        ]);

        // 2. Actualizar
        $category->update($validated);

        // 3. Redireccionar
        return redirect()->route('categories.index')
                         ->with('success', 'Categoría actualizada correctamente.');
    }

    /**
     * Elimina la categoría de la base de datos.
     */
    public function destroy(Category $category)
    {
        // Seguridad: Verificar si la categoría tiene productos asociados
        if ($category->products()->count() > 0) {
            return redirect()->route('categories.index')
                             ->with('error', 'No puedes eliminar esta categoría porque tiene productos asociados. Mueve los productos a otra categoría primero.');
        }

        $category->delete();

        return redirect()->route('categories.index')
                         ->with('success', 'Categoría eliminada exitosamente.');
    }
}