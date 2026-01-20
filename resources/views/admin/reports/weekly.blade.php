@extends('layouts.app')

@section('title', 'Weekly Report')

@section('content')
<h1 class="page-title">
    <i class="bi bi-calendar-week"></i> Weekly Sales Report
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
        <h5 class="mb-0">Daily Breakdown ({{ $startDate->format('d M Y') }} - {{ $endDate->format('d M Y') }})</h5>
    </div>
    <div class="card-body">
        <canvas id="weeklyChart"></canvas>
    </div>
</div>

<div class="card">
    <div class="card-header bg-light">
        <h5 class="mb-0">Sales by Day</h5>
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
                    </tr>
                </thead>
                <tbody>
                    @foreach($dailyData as $day)
                        <tr>
                            <td><strong>{{ \Carbon\Carbon::createFromFormat('Y-m-d', $day->date)->format('d M Y (l)') }}</strong></td>
                            <td>{{ $day->count }}</td>
                            <td>₵{{ number_format($day->revenue, 2) }}</td>
                            <td class="text-success">₵{{ number_format($day->profit, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="p-4 text-center text-muted">
                <p>No sales recorded this week</p>
            </div>
        @endif
    </div>
</div>
@endsection

@section('extra-js')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    const ctx = document.getElementById('weeklyChart').getContext('2d');
    const dailyData = {!! json_encode($dailyData) !!};

    const labels = dailyData.map(d => new Date(d.date).toLocaleDateString('en-US', { weekday: 'short', month: 'short', day: 'numeric' }));
    const revenue = dailyData.map(d => parseFloat(d.revenue) || 0);
    const profit = dailyData.map(d => parseFloat(d.profit) || 0);

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Revenue (₵)',
                    data: revenue,
                    backgroundColor: 'rgba(39, 174, 96, 0.7)',
                    borderColor: '#27ae60',
                    borderWidth: 1
                },
                {
                    label: 'Profit (₵)',
                    data: profit,
                    backgroundColor: 'rgba(52, 152, 219, 0.7)',
                    borderColor: '#3498db',
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
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
