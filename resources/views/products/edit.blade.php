<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            Editar Producto: {{ $product->name }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-4xl sm:px-6 lg:px-8">
            <div class="rounded-lg bg-white p-6 shadow">

                <form action="{{ route('products.update', $product->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <!-- COLUMNA IZQUIERDA -->
                        <div class="space-y-4">
                            <!-- Código de Barras -->
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Código de Barras</label>
                                <input type="text" name="barcode" value="{{ old('barcode', $product->barcode) }}"
                                       class="w-full rounded border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 @error('barcode') border-red-500 @enderror" required>
                                <p class="text-xs text-gray-500 mt-1">🔢 12 dígitos numéricos.</p>
                                @error('barcode') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <!-- Nombre -->
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Nombre del Producto</label>
                                <input type="text" name="name" value="{{ old('name', $product->name) }}"
                                       class="w-full rounded border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 @error('name') border-red-500 @enderror" required>
                                <p class="text-xs text-gray-500 mt-1">🔤 Inicia con letras.</p>
                                @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <!-- Categoría -->
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Categoría</label>
                                <select name="category_id" class="w-full rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500" required>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" 
                                            {{ (old('category_id', $product->category_id) == $category->id) ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <!-- COLUMNA DERECHA -->
                        <div class="space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <!-- Precio -->
                                <div>
                                    <label class="block text-gray-700 text-sm font-bold mb-2">Precio Venta ($)</label>
                                    <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}"
                                           class="w-full rounded border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 @error('price') border-red-500 @enderror" required>
                                    <p class="text-xs text-gray-500 mt-1">💲 Positivo.</p>
                                    @error('price') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <!-- Stock -->
                                <div>
                                    <label class="block text-gray-700 text-sm font-bold mb-2">Stock Actual</label>
                                    <input type="number" name="stock" value="{{ old('stock', $product->stock) }}"
                                           class="w-full rounded border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 @error('stock') border-red-500 @enderror" required>
                                    <p class="text-xs text-gray-500 mt-1">📦 Entero.</p>
                                    @error('stock') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <!-- Fecha de Caducidad (FALTABA ESTO) -->
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Fecha de Caducidad</label>
                                <input type="date" name="expiration_date" 
                                       value="{{ old('expiration_date', optional($product->expiration_date)->format('Y-m-d')) }}"
                                       class="w-full rounded border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 @error('expiration_date') border-red-500 @enderror" required>
                                @error('expiration_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <!-- IVA -->
                            <div class="pt-4">
                                <label class="inline-flex items-center cursor-pointer p-3 border rounded w-full hover:bg-gray-50">
                                    <input type="checkbox" name="has_iva" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                    {{ old('has_iva', $product->has_iva) ? 'checked' : '' }}>
                                    <span class="ml-2 text-gray-700 text-sm font-bold">Este precio incluye IVA</span>
                                </label>
                            </div>
                        </div>

                    </div>

                    <!-- Botones -->
                    <div class="mt-8 flex justify-end pt-4 border-t border-gray-100 gap-4">
                        <a href="{{ route('products.index') }}" class="bg-gray-100 text-gray-700 font-bold py-2 px-6 rounded hover:bg-gray-200 transition">
                            Cancelar
                        </a>
                        <button type="submit" class="rounded bg-blue-600 px-6 py-2 text-white hover:bg-blue-700 transition font-bold shadow-md">
                            Actualizar Producto
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>