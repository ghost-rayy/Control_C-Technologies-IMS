@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<h1 class="page-title">
    <i class="bi bi-speedometer2"></i> Dashboard
</h1>

<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card metric-card">
            <div class="metric-value">{{ $totalProducts }}</div>
            <div class="metric-label">Total Products</div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card metric-card warning">
            <div class="metric-value">{{ $lowStockItems }}</div>
            <div class="metric-label">Low Stock Items</div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card metric-card success">
            <div class="metric-value">{{ $todaySalesCount }}</div>
            <div class="metric-label">Today's Sales</div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card metric-card">
            <div class="metric-value">{{ $staffCount }}</div>
            <div class="metric-label">Active Staff</div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-4 mb-3">
        <div class="card metric-card success">
            <div class="metric-value">₵{{ number_format($todaySales, 2) }}</div>
            <div class="metric-label">Today's Revenue</div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card metric-card">
            <div class="metric-value">₵{{ number_format($totalRevenue, 2) }}</div>
            <div class="metric-label">Total Revenue (All-Time)</div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card metric-card success">
            <div class="metric-value">₵{{ number_format($totalProfit, 2) }}</div>
            <div class="metric-label">Total Profit (All-Time)</div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header bg-light">
                <h5 class="mb-0">
                    <i class="bi bi-exclamation-triangle-fill text-warning"></i> Low Stock Items
                </h5>
            </div>
            <div class="card-body p-0">
                @if($lowStockProducts->count())
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Category</th>
                                <th>Stock</th>
                                <th>Threshold</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($lowStockProducts as $product)
                                <tr>
                                    <td>{{ $product->name }}</td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $product->category->name }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-danger">{{ $product->quantity_in_stock }}</span>
                                    </td>
                                    <td>{{ $product->low_stock_threshold }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="p-4 text-center text-muted">
                        <i class="bi bi-check-circle" style="font-size: 2rem;"></i>
                        <p>All products have sufficient stock</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header bg-light">
                <h5 class="mb-0">
                    <i class="bi bi-fire text-danger"></i> Top Selling Products (This Month)
                </h5>
            </div>
            <div class="card-body p-0">
                @if($topProducts->count())
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Category</th>
                                <th>Units Sold</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($topProducts as $product)
                                <tr>
                                    <td>{{ $product->name }}</td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $product->category->name }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-success">{{ $product->total_sold ?? 0 }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="p-4 text-center text-muted">
                        <p>No sales data available for this month</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12 mb-4">
        <div class="card">
            <div class="card-header bg-light">
                <h5 class="mb-0">
                    <i class="bi bi-clock-history"></i> Recent Sales
                </h5>
            </div>
            <div class="card-body p-0">
                @if($recentSales->count())
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Date & Time</th>
                                <th>Staff</th>
                                <th>Items</th>
                                <th>Amount</th>
                                <th>Payment Method</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentSales as $sale)
                                <tr>
                                    <td>
                                        {{ $sale->created_at->format('d M Y h:i A') }}
                                    </td>
                                    <td>{{ $sale->user->name }}</td>
                                    <td>{{ $sale->items->count() }} item(s)</td>
                                    <td><strong>₵{{ number_format($sale->total_amount, 2) }}</strong></td>
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
                        <p>No sales recorded yet</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header bg-light">
                <h5 class="mb-0">
                    <i class="bi bi-graph-up"></i> Sales Trend (Last 7 Days)
                </h5>
            </div>
            <div class="card-body">
                <canvas id="salesChart"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@section('extra-js')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    const ctx = document.getElementById('salesChart').getContext('2d');
    const salesData = {!! json_encode($salesTrend) !!};

    const labels = salesData.map(d => new Date(d.date).toLocaleDateString('en-US', { month: 'short', day: 'numeric' }));
    const revenue = salesData.map(d => parseFloat(d.revenue) || 0);
    const count = salesData.map(d => parseInt(d.count) || 0);

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Revenue (₵)',
                    data: revenue,
                    borderColor: '#27ae60',
                    backgroundColor: 'rgba(39, 174, 96, 0.1)',
                    tension: 0.4,
                    yAxisID: 'y'
                },
                {
                    label: 'Sales Count',
                    data: count,
                    borderColor: '#3498db',
                    backgroundColor: 'rgba(52, 152, 219, 0.1)',
                    tension: 0.4,
                    yAxisID: 'y1'
                }
            ]
        },
        options: {
            responsive: true,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            scales: {
                y: {
                    type: 'linear',
                    display: true,
                    position: 'left',
                    title: {
                        display: true,
                        text: 'Revenue (₵)'
                    }
                },
                y1: {
                    type: 'linear',
                    display: true,
                    position: 'right',
                    title: {
                        display: true,
                        text: 'Number of Sales'
                    },
                    grid: {
                        drawOnChartArea: false,
                    },
                }
            }
        }
    });
</script>
@endsection
