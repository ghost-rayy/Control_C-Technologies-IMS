@extends('layouts.app')

@section('title', 'Sales Receipt')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title mb-0">
        <i class="bi bi-receipt"></i> Sales Receipt
    </h1>
    <div>
        <a href="{{ route('staff.sales.print', $sale->id) }}" class="btn btn-primary" target="_blank">
            <i class="bi bi-printer"></i> Print Receipt
        </a>
        <a href="{{ route('staff.dashboard') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>
</div>

<div class="card" style="max-width: 600px;">
    <div class="card-body">
        <div class="text-center mb-4 pb-3" style="border-bottom: 2px solid #e0e0e0;">
            <h4>RECEIPT</h4>
            <p class="mb-0 text-muted">{{ config('app.name', 'Inventory & Sales Management System') }}</p>
        </div>

        <div class="mb-3">
            <div class="row">
                <div class="col-6">
                    <small class="text-muted">Receipt #:</small>
                    <p class="mb-0"><strong>#{{ str_pad($sale->id, 6, '0', STR_PAD_LEFT) }}</strong></p>
                </div>
                <div class="col-6 text-end">
                    <small class="text-muted">Date & Time:</small>
                    <p class="mb-0"><strong>{{ $sale->created_at->format('d M Y h:i A') }}</strong></p>
                </div>
            </div>
        </div>

        <div class="mb-3 pb-3" style="border-bottom: 1px solid #e0e0e0;">
            <small class="text-muted">Sales Attendant:</small>
            <p class="mb-0"><strong>{{ $sale->user->name }}</strong></p>
        </div>

        <table class="table table-borderless mb-0">
            <thead>
                <tr style="border-bottom: 2px solid #e0e0e0;">
                    <th>Product</th>
                    <th class="text-center">Qty</th>
                    <th class="text-end">Price</th>
                    <th class="text-end">Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sale->items as $item)
                    <tr>
                        <td>
                            <div class="small">{{ $item->product->name }}</div>
                            <small class="text-muted">{{ $item->product->brand }} - {{ $item->product->model }}</small>
                        </td>
                        <td class="text-center">{{ $item->quantity }}</td>
                        <td class="text-end">₵{{ number_format($item->unit_price, 2) }}</td>
                        <td class="text-end"><strong>₵{{ number_format($item->total_price, 2) }}</strong></td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-3 pt-3" style="border-top: 2px solid #e0e0e0;">
            <table class="table table-borderless mb-0">
                <tr>
                    <td class="text-end" style="width: 70%;">Subtotal:</td>
                    <td class="text-end"><strong>₵{{ number_format($sale->total_amount, 2) }}</strong></td>
                </tr>
                <tr style="border-top: 2px solid #e0e0e0;">
                    <td class="text-end" style="font-size: 18px;"><strong>TOTAL:</strong></td>
                    <td class="text-end" style="font-size: 18px;"><strong>₵{{ number_format($sale->total_amount, 2) }}</strong></td>
                </tr>
            </table>
        </div>

        <div class="mt-3 pt-3" style="border-top: 1px solid #e0e0e0;">
            <div class="row">
                <div class="col-6">
                    <small class="text-muted">Payment Method:</small>
                    <p class="mb-0"><strong>{{ $sale->payment_method }}</strong></p>
                </div>
                <div class="col-6 text-end">
                    <small class="text-muted">Profit:</small>
                    <p class="mb-0"><strong class="text-success">₵{{ number_format($sale->getProfit(), 2) }}</strong></p>
                </div>
            </div>
        </div>

        @if($sale->transaction_ref)
            <div class="mt-2 text-center">
                <small class="text-muted">Transaction Ref: {{ $sale->transaction_ref }}</small>
            </div>
        @endif

        <div class="mt-4 text-center text-muted">
            <small>Thank you for shopping with us!</small>
            <p class="mb-0"><small>Please keep this receipt for your records</small></p>
        </div>
    </div>
</div>
@endsection
