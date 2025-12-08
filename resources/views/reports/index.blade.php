<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Reportes Financieros') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- 1. TARJETAS KPI (Dinero y Métricas) -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                
                <!-- Ventas Hoy -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border-l-4 border-green-500 p-6 transform hover:scale-105 transition duration-300">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100 text-green-600">
                            <!-- Icono Dinero -->
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 uppercase">Ventas Hoy</p>
                            <p class="text-2xl font-bold text-gray-800">${{ number_format($salesToday ?? 0, 2) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Ventas Mes -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border-l-4 border-blue-500 p-6 transform hover:scale-105 transition duration-300">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                            <!-- Icono Calendario -->
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 uppercase">Acumulado Mes</p>
                            <p class="text-2xl font-bold text-gray-800">${{ number_format($salesMonth ?? 0, 2) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Transacciones -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border-l-4 border-purple-500 p-6 transform hover:scale-105 transition duration-300">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                            <!-- Icono Ticket -->
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 uppercase">Tickets Totales</p>
                            <p class="text-2xl font-bold text-gray-800">{{ $totalTransactions ?? 0 }}</p>
                        </div>
                    </div>
                </div>

                <!-- Alerta Stock -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border-l-4 border-red-500 p-6 transform hover:scale-105 transition duration-300">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-red-100 text-red-600">
                            <!-- Icono Alerta -->
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 uppercase">Stock Crítico</p>
                            <p class="text-2xl font-bold text-red-600">{{ $lowStockCount ?? 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. SECCIÓN GRÁFICA Y TOP PRODUCTOS -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- Gráfica de Ventas (Ocupa 2 columnas) -->
                <div class="bg-white p-6 rounded-xl shadow-sm lg:col-span-2">
                    <h3 class="font-bold text-gray-700 text-lg mb-4">Tendencia de Ventas (Últimos 7 días)</h3>
                    <div class="relative h-72 w-full">
                        <canvas id="salesChart"></canvas>
                    </div>
                </div>

                <!-- Top Productos (Ocupa 1 columna) -->
                <div class="bg-white p-6 rounded-xl shadow-sm">
                    <h3 class="font-bold text-gray-700 text-lg mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        Lo Más Vendido (Mes)
                    </h3>
                    <div class="overflow-y-auto max-h-72">
                        @if(isset($topProductsMonth) && $topProductsMonth->count() > 0)
                            <ul class="space-y-3">
                                @foreach($topProductsMonth as $index => $item)
                                <li class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                    <div class="flex items-center gap-3">
                                        <!-- Ranking -->
                                        <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center font-bold text-gray-500 text-sm">
                                            #{{ $index + 1 }}
                                        </div>
                                        <div>
                                            <p class="font-bold text-gray-800 text-sm">{{ $item->product->name ?? 'Producto Eliminado' }}</p>
                                            <p class="text-xs text-gray-500">Unidades vendidas</p>
                                        </div>
                                    </div>
                                    <span class="bg-blue-100 text-blue-700 font-bold px-3 py-1 rounded-full text-sm">
                                        {{ $item->total_qty }}
                                    </span>
                                </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="flex flex-col items-center justify-center h-40 text-gray-400">
                                <svg class="w-10 h-10 mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
                                <p class="text-sm">Sin datos de ventas aún.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- 3. ÚLTIMAS TRANSACCIONES -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl">
                <div class="p-6">
                    <h3 class="font-bold text-gray-700 text-lg mb-4">Actividad Reciente</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm text-left">
                            <thead class="bg-gray-50 text-gray-600 font-medium">
                                <tr>
                                    <th class="px-4 py-3 rounded-l-lg">Folio</th>
                                    <th class="px-4 py-3">Cajero</th>
                                    <th class="px-4 py-3">Fecha</th>
                                    <th class="px-4 py-3">Total</th>
                                    <th class="px-4 py-3 rounded-r-lg text-center">Estado</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @if(isset($recentSales))
                                    @foreach($recentSales as $sale)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-4 py-3 font-mono text-gray-500">#{{ $sale->invoice_number }}</td>
                                        <td class="px-4 py-3 flex items-center gap-2">
                                            <div class="w-6 h-6 rounded-full bg-gray-200 flex items-center justify-center text-xs font-bold text-gray-600">
                                                {{ substr($sale->user->name ?? '?', 0, 1) }}
                                            </div>
                                            {{ $sale->user->name ?? 'Usuario Desconocido' }}
                                        </td>
                                        <td class="px-4 py-3 text-gray-500">{{ $sale->created_at->format('d/m/Y H:i') }}</td>
                                        <td class="px-4 py-3 font-bold text-green-600">${{ number_format($sale->total, 2) }}</td>
                                        <td class="px-4 py-3 text-center">
                                            <span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs font-bold">Completado</span>
                                        </td>
                                    </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                        @if(!isset($recentSales) || $recentSales->isEmpty())
                            <p class="text-center py-6 text-gray-500">No hay transacciones recientes.</p>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Scripts para Gráficas (Chart.js) -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('salesChart');

        new Chart(ctx, {
            type: 'line', // Tipo de gráfica (Línea)
            data: {
                // Pasamos los datos calculados en PHP (DashboardController)
                labels: @json($chartLabels ?? []),
                datasets: [{
                    label: 'Ventas ($)',
                    data: @json($chartValues ?? []),
                    borderColor: '#3b82f6', // Color de línea (Azul Tailwind)
                    backgroundColor: 'rgba(59, 130, 246, 0.1)', // Relleno transparente
                    borderWidth: 3,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#3b82f6',
                    pointRadius: 6,
                    pointHoverRadius: 8,
                    fill: true, // Rellenar debajo de la línea
                    tension: 0.4 // Hace la línea curva suave
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }, // Ocultar leyenda
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { borderDash: [2, 4], color: '#f3f4f6' },
                        ticks: {
                            callback: function(value) { return '$' + value; }
                        }
                    },
                    x: {
                        grid: { display: false }
                    }
                },
                interaction: {
                    mode: 'nearest',
                    axis: 'x',
                    intersect: false
                }
            }
        });
    </script>
</x-app-layout>