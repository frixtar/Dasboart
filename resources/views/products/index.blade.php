<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Inventario de Productos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <!-- Barra de herramientas -->
                    <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
                        <div class="flex gap-2">
                            <a href="{{ route('products.create') }}" class="bg-blue-600 text-white font-bold py-2 px-4 rounded hover:bg-blue-700 transition shadow flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                Nuevo Producto
                            </a>
                            <!-- Acceso rápido a categorías -->
                            <a href="{{ route('categories.index') }}" class="bg-white border border-gray-300 text-gray-700 font-bold py-2 px-4 rounded hover:bg-gray-50 transition shadow flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                                Categorías
                            </a>
                        </div>
                        
                        <span class="text-sm text-gray-500 font-bold bg-gray-100 px-3 py-1 rounded-full">
                            Total: {{ $products->count() }}
                        </span>
                    </div>

                    <div class="overflow-x-auto rounded-lg border border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Código / Categoría</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Nombre</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Precio</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Stock</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Caducidad</th>
                                    <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($products as $product)
                                <tr class="hover:bg-gray-50 transition">
                                    
                                    <!-- 1. Código y Categoría (Relacional) -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-bold text-gray-900">{{ $product->barcode }}</div>
                                        <!-- Aquí accedemos a la relación ->category->name -->
                                        @if($product->category)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800 mt-1">
                                                {{ $product->category->name }}
                                            </span>
                                        @else
                                            <span class="text-xs text-gray-400 italic mt-1 block">Sin categoría</span>
                                        @endif
                                    </td>

                                    <!-- 2. Nombre e IVA -->
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900 font-medium">{{ $product->name }}</div>
                                        @if($product->has_iva)
                                            <span class="text-[10px] text-gray-400 uppercase tracking-wider border border-gray-200 px-1 rounded">IVA</span>
                                        @endif
                                    </td>

                                    <!-- 3. Precio -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-blue-600 font-bold">${{ number_format($product->price, 2) }}</div>
                                    </td>

                                    <!-- 4. Stock con Alertas -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($product->stock <= 5)
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 animate-pulse">
                                                Bajo: {{ $product->stock }}
                                            </span>
                                        @else
                                            <span class="text-sm text-gray-700 font-bold">{{ $product->stock }}</span>
                                        @endif
                                    </td>

                                    <!-- 5. Caducidad -->
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        @if($product->expiration_date)
                                            @php
                                                $daysUntilExpiration = now()->diffInDays($product->expiration_date, false);
                                            @endphp

                                            @if($daysUntilExpiration < 0)
                                                <span class="text-red-600 font-bold flex items-center gap-1 bg-red-50 px-2 py-1 rounded">
                                                    🚫 Vencido
                                                </span>
                                            @elseif($daysUntilExpiration < 30)
                                                <span class="text-orange-600 font-bold flex items-center gap-1" title="Vence pronto">
                                                    ⚠️ {{ $product->expiration_date->format('d/m/Y') }}
                                                </span>
                                            @else
                                                <span class="text-green-600 font-medium">
                                                    {{ $product->expiration_date->format('d/m/Y') }}
                                                </span>
                                            @endif
                                        @else
                                            <span class="text-gray-300">-</span>
                                        @endif
                                    </td>

                                    <!-- 6. Acciones -->
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end gap-3">
                                            <a href="{{ route('products.edit', $product->id) }}" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 p-2 rounded-lg transition" title="Editar">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </a>
                                            
                                            @if(auth()->user()->role === 'administrador' || auth()->user()->can_delete_products)
                                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar este producto permanentemente?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 bg-red-50 p-2 rounded-lg transition" title="Eliminar">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        
                        @if($products->isEmpty())
                            <div class="p-12 text-center text-gray-500">
                                <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                <p class="text-lg">No hay productos registrados aún.</p>
                                <p class="text-sm">Comienza agregando categorías y productos.</p>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>