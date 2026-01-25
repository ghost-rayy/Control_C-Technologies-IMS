@extends('layouts.app')

@section('title', 'Monthly Report')

@section('content')
<div class="mb-4">
    <h1 class="page-title-new mb-1">
        <i class="bi bi-calendar-month-fill text-primary"></i> Monthly Sales Report
    </h1>
    <p class="text-muted small">Sales performance overview for <strong>{{ $startDate->format('F Y') }}</strong></p>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="metric-card-new h-100">
            <div class="metric-info">
                <span class="metric-label-new">Total Sales</span>
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

<div class="card recent-sales-card border-0 shadow-sm mb-4">
    <div class="card-header bg-white border-bottom py-3">
        <h6 class="mb-0" style="font-weight: 700; color: #1e293b;">Daily Sales Trend</h6>
    </div>
    <div class="card-body">
        <div style="height: 300px; position: relative;">
            <canvas id="monthlyChart"></canvas>
        </div>
    </div>
</div>

<div class="card recent-sales-card border-0 shadow-sm">
    <div class="card-header bg-white border-bottom py-3">
        <h6 class="mb-0" style="font-weight: 700; color: #1e293b;">Daily Breakdown</h6>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table products-table mb-0">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Sales</th>
                        <th>Revenue</th>
                        <th>Profit</th>
                        <th class="text-end">Margin</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dailyData as $day)
                        @php
                            $margin = $day->revenue > 0 ? (($day->profit / $day->revenue) * 100) : 0;
                        @endphp
                        <tr>
                            <td class="fw-600 color-navy">{{ \Carbon\Carbon::createFromFormat('Y-m-d', $day->date)->format('d M (l)') }}</td>
                            <td>{{ $day->count }}</td>
                            <td class="fw-700 color-navy">₵{{ number_format($day->revenue, 2) }}</td>
                            <td class="text-success fw-600">₵{{ number_format($day->profit, 2) }}</td>
                            <td class="text-end small text-muted">{{ number_format($margin, 1) }}%</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted small">No sales recorded this month.</td>
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

.products-table thead th { background: #fff; border-bottom: 1px solid #f0f0f0; color: #94a3b8; font-size: 10px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; padding: 1rem 1.5rem; }
.products-table tbody td { padding: 1rem 1.5rem; vertical-align: middle; border-bottom: 1px solid #f8fafc; font-size: 13px; }

.color-navy { color: #1e293b; }
.fw-600 { font-weight: 600; }
.fw-700 { font-weight: 700; }
</style>
@endsection

@section('extra-js')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    const ctx = document.getElementById('monthlyChart').getContext('2d');
    const dailyData = {!! json_encode($dailyData) !!};

    const labels = dailyData.map(d => {
        const date = new Date(d.date);
        return date.getDate();
    });
    const revenue = dailyData.map(d => parseFloat(d.revenue) || 0);
    const profit = dailyData.map(d => parseFloat(d.profit) || 0);

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Revenue (₵)',
                    data: revenue,
                    borderColor: '#22c55e',
                    backgroundColor: '#22c55e',
                    borderWidth: 2,
                    pointRadius: 3,
                    pointBackgroundColor: '#22c55e',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 1,
                    tension: 0,
                    fill: false
                },
                {
                    label: 'Profit (₵)',
                    data: profit,
                    borderColor: '#3b82f6',
                    backgroundColor: '#3b82f6',
                    borderWidth: 2,
                    pointRadius: 3,
                    pointBackgroundColor: '#3b82f6',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 1,
                    tension: 0,
                    fill: false
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
                }
            },
            scales: {
                y: {
                    border: { display: false },
                    grid: { color: '#f1f5f9' },
                    ticks: {
                        color: '#94a3b8',
                        font: { size: 10 },
                        callback: function(value) { return '₵' + value; }
                    }
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
