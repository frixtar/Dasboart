<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Panel de Control') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- 1. ALERTAS DE STOCK (Solo visibles si hay urgencias) -->
            @if($lowStockProducts->count() > 0)
            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r shadow-sm flex flex-col sm:flex-row justify-between items-center gap-4">
                <div class="flex items-center">
                    <svg class="w-8 h-8 text-red-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    <div>
                        <p class="font-bold text-red-700 text-lg">¡Atención! Stock Crítico</p>
                        <p class="text-sm text-red-600">Tienes <strong>{{ $lowStockProducts->count() }}</strong> productos por agotarse.</p>
                    </div>
                </div>
                <a href="{{ route('products.index') }}" class="bg-red-600 text-white px-6 py-2 rounded-lg font-bold text-sm hover:bg-red-700 transition shadow">
                    Ver Detalles
                </a>
            </div>
            @endif

            <!-- 2. TARJETAS DE RESUMEN (KPIs Básicos) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Tarjeta Productos -->
                <div class="bg-white overflow-hidden shadow-sm rounded-xl border-b-4 border-blue-500 p-6 flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-xs font-bold uppercase tracking-wider">Inventario Total</p>
                        <p class="text-3xl font-extrabold text-gray-800 mt-1">{{ $totalProducts }}</p>
                        <p class="text-xs text-gray-400 mt-1">Productos registrados</p>
                    </div>
                    <div class="p-4 bg-blue-50 rounded-full text-blue-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    </div>
                </div>

                <!-- Tarjeta Cajeros -->
                <div class="bg-white overflow-hidden shadow-sm rounded-xl border-b-4 border-green-500 p-6 flex items-center justify-between transform hover:scale-105 transition duration-300">
                    <div>
                        <p class="text-gray-500 text-xs font-bold uppercase tracking-wider">Equipo de Ventas</p>
                        <p class="text-3xl font-extrabold text-gray-800 mt-1">{{ $totalCashiers }}</p>
                        <p class="text-xs text-gray-400 mt-1">Cajeros activos</p>
                    </div>
                    <div class="p-4 bg-green-50 rounded-full text-green-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                </div>

                <!-- Tarjeta Alertas -->
                <div class="bg-white overflow-hidden shadow-sm rounded-xl border-b-4 border-red-500 p-6 flex items-center justify-between transform hover:scale-105 transition duration-300">
                    <div>
                        <p class="text-gray-500 text-xs font-bold uppercase tracking-wider">Alertas Activas</p>
                        <p class="text-3xl font-extrabold text-red-600 mt-1">{{ $lowStockProducts->count() }}</p>
                        <p class="text-xs text-gray-400 mt-1">Requieren atención</p>
                    </div>
                    <div class="p-4 bg-red-50 rounded-full text-red-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                </div>
            </div>

            <!-- 3. MENÚ DE ACCIONES PRINCIPALES -->
            <div>
                <h3 class="font-bold text-xl text-gray-800 mb-6 flex items-center gap-2">
                    <span class="w-1 h-6 bg-blue-600 rounded-full inline-block"></span>
                    Menú Principal
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

                    <!-- 2. REPORTES FINANCIEROS -->
                    <a href="{{ route('reports.index') }}" class="group block bg-white rounded-2xl shadow-sm border border-gray-100 hover:border-purple-200 hover:shadow-lg transition-all transform hover:-translate-y-1">
                        <div class="p-6 text-center">
                            <div class="w-16 h-16 bg-purple-50 text-purple-600 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:bg-purple-600 group-hover:text-white transition-colors duration-300">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                            </div>
                            <h4 class="font-bold text-lg text-gray-800 group-hover:text-purple-700 transition">Reportes y KPIs</h4>
                            <p class="text-gray-500 text-sm mt-2">Estadísticas de ventas</p>
                        </div>
                    </a>

                    <!-- 3. INVENTARIO -->
                    <a href="{{ route('products.index') }}" class="group block bg-white rounded-2xl shadow-sm border border-gray-100 hover:border-green-200 hover:shadow-lg transition-all transform hover:-translate-y-1">
                        <div class="p-6 text-center">
                            <div class="w-16 h-16 bg-green-50 text-green-600 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:bg-green-600 group-hover:text-white transition-colors duration-300">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                            </div>
                            <h4 class="font-bold text-lg text-gray-800 group-hover:text-green-700 transition">Inventario</h4>
                            <p class="text-gray-500 text-sm mt-2">Gestionar productos</p>
                        </div>
                    </a>

                    <!-- 4. CAJEROS -->
                    <a href="{{ route('cashiers.index') }}" class="group block bg-white rounded-2xl shadow-sm border border-gray-100 hover:border-orange-200 hover:shadow-lg transition-all transform hover:-translate-y-1">
                        <div class="p-6 text-center">
                            <div class="w-16 h-16 bg-orange-50 text-orange-600 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:bg-orange-600 group-hover:text-white transition-colors duration-300">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </div>
                            <h4 class="font-bold text-lg text-gray-800 group-hover:text-orange-700 transition">Cajeros</h4>
                            <p class="text-gray-500 text-sm mt-2">Gestionar usuarios</p>
                        </div>
                    </a>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>