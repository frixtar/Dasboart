<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Panel de Control') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- 1. Tarjetas de Estadísticas (KPIs) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                
                <!-- Tarjeta Total Productos -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-blue-500">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-blue-100 text-blue-500">
                                <!-- Icono Caja -->
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Total Productos</p>
                                <p class="text-2xl font-bold text-gray-800">{{ $totalProducts }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tarjeta Cajeros -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-green-500">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-100 text-green-500">
                                <!-- Icono Usuario -->
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Cajeros Activos</p>
                                <p class="text-2xl font-bold text-gray-800">{{ $totalCashiers }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tarjeta Alerta Stock -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-red-500">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-red-100 text-red-500">
                                <!-- Icono Alerta -->
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Stock Crítico</p>
                                <p class="text-2xl font-bold text-red-600">{{ $lowStockProducts->count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                
                <!-- 2. Tabla de Productos con Bajo Stock -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="font-bold text-lg text-gray-800 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            Productos por Agotarse
                        </h3>
                        
                        @if($lowStockProducts->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full text-sm text-left">
                                    <thead class="bg-gray-50 text-gray-600 font-medium border-b">
                                        <tr>
                                            <th class="py-3 px-2">Producto</th>
                                            <th class="py-3 px-2">Stock</th>
                                            <th class="py-3 px-2">Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        @foreach($lowStockProducts as $product)
                                        <tr class="hover:bg-gray-50 transition">
                                            <td class="py-3 px-2 text-gray-800">{{ $product->name }}</td>
                                            <td class="py-3 px-2">
                                                <span class="bg-red-100 text-red-800 text-xs font-bold px-2 py-1 rounded">
                                                    {{ $product->stock }} un.
                                                </span>
                                            </td>
                                            <td class="py-3 px-2">
                                                <a href="{{ route('products.edit', $product->id) }}" class="text-blue-600 hover:underline">Resurtir</a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-8 text-green-600 bg-green-50 rounded-lg">
                                <p class="font-bold">¡Todo excelente!</p>
                                <p class="text-sm">No hay productos con stock bajo.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- 3. Accesos Rápidos -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="font-bold text-lg text-gray-800 mb-4">Accesos Rápidos</h3>
                        <div class="grid grid-cols-2 gap-4">
                            
                            <a href="{{ route('products.create') }}" class="flex flex-col items-center justify-center p-6 bg-blue-50 rounded-lg hover:bg-blue-100 transition border border-blue-200 cursor-pointer group">
                                <div class="p-3 bg-blue-200 rounded-full mb-2 group-hover:scale-110 transition">
                                    <svg class="w-6 h-6 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                </div>
                                <span class="font-bold text-blue-800">Nuevo Producto</span>
                            </a>

                            <a href="{{ route('cashiers.create') }}" class="flex flex-col items-center justify-center p-6 bg-purple-50 rounded-lg hover:bg-purple-100 transition border border-purple-200 cursor-pointer group">
                                <div class="p-3 bg-purple-200 rounded-full mb-2 group-hover:scale-110 transition">
                                    <svg class="w-6 h-6 text-purple-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                                </div>
                                <span class="font-bold text-purple-800">Nuevo Cajero</span>
                            </a>

                            <!-- Botón inactivo hasta que hagamos el POS -->
                            <div class="col-span-2 flex flex-col items-center justify-center p-6 bg-gray-50 rounded-lg border border-gray-200 opacity-50">
                                <span class="font-bold text-gray-500">Punto de Venta (Próximamente)</span>
                            </div>

                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>