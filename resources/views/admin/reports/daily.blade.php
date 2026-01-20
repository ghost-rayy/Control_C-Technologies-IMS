@extends('layouts.app')

@section('title', 'Daily Report')

@section('content')
<h1 class="page-title">
    <i class="bi bi-calendar-day"></i> Daily Sales Report
</h1>

<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.reports.daily') }}" class="row g-2">
            <div class="col-md-4">
                <input type="date" class="form-control" name="date" value="{{ $date }}" required>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-search"></i> Load
                </button>
            </div>
        </form>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card metric-card">
            <div class="metric-value">{{ $summary['total_sales'] }}</div>
            <div class="metric-label">Sales Count</div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card metric-card success">
            <div class="metric-value">₵{{ number_format($summary['total_revenue'], 2) }}</div>
            <div class="metric-label">Revenue</div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card metric-card success">
            <div class="metric-value">₵{{ number_format($summary['total_profit'], 2) }}</div>
            <div class="metric-label">Profit</div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card metric-card">
            <div class="metric-value">{{ number_format($summary['profit_margin'], 1) }}%</div>
            <div class="metric-label">Profit Margin</div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header bg-light">
        <h5 class="mb-0">Transactions - {{ \Carbon\Carbon::createFromFormat('Y-m-d', $date)->format('d M Y') }}</h5>
    </div>
    <div class="card-body p-0">
        @if($sales->count())
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Time</th>
                        <th>Staff</th>
                        <th>Items</th>
                        <th>Revenue</th>
                        <th>Profit</th>
                        <th>Payment</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sales as $sale)
                        <tr>
                            <td>{{ $sale->created_at->format('h:i A') }}</td>
                            <td>{{ $sale->user->name }}</td>
                            <td>{{ $sale->items->count() }}</td>
                            <td><strong>₵{{ number_format($sale->total_amount, 2) }}</strong></td>
                            <td>
                                <span class="text-success">₵{{ number_format($sale->getProfit(), 2) }}</span>
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $sale->payment_method }}</span>
                            </td>
                            <td>
                                <a href="{{ route('staff.sales.receipt', $sale->id) }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="p-4 text-center text-muted">
                <p>No sales recorded for this date</p>
            </div>
        @endif
    </div>
</div>
@endsection
