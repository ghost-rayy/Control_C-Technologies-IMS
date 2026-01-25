<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        try {
            // Default to last 30 days
            $startDate = Carbon::now()->subDays(30)->startOfDay();
            $endDate = Carbon::now()->endOfDay();

            $sales = Sale::whereBetween('created_at', [$startDate, $endDate])
                ->with('user', 'items.product')
                ->latest()
                ->paginate(20);

            $summary = $this->generateSummary($startDate, $endDate);

            return view('admin.reports.sales', compact('sales', 'summary', 'startDate', 'endDate'));
        } catch (\Exception $e) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Failed to load reports. Please try again.');
        }
    }

    public function filter(Request $request)
    {
        try {
            $validated = $request->validate([
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
                'product_id' => 'nullable|exists:products,id',
                'payment_method' => 'nullable|string|in:Cash,Mobile Money,Card',
            ]);

            $query = Sale::query();

            $startDate = Carbon::createFromFormat('Y-m-d', $validated['start_date'])->startOfDay();
            $endDate = Carbon::createFromFormat('Y-m-d', $validated['end_date'])->endOfDay();

            $query->whereBetween('created_at', [$startDate, $endDate]);

            if ($validated['product_id'] ?? false) {
                $query->whereHas('items', function ($q) use ($validated) {
                    $q->where('product_id', $validated['product_id']);
                });
            }

            if ($validated['payment_method'] ?? false) {
                $query->where('payment_method', $validated['payment_method']);
            }

            $sales = $query->with('user', 'items.product')
                ->latest()
                ->paginate(20);

            $summary = $this->generateSummary($startDate, $endDate, $query->clone());

            return view('admin.reports.sales', compact('sales', 'summary', 'startDate', 'endDate'));
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to filter reports. Please try again.');
        }
    }

    public function daily()
    {
        try {
            $date = request('date', Carbon::now()->format('Y-m-d'));
            $carbonDate = Carbon::createFromFormat('Y-m-d', $date);

            $startDate = $carbonDate->startOfDay();
            $endDate = $carbonDate->endOfDay();

            $sales = Sale::whereBetween('created_at', [$startDate, $endDate])
                ->with('user', 'items.product')
                ->latest()
                ->get();

            $summary = $this->generateSummary($startDate, $endDate);

            return view('admin.reports.daily', compact('sales', 'summary', 'date'));
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to load daily report. Please try again.');
        }
    }

    public function weekly()
    {
        try {
            $startDate = Carbon::now()->startOfWeek()->startOfDay();
            $endDate = Carbon::now()->endOfWeek()->endOfDay();

            $sales = Sale::whereBetween('created_at', [$startDate, $endDate])
                ->with('user', 'items.product')
                ->latest()
                ->get();

            $summary = $this->generateSummary($startDate, $endDate);

            $dailyData = Sale::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(total_amount) as revenue'),
                DB::raw('SUM(total_amount - total_cost) as profit')
            )
                ->whereBetween('created_at', [$startDate, $endDate])
                ->groupBy(DB::raw('DATE(created_at)'))
                ->orderBy('date')
                ->get();

            return view('admin.reports.weekly', compact('sales', 'summary', 'dailyData', 'startDate', 'endDate'));
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to load weekly report. Please try again.');
        }
    }

    public function monthly()
    {
        try {
            $startDate = Carbon::now()->startOfMonth()->startOfDay();
            $endDate = Carbon::now()->endOfMonth()->endOfDay();

            $sales = Sale::whereBetween('created_at', [$startDate, $endDate])
                ->with('user', 'items.product')
                ->latest()
                ->get();

            $summary = $this->generateSummary($startDate, $endDate);

            $dailyData = Sale::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(total_amount) as revenue'),
                DB::raw('SUM(total_amount - total_cost) as profit')
            )
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date')
            ->get();

            return view('admin.reports.monthly', compact('sales', 'summary', 'dailyData', 'startDate', 'endDate'));
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to load monthly report. Please try again.');
        }
    }

    private function generateSummary($startDate, $endDate, $query = null)
    {
        if (!$query) {
            $query = Sale::query();
        }

        $clonedQuery = clone $query;

        $sales = $clonedQuery->whereBetween('created_at', [$startDate, $endDate])->get();

        return [
            'total_sales' => $sales->count(),
            'total_revenue' => $sales->sum('total_amount'),
            'total_cost' => $sales->sum('total_cost'),
            'total_profit' => $sales->sum(fn($sale) => $sale->total_amount - $sale->total_cost),
            'average_sale' => $sales->count() > 0 ? $sales->sum('total_amount') / $sales->count() : 0,
            'profit_margin' => $sales->sum('total_amount') > 0
                ? (($sales->sum(fn($sale) => $sale->total_amount - $sale->total_cost) / $sales->sum('total_amount')) * 100)
                : 0,
        ];
    }
}

