@extends('layouts.app')

@section('title', 'Monthly Report')

@section('content')
<h1 class="page-title">
    <i class="bi bi-calendar-month"></i> Monthly Sales Report - {{ $startDate->format('F Y') }}
</h1>

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
        <div class="card metric-card success">
            <div class="metric-value">₵{{ number_format($summary['total_profit'], 2) }}</div>
            <div class="metric-label">Total Profit</div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card metric-card">
            <div class="metric-value">{{ number_format($summary['profit_margin'], 1) }}%</div>
            <div class="metric-label">Profit Margin</div>
        </div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header bg-light">
        <h5 class="mb-0">Daily Sales Trend</h5>
    </div>
    <div class="card-body">
        <canvas id="monthlyChart"></canvas>
    </div>
</div>

<div class="card">
    <div class="card-header bg-light">
        <h5 class="mb-0">Daily Breakdown</h5>
    </div>
    <div class="card-body p-0">
        @if($dailyData->count())
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Sales Count</th>
                        <th>Revenue</th>
                        <th>Profit</th>
                        <th>Margin</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dailyData as $day)
                        @php
                            $margin = $day->revenue > 0 ? (($day->profit / $day->revenue) * 100) : 0;
                        @endphp
                        <tr>
                            <td><strong>{{ \Carbon\Carbon::createFromFormat('Y-m-d', $day->date)->format('d M Y (l)') }}</strong></td>
                            <td>{{ $day->count }}</td>
                            <td>₵{{ number_format($day->revenue, 2) }}</td>
                            <td class="text-success">₵{{ number_format($day->profit, 2) }}</td>
                            <td>{{ number_format($margin, 1) }}%</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="p-4 text-center text-muted">
                <p>No sales recorded this month</p>
            </div>
        @endif
    </div>
</div>
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
                    borderColor: '#27ae60',
                    backgroundColor: 'rgba(39, 174, 96, 0.1)',
                    tension: 0.4,
                    fill: true,
                    yAxisID: 'y'
                },
                {
                    label: 'Profit (₵)',
                    data: profit,
                    borderColor: '#3498db',
                    backgroundColor: 'rgba(52, 152, 219, 0.1)',
                    tension: 0.4,
                    fill: true,
                    yAxisID: 'y'
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
                        text: 'Amount (₵)'
                    }
                }
            }
        }
    });
</script>
@endsection
