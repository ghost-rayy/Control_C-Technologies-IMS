<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sale Receipt - {{ $sale->id }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Courier New', monospace;
            width: 80mm;
            padding: 10mm;
        }

        .header {
            text-align: center;
            margin-bottom: 10mm;
            border-bottom: 1px solid #000;
            padding-bottom: 5mm;
        }

        .header h3 {
            font-size: 16pt;
            margin-bottom: 2mm;
        }

        .header p {
            font-size: 8pt;
            color: #666;
        }

        .receipt-info {
            font-size: 8pt;
            margin-bottom: 5mm;
        }

        .receipt-info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 2mm;
        }

        .items-table {
            width: 100%;
            font-size: 8pt;
            margin: 5mm 0;
            border-collapse: collapse;
        }

        .items-table thead {
            border-bottom: 1px solid #000;
        }

        .items-table th {
            text-align: left;
            padding: 2mm 0;
            font-weight: bold;
        }

        .items-table td {
            padding: 2mm 0;
        }

        .qty-col, .price-col, .total-col {
            text-align: right;
        }

        .items-table tbody {
            border-bottom: 1px solid #000;
        }

        .summary {
            font-size: 8pt;
            margin-top: 5mm;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1mm;
        }

        .summary-row.total {
            border-top: 1px dashed #000;
            padding-top: 2mm;
            font-weight: bold;
            font-size: 10pt;
            margin-top: 3mm;
        }

        .footer {
            text-align: center;
            font-size: 7pt;
            margin-top: 10mm;
            color: #666;
        }

        .footer p {
            margin-bottom: 1mm;
        }

        @media print {
            body {
                width: 100%;
                padding: 0;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h3>Control C-Technology</h3>
        <p>Inventory & Sales Management System</p>
    </div>

    <div class="receipt-info">
        <div class="receipt-info-row">
            <span>Receipt #{{ $sale->id }}</span>
            <span>{{ $sale->created_at->format('d/m/Y') }}</span>
        </div>
        <div class="receipt-info-row">
            <span>{{ $sale->created_at->format('H:i:s') }}</span>
            <span>{{ $sale->payment_method }}</span>
        </div>
        <div class="receipt-info-row">
            <span>Cashier: {{ $sale->user->name }}</span>
        </div>
    </div>

    <table class="items-table">
        <thead>
            <tr>
                <th>Item</th>
                <th class="qty-col">Qty</th>
                <th class="price-col">Price</th>
                <th class="total-col">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sale->items as $item)
            <tr>
                <td>{{ $item->product->name }}</td>
                <td class="qty-col">{{ $item->quantity }}</td>
                <td class="price-col">{{ number_format($item->unit_price, 0) }}</td>
                <td class="total-col">{{ number_format($item->total_price, 0) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary">
        <div class="summary-row">
            <span>Subtotal:</span>
            <span>GHS {{ number_format($sale->total_amount, 2) }}</span>
        </div>
        <div class="summary-row total">
            <span>TOTAL:</span>
            <span>GHS {{ number_format($sale->total_amount, 2) }}</span>
        </div>
    </div>

    @if ($sale->transaction_ref)
    <div class="receipt-info">
        <div class="receipt-info-row">
            <span>Ref: {{ $sale->transaction_ref }}</span>
        </div>
    </div>
    @endif

    <div class="footer">
        <p>Thank you for your purchase!</p>
        <p>{{ now()->format('d/m/Y H:i:s') }}</p>
    </div>

    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>
