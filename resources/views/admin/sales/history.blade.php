@extends('layouts.app')

@section('title', 'Sales History | Inventory Management')

@section('content')
<div class="mb-4">
    <h1 class="page-title-new">
        <i class="bi bi-clock-history text-primary"></i> Sales History
    </h1>
</div>

@if ($sales->count() > 0)
    <div class="card recent-sales-card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table products-table mb-0">
                    <thead>
                        <tr>
                            <th>Receipt #</th>
                            <th>Date & Time</th>
                            <th>Items</th>
                            <th>Payment</th>
                            <th>Amount</th>
                            <th>Profit</th>
                            <th>Cashier</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sales as $sale)
                            <tr>
                                <td class="fw-700 color-navy">#{{ str_pad($sale->id, 6, '0', STR_PAD_LEFT) }}</td>
                                <td class="small text-muted">{{ $sale->created_at->format('d/m/Y H:i') }}</td>
                                <td>{{ $sale->items->count() }} item(s)</td>
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
                                <td class="fw-700 color-navy">₵{{ number_format($sale->total_amount, 2) }}</td>
                                <td class="text-success fw-700">₵{{ number_format($sale->total_amount - $sale->total_cost, 2) }}</td>
                                <td class="fw-600 color-navy">{{ $sale->user->name }}</td>
                                <td class="text-end">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('admin.sales.receipt', $sale->id) }}" class="btn-action-view" title="View">
                                            <i class="bi bi-eye-fill"></i>
                                        </a>
                                        <a href="{{ route('admin.sales.print', $sale->id) }}" class="btn-action-view" title="Print">
                                            <i class="bi bi-printer-fill"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            {{-- Item Details Row --}}
                            <tr>
                                <td colspan="8" class="py-2 border-0" style="background-color: #fbfcfe;">
                                    <div class="px-3">
                                        <small class="text-muted" style="font-size: 11px;">
                                            <span class="fw-600">Items:</span>
                                            @foreach ($sale->items as $item)
                                                {{ $item->product->name }} ({{ $item->quantity }})@if (!$loop->last), @endif
                                            @endforeach
                                            @if ($sale->transaction_ref)
                                                <span class="mx-2">|</span> <span class="fw-600">Ref:</span> {{ $sale->transaction_ref }}
                                            @endif
                                        </small>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $sales->links() }}
    </div>
@else
    <div class="card recent-sales-card border-0 shadow-sm">
        <div class="card-body p-5 text-center">
            <i class="bi bi-clock-history display-4 text-light-grey mb-3 d-block"></i>
            <h5 class="text-muted">No sales records found.</h5>
            <p class="text-muted small">Once you start recording sales, they will appear here.</p>
        </div>
    </div>
@endif

<style>
.page-title-new {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1e293b;
    display: flex;
    align-items: center;
    gap: 12px;
}

.recent-sales-card {
    border-radius: 12px;
    background: #fff;
}

.products-table thead th {
    background: #fff;
    border-bottom: 1px solid #f0f0f0;
    color: #94a3b8;
    font-size: 10px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    padding: 1rem 1.5rem;
}

.products-table tbody td {
    padding: 1rem 1.5rem;
    vertical-align: middle;
    border-bottom: 1px solid #f8fafc;
    font-size: 13px;
}

.color-navy { color: #1e293b; }
.fw-600 { font-weight: 600; }
.fw-700 { font-weight: 700; }

.badge-payment {
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 10px;
    font-weight: 700;
}
.badge-cash { background-color: #eff6ff; color: #3b82f6; }
.badge-momo { background-color: #f0fdf4; color: #22c55e; }
.badge-card { background-color: #faf5ff; color: #a855f7; }

.btn-action-view {
    width: 32px;
    height: 32px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background: #f1f5f9;
    color: #64748b;
    transition: all 0.2s;
    border: none;
}
.btn-action-view:hover {
    background: #3b82f6;
    color: #fff;
}

.text-light-grey { color: #e2e8f0; }

/* Customizing Pagination to match premium theme */
.pagination {
    gap: 5px;
}
.page-link {
    border: none;
    border-radius: 8px !important;
    padding: 8px 16px;
    color: #64748b;
    font-weight: 600;
    font-size: 13px;
}
.page-item.active .page-link {
    background-color: #3b82f6;
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.2);
}
</style>
@endsection
