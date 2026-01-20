<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class StaffDashboardController extends Controller
{
    public function index()
    {
        // Today's sales count
        $todaySalesCount = Sale::where('user_id', auth()->id())
            ->whereDate('created_at', Carbon::today())
            ->count();

        // Today's revenue
        $todayRevenue = Sale::where('user_id', auth()->id())
            ->whereDate('created_at', Carbon::today())
            ->sum('total_amount');

        // Total products
        $totalProducts = Product::count();

        // Low stock products
        $lowStockProducts = Product::whereRaw('quantity_in_stock <= low_stock_threshold')
            ->count();

        // Recent sales
        $recentSales = Sale::where('user_id', auth()->id())
            ->with('items.product')
            ->latest()
            ->limit(5)
            ->get();

        return view('staff.dashboard', compact(
            'todaySalesCount',
            'todayRevenue',
            'totalProducts',
            'lowStockProducts',
            'recentSales'
        ));
    }
}
