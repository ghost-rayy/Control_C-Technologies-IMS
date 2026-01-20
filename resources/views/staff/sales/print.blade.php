@extends('layouts.app')

@section('title', 'Print Receipt')

@section('content')
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: 'Courier New', monospace;
            width: 80mm;
            margin: 0;
            padding: 10mm;
        }
        .receipt {
            text-align: center;
        }
        .header {
            border-bottom: 1px dashed #000;
            margin-bottom: 10px;
            padding-bottom: 10px;
        }
        .items {
            border-bottom: 1px dashed #000;
            margin-bottom: 10px;
            padding-bottom: 10px;
            text-align: left;
        }
        .item {
            margin-bottom: 5px;
            font-size: 12px;
        }
        .line {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
        }
        .total-section {
            border-top: 1px dashed #000;
            border-bottom: 1px dashed #000;
            margin: 10px 0;
            padding: 10px 0;
        }
        .total {
            text-align: right;
            font-weight: bold;
            font-size: 14px;
            margin-top: 5px;
        }
        .footer {
            margin-top: 10px;
            font-size: 11px;
            text-align: center;
        }
        @media print {
            body {
                margin: 0;
                padding: 0;
            }
        }
    </style>
</head>
<body onload="window.print();">
    <div class="receipt">
        <div class="header">
            <h3 style="margin: 0;">RECEIPT</h3>
            <p style="margin: 5px 0; font-size: 11px;">{{ config('app.name', 'IMS') }}</p>
            <p style="margin: 5px 0; font-size: 10px;">Receipt #{{ str_pad($sale->id, 6, '0', STR_PAD_LEFT) }}</p>
            <p style="margin: 0; font-size: 10px;">{{ $sale->created_at->format('d M Y h:i A') }}</p>
        </div>

        <div class="items">
            @foreach($sale->items as $item)
                <div class="item">
                    <div>{{ substr($item->product->name, 0, 30) }}</div>
                    <div class="line">
                        <span>{{ $item->quantity }}x ₵{{ number_format($item->unit_price, 2) }}</span>
                        <span>₵{{ number_format($item->total_price, 2) }}</span>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="total-section">
            <div class="line">
                <span>TOTAL:</span>
                <span style="font-weight: bold;">₵{{ number_format($sale->total_amount, 2) }}</span>
            </div>
            <div class="line" style="margin-top: 5px; font-size: 11px;">
                <span>Payment: {{ $sale->payment_method }}</span>
            </div>
        </div>

        <div class="footer">
            <p style="margin: 5px 0;">Thank you for your purchase!</p>
            <p style="margin: 0;">Attendant: {{ $sale->user->name }}</p>
            @if($sale->transaction_ref)
                <p style="margin: 5px 0; font-size: 10px;">Ref: {{ $sale->transaction_ref }}</p>
            @endif
        </div>
    </div>
</body>
</html>
@endsection
