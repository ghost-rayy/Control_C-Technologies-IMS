<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Sale;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        try {
            // Count metrics
            $totalProducts = Product::count();
            $lowStockItems = Product::whereRaw('quantity_in_stock <= low_stock_threshold')->count();
            $totalCategories = Category::count();
            $activeStaffCount = User::count();

            // Today's sales
            $todaySales = Sale::whereDate('created_at', Carbon::today())
                ->sum('total_amount') ?? 0;

            $todaySalesCount = Sale::whereDate('created_at', Carbon::today())
                ->count();

            // Today's profit
            $todayProfit = Sale::whereDate('created_at', Carbon::today())
                ->sum(DB::raw('total_amount - total_cost')) ?? 0;

            // Total revenue (all time)
            $totalRevenue = Sale::sum('total_amount') ?? 0;

            // Total profit (all time)
            $totalProfit = Sale::sum(DB::raw('total_amount - total_cost')) ?? 0;

            // Yesterday's sales
            $yesterdaySales = Sale::whereDate('created_at', Carbon::yesterday())
                ->sum('total_amount') ?? 0;

            // Revenue change percentage
            $revenueChange = 0;
            if ($yesterdaySales > 0) {
                $revenueChange = (($todaySales - $yesterdaySales) / $yesterdaySales) * 100;
            } elseif ($todaySales > 0) {
                $revenueChange = 100; // 100% increase if there was no revenue yesterday
            }

            // Profit margin percentage
            $profitMargin = 0;
            if ($totalRevenue > 0) {
                $profitMargin = ($totalProfit / $totalRevenue) * 100;
            }

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
                DB::raw('SUM(sale_items.quantity) as total_sold')
            )
                ->with('category')
                ->leftJoin('sale_items', 'products.id', '=', 'sale_items.product_id')
                ->leftJoin('sales', 'sale_items.sale_id', '=', 'sales.id')
                ->whereMonth('sales.created_at', Carbon::now()->month)
                ->groupBy(
                    'products.id',
                    'products.name',
                    'products.brand',
                    'products.model',
                    'products.selling_price'
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
                ->where('created_at', '>=', Carbon::now()->subDays(10))
                ->groupBy(DB::raw('DATE(created_at)'))
                ->orderBy('date')
                ->get();

            return view('admin.dashboard', compact(
                'totalProducts',
                'lowStockItems',
                'todaySales',
                'todaySalesCount',
                'todayProfit',
                'totalRevenue',
                'totalProfit',
                'yesterdaySales',
                'revenueChange',
                'profitMargin',
                'lowStockProducts',
                'recentSales',
                'topProducts',
                'salesTrend',
                'activeStaffCount',
                'totalCategories'
            ));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Dashboard Error: ' . $e->getMessage());
            \Illuminate\Support\Facades\Log::error($e->getTraceAsString());
            return redirect('/')->with('error', 'An error occurred while loading the dashboard. Please try again.');
        }
    }

    public function getChartData()
    {
        try {
            $salesTrend = Sale::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(total_amount) as revenue')
            )
            ->where('created_at', '>=', Carbon::now()->subDays(10))
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date')
            ->get();

            $labels = $salesTrend->map(function($d) {
                $date = Carbon::parse($d->date);
                return $date->format('d M');
            });
            $revenue = $salesTrend->map(fn($d) => (float)$d->revenue);
            $count = $salesTrend->map(fn($d) => (int)$d->count);

            return response()->json([
                'labels' => $labels,
                'revenue' => $revenue,
                'count' => $count
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
