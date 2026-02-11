@extends('layouts.app')

@section('title', 'Daily Report')

@section('content')
<div class="mb-4 d-flex justify-content-between align-items-center">
    <div>
        <h1 class="page-title-new mb-1">
            <i class="bi bi-calendar-check-fill text-primary"></i> Daily Sales Report
        </h1>
        <p class="text-muted small mb-0">Analyze sales performance for a specific calendar day</p>
    </div>
    <div class="d-flex gap-2 no-print">
        <a href="{{ route('admin.reports.export', ['start_date' => $date, 'end_date' => $date]) }}" class="btn btn-outline-success border-2 fw-700 rounded-3">
            <i class="bi bi-file-earmark-spreadsheet-fill me-1"></i> Export CSV
        </a>
        <button onclick="window.print()" class="btn btn-outline-dark border-2 fw-700 rounded-3">
            <i class="bi bi-printer-fill me-1"></i> Print Report
        </button>
    </div>
</div>

<div class="card recent-sales-card border-0 shadow-sm mb-4 no-print">
    <div class="card-body p-4">
        <form method="GET" action="{{ route('admin.reports.daily') }}" class="row g-2">
            <div class="col-md-4">
                <label class="form-label-new">Select Date</label>
                <input type="date" class="form-control" name="date" value="{{ $date }}" required>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-save-new w-100">
                    <i class="bi bi-search"></i> Load Report
                </button>
            </div>
        </form>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="metric-card-new h-100">
            <div class="metric-info">
                <span class="metric-label-new">Sales Count</span>
                <span class="metric-value-new">{{ $summary['total_sales'] }}</span>
            </div>
            <div class="metric-icon-box bg-light-blue">
                <i class="bi bi-cart-fill"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="metric-card-new h-100">
            <div class="metric-info">
                <span class="metric-label-new">Total Revenue</span>
                <span class="metric-value-new text-success">₵{{ number_format($summary['total_revenue'], 2) }}</span>
            </div>
            <div class="metric-icon-box bg-light-green">
                <i class="bi bi-currency-dollar"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="metric-card-new h-100">
            <div class="metric-info">
                <span class="metric-label-new">Total Profit</span>
                <span class="metric-value-new text-success">₵{{ number_format($summary['total_profit'], 2) }}</span>
            </div>
            <div class="metric-icon-box bg-light-green">
                <i class="bi bi-graph-up-arrow"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="metric-card-new h-100">
            <div class="metric-info">
                <span class="metric-label-new">Profit Margin</span>
                <span class="metric-value-new">{{ number_format($summary['profit_margin'], 1) }}%</span>
            </div>
            <div class="metric-icon-box bg-light-purple">
                <i class="bi bi-percent"></i>
            </div>
        </div>
    </div>
</div>

<div class="card recent-sales-card border-0 shadow-sm">
    <div class="card-header bg-white border-bottom py-3">
        <h6 class="mb-0" style="font-weight: 700; color: #1e293b;">Transactions - {{ \Carbon\Carbon::createFromFormat('Y-m-d', $date)->format('d M Y') }}</h6>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table products-table mb-0">
                <thead>
                    <tr>
                        <th>Time</th>
                        <th>Staff</th>
                        <th>Items</th>
                        <th>Revenue</th>
                        <th>Profit</th>
                        <th>Payment</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sales as $sale)
                        <tr>
                            <td class="small text-muted">{{ $sale->created_at->format('h:i A') }}</td>
                            <td class="fw-600 color-navy">{{ $sale->user->name }}</td>
                            <td>{{ $sale->items->count() }}</td>
                            <td class="fw-700 color-navy">₵{{ number_format($sale->total_amount, 2) }}</td>
                            <td>
                                <span class="text-success fw-600">₵{{ number_format($sale->getProfit(), 2) }}</span>
                            </td>
                            <td>
                                @php
                                    $badgeClass = match($sale->payment_method) {
                                        'Cash' => 'badge-cash',
                                        'Mobile Money' => 'badge-momo',
                                        'Card' => 'badge-card',
                                        default => 'bg-info',
                                    };
                                @endphp
                                <span class="badge-payment {{ $badgeClass }}">{{ $sale->payment_method }}</span>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.sales.receipt', $sale->id) }}" class="btn-action-view" title="View Details">
                                    <i class="bi bi-eye-fill"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted small">No sales recorded for this date.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
.metric-card-new {
    background: #fff;
    border-radius: 12px;
    padding: 1.25rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    border: 1px solid #f1f5f9;
}

.metric-info { display: flex; flex-direction: column; }
.metric-label-new { font-size: 10px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 4px; }
.metric-value-new { font-size: 1.5rem; font-weight: 800; color: #1e293b; line-height: 1.1; }

.metric-icon-box {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
}

.bg-light-blue { background-color: #eff6ff; color: #3b82f6; }
.bg-light-green { background-color: #f0fdf4; color: #22c55e; }
.bg-light-purple { background-color: #faf5ff; color: #a855f7; }

.form-label-new { font-size: 12px; font-weight: 600; color: #64748b; margin-bottom: 6px; display: block; }
.btn-save-new { background-color: #3b82f6; color: #fff; border: none; padding: 10px 20px; border-radius: 8px; font-weight: 600; transition: all 0.2s; display: inline-flex; align-items: center; justify-content: center; gap: 8px; }
.btn-save-new:hover { background-color: #2563eb; color: #fff; }

.products-table thead th { background: #fff; border-bottom: 1px solid #f0f0f0; color: #94a3b8; font-size: 10px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; padding: 1rem 1.5rem; }
.products-table tbody td { padding: 1rem 1.5rem; vertical-align: middle; border-bottom: 1px solid #f8fafc; font-size: 13px; }

.badge-payment { padding: 4px 12px; border-radius: 20px; font-size: 10px; font-weight: 700; }
.badge-cash { background-color: #eff6ff; color: #3b82f6; }
.badge-momo { background-color: #f0fdf4; color: #22c55e; }
.badge-card { background-color: #faf5ff; color: #a855f7; }

.btn-action-view { width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center; border-radius: 50%; background: #f1f5f9; color: #64748b; transition: all 0.2s; border: none; }
.btn-action-view:hover { background: #e2e8f0; color: #1e293b; }

.color-navy { color: #1e293b; }
.fw-600 { font-weight: 600; }
.fw-700 { font-weight: 700; }
</style>
@endsection
