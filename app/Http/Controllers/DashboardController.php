<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. KPIs Generales
        $salesToday = Sale::whereDate('created_at', Carbon::today())->sum('total');
        $salesMonth = Sale::whereMonth('created_at', Carbon::now()->month)->sum('total');
        $totalTransactions = Sale::count();
        $lowStockCount = Product::where('stock', '<=', 10)->count();

        // 2. Gráfica de Ventas (Últimos 7 días)
        $salesLast7Days = Sale::select(
            DB::raw('DATE(created_at) as date'), 
            DB::raw('SUM(total) as total')
        )
        ->where('created_at', '>=', Carbon::now()->subDays(7))
        ->groupBy('date')
        ->orderBy('date')
        ->get();

        $chartLabels = $salesLast7Days->pluck('date')->map(fn($date) => Carbon::parse($date)->format('d/m'))->toArray();
        $chartValues = $salesLast7Days->pluck('total')->toArray();

        // 3. Productos Más Vendidos (Este Mes)
        $topProductsMonth = SaleDetail::select('product_id', DB::raw('SUM(quantity) as total_qty'))
            ->whereHas('product')
            ->whereHas('sale', function($q) {
                $q->whereMonth('created_at', Carbon::now()->month);
            })
            ->with('product')
            ->groupBy('product_id')
            ->orderByDesc('total_qty')
            ->take(5)
            ->get();

        // 4. Últimas Transacciones
        $recentSales = Sale::with('user')->latest()->take(5)->get();

        return view('reports.index', compact(
            'salesToday', 
            'salesMonth', 
            'totalTransactions', 
            'lowStockCount',
            'chartLabels',
            'chartValues',
            'topProductsMonth',
            'recentSales'
        ));
    }
}