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
                'start_date' => 'nullable|date',
                'end_date' => 'nullable|date|after_or_equal:start_date',
                'payment_method' => 'nullable|string|in:Cash,Mobile Money,Card',
            ]);

            $startDate = $validated['start_date'] ? Carbon::parse($validated['start_date'])->startOfDay() : Carbon::now()->subDays(30)->startOfDay();
            $endDate = $validated['end_date'] ? Carbon::parse($validated['end_date'])->endOfDay() : Carbon::now()->endOfDay();

            $query = Sale::query();
            $query->whereBetween('created_at', [$startDate, $endDate]);

            if ($validated['payment_method'] ?? false) {
                $query->where('payment_method', $validated['payment_method']);
            }

            $sales = $query->with('user', 'items.product')
                ->latest()
                ->paginate(20)
                ->withQueryString();

            $summary = $this->generateSummary($startDate, $endDate, $query->clone());

            return view('admin.reports.sales', compact('sales', 'summary', 'startDate', 'endDate'));
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to filter reports. Please try again.');
        }
    }

    public function export(Request $request)
    {
        try {
            $query = Sale::query();

            if ($request->filled('start_date') && $request->filled('end_date')) {
                $startDate = Carbon::parse($request->start_date)->startOfDay();
                $endDate = Carbon::parse($request->end_date)->endOfDay();
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }

            if ($request->filled('payment_method')) {
                $query->where('payment_method', $request->payment_method);
            }

            $sales = $query->with('user', 'items.product')->latest()->get();

            $filename = "sales_report_" . date('Y-m-d_H-i-s') . ".csv";
            $headers = [
                "Content-type" => "text/csv",
                "Content-Disposition" => "attachment; filename=$filename",
                "Pragma" => "no-cache",
                "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
                "Expires" => "0"
            ];

            $columns = ['Date', 'Receipt #', 'Staff', 'Items Count', 'Payment Method', 'Revenue', 'Cost', 'Profit'];

            $callback = function() use ($sales, $columns) {
                $file = fopen('php://output', 'w');
                fputcsv($file, $columns);

                foreach ($sales as $sale) {
                    fputcsv($file, [
                        $sale->created_at->format('Y-m-d H:i:s'),
                        str_pad($sale->id, 6, '0', STR_PAD_LEFT),
                        $sale->user->name,
                        $sale->items->count(),
                        $sale->payment_method,
                        $sale->total_amount,
                        $sale->total_cost,
                        $sale->total_amount - $sale->total_cost,
                    ]);
                }
                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to export report: ' . $e->getMessage());
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

