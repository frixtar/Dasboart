<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            Editar Producto: {{ $product->name }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-3xl sm:px-6 lg:px-8">
            <div class="rounded-lg bg-white p-6 shadow">

                <form action="{{ route('products.update', $product->id) }}" method="POST">
                    @csrf
                    @method('PUT') <div class="grid grid-cols-2 gap-4">

                        <div>
                            <label class="font-bold text-gray-700">Código de Barras</label>
                            <input type="text" name="barcode" value="{{ old('barcode', $product->barcode) }}"
                                   class="w-full rounded border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" required>
                            @error('barcode') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="font-bold text-gray-700">Nombre del Producto</label>
                            <input type="text" name="name" value="{{ old('name', $product->name) }}"
                                   class="w-full rounded border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" required>
                        </div>

                        <div>
                            <label class="font-bold text-gray-700">Precio Venta ($)</label>
                            <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}"
                                   class="w-full rounded border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" required>
                        </div>

                        <div>
                            <label class="font-bold text-gray-700">Stock Actual</label>
                            <input type="number" name="stock" value="{{ old('stock', $product->stock) }}"
                                   class="w-full rounded border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" required>
                        </div>

                        <div class="col-span-2 mt-2">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="has_iva" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                {{ $product->has_iva ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">Este producto incluye IVA</span>
                            </label>
                        </div>

                    </div>

                    <div class="mt-6 flex justify-end">
                        <a href="{{ route('products.index') }}" class="mr-4 text-gray-600 hover:underline flex items-center">
                            Cancelar
                        </a>
                        <button type="submit" class="rounded bg-green-600 px-4 py-2 text-white hover:bg-green-700 transition font-bold">
                            Actualizar Producto
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>