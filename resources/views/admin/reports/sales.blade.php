@extends('layouts.app')

@section('title', 'Sales Reports')

@section('content')
<h1 class="page-title">
    <i class="bi bi-graph-up"></i> Sales Reports
</h1>

<div class="card mb-4">
    <div class="card-header bg-light">
        <h5 class="mb-0">Filter Reports</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.reports.filter') }}" class="row g-3">
            @csrf

            <div class="col-md-3">
                <label for="start_date" class="form-label">Start Date</label>
                <input type="date" class="form-control" id="start_date" name="start_date" value="{{ $startDate->format('Y-m-d') }}">
            </div>

            <div class="col-md-3">
                <label for="end_date" class="form-label">End Date</label>
                <input type="date" class="form-control" id="end_date" name="end_date" value="{{ $endDate->format('Y-m-d') }}">
            </div>

            <div class="col-md-3">
                <label for="payment_method" class="form-label">Payment Method</label>
                <select class="form-select" id="payment_method" name="payment_method">
                    <option value="">All Methods</option>
                    <option value="Cash">Cash</option>
                    <option value="Mobile Money">Mobile Money</option>
                    <option value="Card">Card</option>
                </select>
            </div>

            <div class="col-md-3">
                <label>&nbsp;</label>
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-search"></i> Filter
                </button>
            </div>
        </form>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card metric-card">
            <div class="metric-value">{{ $summary['total_sales'] }}</div>
            <div class="metric-label">Total Sales</div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card metric-card success">
            <div class="metric-value">₵{{ number_format($summary['total_revenue'], 2) }}</div>
            <div class="metric-label">Total Revenue</div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card metric-card">
            <div class="metric-value">₵{{ number_format($summary['average_sale'], 2) }}</div>
            <div class="metric-label">Average Sale</div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card metric-card success">
            <div class="metric-value">₵{{ number_format($summary['total_profit'], 2) }}</div>
            <div class="metric-label">Total Profit</div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header bg-light">
        <h5 class="mb-0">Sales Records</h5>
    </div>
    <div class="card-body p-0">
        @if($sales->count())
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Date & Time</th>
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
                            <td>{{ $sale->created_at->format('d M Y h:i A') }}</td>
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
                <p>No sales records found</p>
            </div>
        @endif
    </div>
</div>

<div class="mt-3">
    {{ $sales->links() }}
</div>
@endsection
