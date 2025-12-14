<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nuevo Producto') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form action="{{ route('products.store') }}" method="POST">
                        @csrf
                        
                        <!-- Código de Barras -->
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Código de Barras</label>
                            <input type="text" name="barcode" value="{{ old('barcode') }}"
                                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-green-500 @error('barcode') border-red-500 @enderror" 
                                   placeholder="Ej: 7501055310805" required>
                            <!-- Ayuda Visual -->
                            <p class="text-xs text-gray-500 mt-1">🔢 Debe tener exactamente <strong>12 dígitos numéricos</strong>.</p>
                            @error('barcode') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Nombre -->
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Nombre del Producto</label>
                            <input type="text" name="name" value="{{ old('name') }}"
                                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-green-500 @error('name') border-red-500 @enderror" 
                                   placeholder="Ej: Galletas Marías 150g" required>
                            <p class="text-xs text-gray-500 mt-1">🔤 Debe comenzar con una letra.</p>
                            @error('name') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Grid para Precio y Stock -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            
                            <!-- Precio -->
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Precio Venta ($)</label>
                                <input type="number" step="0.01" name="price" value="{{ old('price') }}"
                                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-green-500 @error('price') border-red-500 @enderror" 
                                       placeholder="0.00" required>
                                <p class="text-xs text-gray-500 mt-1">💲 Solo números positivos.</p>
                                @error('price') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Stock -->
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Cantidad Inicial (Stock)</label>
                                <input type="number" name="stock" value="{{ old('stock') }}"
                                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-green-500 @error('stock') border-red-500 @enderror" 
                                       placeholder="Ej: 50" required>
                                <p class="text-xs text-gray-500 mt-1">📦 Número entero (sin decimales).</p>
                                @error('stock') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- Categoría -->
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Categoría</label>
                            
                            <select name="category_id" class="w-full rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500" required>
                                <option value="" disabled selected>Selecciona una opción...</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            
                            <a href="{{ route('categories.create') }}" class="text-xs text-blue-600 hover:underline mt-1 inline-block">
                                + Crear nueva categoría
                            </a>
                            @error('category_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Fecha de Caducidad</label>
<input type="date" name="expiration_date" value="{{ old('expiration_date') }}" 
       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-green-500 @error('expiration_date') border-red-500 @enderror" 
       required>
                        </div>

                        <!-- Checkbox IVA -->
                        <div class="mb-6 p-3 bg-gray-50 rounded border border-gray-100">
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="has_iva" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" {{ old('has_iva', true) ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700 text-sm font-bold">Este precio ya incluye IVA</span>
                            </label>
                        </div>

                        <!-- Botones -->
                        <div class="flex justify-end gap-4 mt-6">
                            <a href="{{ route('products.index') }}" class="bg-gray-500 text-white font-bold py-2 px-4 rounded hover:bg-gray-600 transition shadow">
                                Cancelar
                            </a>
                            
                            <button type="submit" class="bg-green-600 text-white font-bold py-2 px-6 rounded hover:bg-green-700 transition shadow-lg flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Guardar Producto
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>