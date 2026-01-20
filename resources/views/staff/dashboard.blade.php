@extends('layouts.app')

@section('title', 'Staff Dashboard')

@section('content')
<h1 class="page-title">
    <i class="bi bi-speedometer2"></i> Dashboard
</h1>

<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card metric-card">
            <div class="metric-value">{{ $todaySalesCount }}</div>
            <div class="metric-label">Today's Sales</div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card metric-card success">
            <div class="metric-value">₵{{ number_format($todayRevenue, 2) }}</div>
            <div class="metric-label">Today's Revenue</div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card metric-card">
            <div class="metric-value">{{ $totalProducts }}</div>
            <div class="metric-label">Total Products</div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card metric-card warning">
            <div class="metric-value">{{ $lowStockProducts }}</div>
            <div class="metric-label">Low Stock Items</div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header bg-light">
                <h5 class="mb-0">
                    <i class="bi bi-plus-square"></i> Quick Actions
                </h5>
            </div>
            <div class="card-body">
                <a href="{{ route('staff.sales.create') }}" class="btn btn-primary btn-lg w-100 mb-2">
                    <i class="bi bi-plus-circle"></i> Record New Sale
                </a>
                <a href="{{ route('staff.sales.history') }}" class="btn btn-outline-secondary btn-lg w-100">
                    <i class="bi bi-clock-history"></i> View Sales History
                </a>
            </div>
        </div>
    </div>

    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header bg-light">
                <h5 class="mb-0">
                    <i class="bi bi-info-circle"></i> Helpful Tips
                </h5>
            </div>
            <div class="card-body">
                <ul class="mb-0">
                    <li>Select products carefully before recording sales</li>
                    <li>Always verify the quantity in stock before selling</li>
                    <li>Double-check payment method before finalizing</li>
                    <li>Keep transaction receipts for record-keeping</li>
                    <li>Report low stock items to management</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header bg-light">
        <h5 class="mb-0">
            <i class="bi bi-clock-history"></i> Your Recent Sales
        </h5>
    </div>
    <div class="card-body p-0">
        @if($recentSales->count())
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Date & Time</th>
                        <th>Items</th>
                        <th>Amount</th>
                        <th>Payment</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentSales as $sale)
                        <tr>
                            <td>{{ $sale->created_at->format('d M Y h:i A') }}</td>
                            <td>{{ $sale->items->count() }} item(s)</td>
                            <td><strong>₵{{ number_format($sale->total_amount, 2) }}</strong></td>
                            <td>
                                <span class="badge bg-info">{{ $sale->payment_method }}</span>
                            </td>
                            <td>
                                <a href="{{ route('staff.sales.receipt', $sale->id) }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-eye"></i> View
                                </a>
                                <a href="{{ route('staff.sales.print', $sale->id) }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-printer"></i> Print
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="p-4 text-center text-muted">
                <p>No sales recorded yet. <a href="{{ route('staff.sales.create') }}">Create a new sale</a></p>
            </div>
        @endif
    </div>
</div>
@endsection
