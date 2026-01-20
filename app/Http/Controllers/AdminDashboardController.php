<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Count metrics
        $totalProducts = Product::count();
        $lowStockItems = Product::whereRaw('quantity_in_stock <= low_stock_threshold')->count();

        // Today's sales
        $todaySales = Sale::whereDate('created_at', Carbon::today())
            ->sum('total_amount');

        $todaySalesCount = Sale::whereDate('created_at', Carbon::today())
            ->count();

        // Today's profit
        $todayProfit = Sale::whereDate('created_at', Carbon::today())
            ->sum(DB::raw('total_amount - total_cost'));

        // Total revenue (all time)
        $totalRevenue = Sale::sum('total_amount');

        // Total profit (all time)
        $totalProfit = Sale::sum(DB::raw('total_amount - total_cost'));

        // Low stock products
        $lowStockProducts = Product::whereRaw('quantity_in_stock <= low_stock_threshold')
            ->with('category')
            ->orderBy('quantity_in_stock', 'asc')
            ->limit(10)
            ->get();

        // Recent sales
        $recentSales = Sale::with('user', 'items.product')
            ->latest()
            ->limit(5)
            ->get();

        // Top selling products (this month)
        $topProducts = Product::select(
            'products.id',
            'products.name',
            'products.brand',
            'products.model',
            'products.selling_price',
            'products.category_id',
            DB::raw('SUM(sale_items.quantity) as total_sold')
        )
            ->leftJoin('sale_items', 'products.id', '=', 'sale_items.product_id')
            ->leftJoin('sales', 'sale_items.sale_id', '=', 'sales.id')
            ->whereMonth('sales.created_at', Carbon::now()->month)
            ->groupBy(
                'products.id',
                'products.name',
                'products.brand',
                'products.model',
                'products.selling_price',
                'products.category_id'
            )
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();

        // Sales trend (last 7 days)
        $salesTrend = Sale::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as count'),
            DB::raw('SUM(total_amount) as revenue')
        )
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date')
            ->get();

        $staffCount = User::where('role', 'staff')->where('is_active', true)->count();

        return view('admin.dashboard', compact(
            'totalProducts',
            'lowStockItems',
            'todaySales',
            'todaySalesCount',
            'todayProfit',
            'totalRevenue',
            'totalProfit',
            'lowStockProducts',
            'recentSales',
            'topProducts',
            'salesTrend',
            'staffCount'
        ));
    }
}
