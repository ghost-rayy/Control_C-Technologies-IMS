@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="mb-4 d-flex justify-content-between align-items-center">
    <div>
        <h1 class="page-title-new mb-1">
            <i class="bi bi-grid-fill text-primary"></i> Dashboard Overview
        </h1>
        <p class="text-muted small mb-0">Welcome back! Here's what's happening with your business today.</p>
    </div>
</div>

<style>
.dashboard-metrics-row {
    margin-bottom: 2rem;
}

.metric-card-new {
    background: #fff;
    border-radius: 12px;
    padding: 1.25rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    border: 1px solid #f1f5f9;
    height: 100%;
}

.metric-info {
    display: flex;
    flex-direction: column;
}

.metric-label-new {
    font-size: 11px;
    font-weight: 600;
    color: #94a3b8;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 4px;
}

.metric-value-new {
    font-size: 1.75rem;
    font-weight: 700;
    color: #1e293b;
    line-height: 1;
}

.metric-icon-box {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
}

.bg-light-blue { background-color: #eff6ff; color: #3b82f6; }
.bg-light-orange { background-color: #fff7ed; color: #f97316; }
.bg-light-green { background-color: #f0fdf4; color: #22c55e; }
.bg-light-purple { background-color: #faf5ff; color: #a855f7; }

.revenue-card-new {
    border-radius: 12px;
    padding: 1.5rem;
    color: #fff;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    min-height: 140px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    transition: transform 0.2s;
}

.revenue-card-new:hover {
    transform: translateY(-4px);
}

.revenue-label {
    font-size: 12px;
    font-weight: 600;
    opacity: 0.9;
    margin-bottom: 8px;
}

.revenue-val {
    font-size: 2.25rem;
    font-weight: 800;
    margin-bottom: 4px;
}

.revenue-meta {
    font-size: 11px;
    font-weight: 600;
    opacity: 0.85;
}

.grad-green {
    background: linear-gradient(135deg, #22c55e, #16a34a);
}

.grad-blue {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
}
</style>

{{-- Top Metrics --}}
<div class="row g-3 dashboard-metrics-row">
    <div class="col-lg-3 col-md-6">
        <div class="metric-card-new">
            <div class="metric-info">
                <span class="metric-label-new">Total Products</span>
                <span class="metric-value-new">{{ $totalProducts }}</span>
            </div>
            <div class="metric-icon-box bg-light-blue">
                <i class="bi bi-box-seam-fill"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="metric-card-new">
            <div class="metric-info">
                <span class="metric-label-new">Low Stock Items</span>
                <span class="metric-value-new text-warning">{{ $lowStockItems }}</span>
            </div>
            <div class="metric-icon-box bg-light-orange">
                <i class="bi bi-exclamation-triangle-fill"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="metric-card-new">
            <div class="metric-info">
                <span class="metric-label-new">Today's Sales</span>
                <span class="metric-value-new text-success">{{ $todaySalesCount }}</span>
            </div>
            <div class="metric-icon-box bg-light-green">
                <i class="bi bi-cart-fill"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="metric-card-new">
            <div class="metric-info">
                <span class="metric-label-new">Active Staff</span>
                <span class="metric-value-new">{{ $activeStaffCount }}</span>
            </div>
            <div class="metric-icon-box bg-light-purple">
                <i class="bi bi-people-fill"></i>
            </div>
        </div>
    </div>
</div>

{{-- Revenue Cards --}}
<div class="row g-3 mb-5">
    <div class="col-lg-4">
        <div class="revenue-card-new grad-green">
            <div class="revenue-label">Today's Revenue</div>
            <div class="revenue-val">₵{{ number_format($todaySales, 2) }}</div>
            <div class="revenue-meta">+12.5% from yesterday</div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="revenue-card-new grad-blue">
            <div class="revenue-label">Total Revenue (All-Time)</div>
            <div class="revenue-val">₵{{ number_format($totalRevenue, 2) }}</div>
            <div class="revenue-meta">Since launch</div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="revenue-card-new grad-green">
            <div class="revenue-label">Total Profit (All-Time)</div>
            <div class="revenue-val">₵{{ number_format($totalProfit, 2) }}</div>
            <div class="revenue-meta">29% margin</div>
        </div>
    </div>
</div>

{{-- Tables: Low Stock & Top Selling --}}
<div class="row g-3 mb-4">
    <div class="col-lg-6">
        <div class="card recent-sales-card shadow-sm border-0">
            <div class="card-header">
                <div class="recent-sales-title">
                    <i class="bi bi-exclamation-triangle-fill text-warning"></i>
                    Low Stock Items
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table inventory-table mb-0">
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
                                <td class="product-name-sm">{{ $product->name }}</td>
                                <td><span class="category-pill">{{ $product->category->name }}</span></td>
                                <td><span class="badge-circle badge-red">{{ $product->quantity_in_stock }}</span></td>
                                <td class="threshold-val">{{ $product->low_stock_threshold }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card recent-sales-card shadow-sm border-0">
            <div class="card-header">
                <div class="recent-sales-title">
                    <i class="bi bi-fire text-danger"></i>
                    Top Selling Products (This Month)
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table inventory-table mb-0">
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
                                <td class="product-name-sm">{{ $product->name }}</td>
                                <td><span class="category-pill">{{ $product->category ? $product->category->name : 'No Category' }}</span></td>
                                <td><span class="badge-circle badge-green">{{ $product->total_sold ?? 0 }}</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.inventory-table thead th {
    background: #fff;
    border-bottom: 1px solid #f0f0f0;
    color: #94a3b8;
    font-size: 10px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    padding: 1rem 1.5rem;
}

.inventory-table tbody td {
    padding: 1rem 1.5rem;
    vertical-align: middle;
    color: #475569;
    font-size: 0.9rem;
    border-bottom: 1px solid #f8fafc;
}

.product-name-sm {
    font-weight: 500;
    color: #1e293b;
}

.category-pill {
    display: inline-block;
    padding: 4px 12px;
    border-radius: 20px;
    background-color: #f1f5f9;
    color: #64748b;
    font-size: 10px;
    font-weight: 600;
}

.badge-circle {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 28px;
    height: 28px;
    border-radius: 50%;
    font-weight: 600;
    font-size: 0.8rem;
    color: white;
}

.badge-red {
    background-color: #ef4444;
}

.badge-green {
    background-color: #22c55e;
}

.threshold-val {
    color: #94a3b8;
    font-weight: 500;
}
</style>

<style>
.recent-sales-card {
    border-radius: 12px;
    background: #fff;
}

.recent-sales-card .card-header {
    background: #fff;
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid #f0f0f0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.recent-sales-title {
    display: flex;
    align-items: center;
    gap: 8px;
    font-weight: 600;
    color: #2c3e50;
}

.view-all-link {
    font-size: 0.85rem;
    color: #3498db;
    text-decoration: none;
    font-weight: 500;
}

.view-all-link:hover {
    text-decoration: underline;
}

.recent-sales-table {
    margin-bottom: 0;
}

.recent-sales-table thead th {
    background: #fff;
    border-bottom: 1px solid #f0f0f0;
    color: #94a3b8;
    font-size: 10px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    padding: 1rem 1.5rem;
}

.recent-sales-table tbody td {
    padding: 1.25rem 1.5rem;
    vertical-align: middle;
    color: #475569;
    font-size: 0.9rem;
    border-bottom: 1px solid #f8fafc;
}

.staff-name {
    font-weight: 500;
    color: #1e293b;
}

.sale-amount {
    font-weight: 700;
    color: #0f172a;
}

.badge-payment {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
}

.badge-cash {
    background-color: #eff6ff;
    color: #3b82f6;
}

.badge-momo {
    background-color: #f0fdf4;
    color: #22c55e;
}

.badge-card {
    background-color: #faf5ff;
    color: #a855f7;
}

.btn-action-view {
    width: 32px;
    height: 32px;
    padding: 0;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background: #f8fafc;
    color: #64748b;
    border: 1px solid #e2e8f0;
    transition: all 0.2s;
}

.btn-action-view:hover {
    background: #f1f5f9;
    color: #334155;
    border-color: #cbd5e1;
}
</style>

{{-- Recent Sales --}}
<div class="row g-3 mb-4">
    <div class="col-12">
        <div class="card recent-sales-card shadow-sm border-0">
            <div class="card-header">
                <div class="recent-sales-title">
                    <i class="bi bi-clock-history text-primary"></i>
                    Recent Sales
                </div>
                <a href="{{ route('admin.sales.history') }}" class="view-all-link">View All</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table recent-sales-table">
                        <thead>
                            <tr>
                                <th>Date & Time</th>
                                <th>Staff</th>
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
                                <td class="staff-name">{{ $sale->user ? $sale->user->name : 'N/A' }}</td>
                                <td>{{ $sale->items->count() }} item(s)</td>
                                <td class="sale-amount">₵{{ number_format($sale->total_amount, 2) }}</td>
                                <td>
                                    @php
                                        $badgeClass = match($sale->payment_method) {
                                            'Cash' => 'badge-cash',
                                            'Mobile Money' => 'badge-momo',
                                            'Card' => 'badge-card',
                                            default => 'bg-info',
                                        };
                                        $label = $sale->payment_method ?: 'Unknown';
                                    @endphp
                                    <span class="badge badge-payment {{ $badgeClass }}">{{ $label }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.sales.receipt', $sale->id) }}" class="btn-action-view" title="View Details">
                                        <i class="bi bi-eye-fill"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Sales Trend Chart --}}
<div class="row g-3">
    <div class="col-12">
        <div class="card recent-sales-card shadow-sm border-0">
            <div class="card-header">
                <div class="recent-sales-title">
                    <i class="bi bi-graph-up text-success"></i>
                    Sales Trend (Last 7 Days)
                </div>
            </div>
            <div class="card-body">
                <div style="height: 300px; position: relative;">
                    <canvas id="salesChart"></canvas>
                </div>
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

const labels = salesData.map(d => {
    const date = new Date(d.date);
    const day = date.getDate();
    const month = date.toLocaleString('en-US', { month: 'short' });
    return `${day} ${month}`;
});
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
                borderColor: '#2ecc71',
                backgroundColor: '#2ecc71',
                borderWidth: 2,
                pointRadius: 4,
                pointBackgroundColor: '#2ecc71',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointHoverRadius: 6,
                tension: 0,
                yAxisID: 'y'
            },
            {
                label: 'Sales Count',
                data: count,
                borderColor: '#3498db',
                backgroundColor: '#3498db',
                borderWidth: 2,
                pointRadius: 4,
                pointBackgroundColor: '#3498db',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointHoverRadius: 6,
                tension: 0,
                yAxisID: 'y1'
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        interaction: { mode: 'index', intersect: false },
        plugins: {
            legend: {
                position: 'top',
                align: 'start',
                labels: {
                    usePointStyle: true,
                    boxWidth: 8,
                    padding: 20,
                    font: { size: 12, weight: '500' },
                    color: '#64748b'
                }
            },
            tooltip: {
                backgroundColor: '#1e293b',
                padding: 12,
                titleFont: { size: 13 },
                bodyFont: { size: 13 },
                displayColors: true,
                usePointStyle: true
            }
        },
        scales: {
            y: {
                type: 'linear',
                position: 'left',
                border: { display: false },
                grid: { color: '#f1f5f9' },
                ticks: { 
                    color: '#94a3b8', 
                    font: { size: 10 },
                    callback: function(value) { return '₵' + value; }
                }
            },
            y1: {
                type: 'linear',
                position: 'right',
                border: { display: false },
                grid: { display: false },
                ticks: { color: '#94a3b8', font: { size: 10 } }
            },
            x: {
                border: { display: false },
                grid: { display: false },
                ticks: { color: '#94a3b8', font: { size: 10 } }
            }
        }
    }
});
</script>
@endsection
