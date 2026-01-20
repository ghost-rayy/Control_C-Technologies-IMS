@extends('layouts.app')

@section('title', 'Sales History')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title mb-0">
        <i class="bi bi-clock-history"></i> Sales History
    </h1>
    <a href="{{ route('staff.sales.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> New Sale
    </a>
</div>

<div class="card">
    <table class="table mb-0">
        <thead>
            <tr>
                <th>Date & Time</th>
                <th>Items</th>
                <th>Amount</th>
                <th>Payment</th>
                <th>Profit</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($sales as $sale)
                <tr>
                    <td>{{ $sale->created_at->format('d M Y h:i A') }}</td>
                    <td>{{ $sale->items->count() }}</td>
                    <td><strong>₵{{ number_format($sale->total_amount, 2) }}</strong></td>
                    <td>
                        <span class="badge bg-info">{{ $sale->payment_method }}</span>
                    </td>
                    <td class="text-success">₵{{ number_format($sale->getProfit(), 2) }}</td>
                    <td>
                        <a href="{{ route('staff.sales.receipt', $sale->id) }}" class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-eye"></i> View
                        </a>
                        <a href="{{ route('staff.sales.print', $sale->id) }}" class="btn btn-sm btn-outline-secondary" target="_blank">
                            <i class="bi bi-printer"></i> Print
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">
                        No sales recorded yet. <a href="{{ route('staff.sales.create') }}">Create a sale</a>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-3">
    {{ $sales->links() }}
</div>
@endsection
