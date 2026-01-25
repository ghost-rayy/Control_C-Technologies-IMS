@extends('layouts.app')

@section('title', 'Sale Receipt | Inventory Management')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <!-- Header -->
                    <div class="text-center mb-4">
                        <h3 class="mb-1">Control C-Technology</h3>
                        <small class="text-muted">Inventory & Sales Management System</small>
                    </div>

                    <hr>

                    <!-- Receipt Info -->
                    <div class="row mb-3">
                        <div class="col-6">
                            <small class="text-muted">Receipt No:</small>
                            <p class="mb-0"><strong>{{ $sale->id }}</strong></p>
                        </div>
                        <div class="col-6 text-end">
                            <small class="text-muted">Date:</small>
                            <p class="mb-0"><strong>{{ $sale->created_at->format('d/m/Y H:i') }}</strong></p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-6">
                            <small class="text-muted">Payment:</small>
                            <p class="mb-0"><strong>{{ $sale->payment_method }}</strong></p>
                        </div>
                        <div class="col-6 text-end">
                            <small class="text-muted">Cashier:</small>
                            <p class="mb-0"><strong>{{ $sale->user->name }}</strong></p>
                        </div>
                    </div>

                    <hr>

                    <!-- Items -->
                    <div class="mb-3">
                        <table class="table table-sm table-borderless">
                            <thead class="border-bottom">
                                <tr>
                                    <th>Item</th>
                                    <th class="text-end">Qty</th>
                                    <th class="text-end">Price</th>
                                    <th class="text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sale->items as $item)
                                <tr>
                                    <td>{{ $item->product->name }}</td>
                                    <td class="text-end">{{ $item->quantity }}</td>
                                    <td class="text-end">GHS {{ number_format($item->unit_price, 2) }}</td>
                                    <td class="text-end"><strong>GHS {{ number_format($item->total_price, 2) }}</strong></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <hr>

                    <!-- Summary -->
                    <div class="row mb-3">
                        <div class="col-6">
                            <small class="text-muted">Subtotal:</small>
                        </div>
                        <div class="col-6 text-end">
                            <small>GHS {{ number_format($sale->total_amount, 2) }}</small>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-6">
                            <small class="text-muted">Total Cost:</small>
                        </div>
                        <div class="col-6 text-end">
                            <small>GHS {{ number_format($sale->total_cost, 2) }}</small>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-6">
                            <small class="text-muted">Profit:</small>
                        </div>
                        <div class="col-6 text-end">
                            <small class="text-success"><strong>GHS {{ number_format($sale->total_amount - $sale->total_cost, 2) }}</strong></small>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-6">
                            <strong>TOTAL:</strong>
                        </div>
                        <div class="col-6 text-end">
                            <h5 class="mb-0">GHS {{ number_format($sale->total_amount, 2) }}</h5>
                        </div>
                    </div>

                    <hr>

                    <!-- Transaction Reference -->
                    @if ($sale->transaction_ref)
                    <div class="text-center mb-3">
                        <small class="text-muted">Ref: <strong>{{ $sale->transaction_ref }}</strong></small>
                    </div>
                    @endif

                    <!-- Footer -->
                    <div class="text-center mt-4 pt-3 border-top">
                        <p class="small text-muted mb-2">Thank you for your purchase!</p>
                        <p class="small text-muted">{{ now()->format('d/m/Y H:i:s') }}</p>
                    </div>

                    <!-- Actions -->
                    <div class="d-flex gap-2 mt-4">
                        <button class="btn btn-primary flex-grow-1" onclick="window.print()">
                            <i class="bi bi-printer"></i> Print
                        </button>
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary flex-grow-1">
                            <i class="bi bi-house"></i> Dashboard
                        </a>
                        <a href="{{ route('admin.sales.create') }}" class="btn btn-success flex-grow-1">
                            <i class="bi bi-plus-circle"></i> New Sale
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    .btn {
        display: none;
    }

    body {
        background: white;
        padding: 0;
    }

    .card {
        box-shadow: none;
        border: none;
    }
}
</style>
@endsection
