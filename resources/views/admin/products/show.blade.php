@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title mb-0">
        <i class="bi bi-box-seam"></i> {{ $product->name }}
    </h1>
    <div>
        <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-primary">
            <i class="bi bi-pencil"></i> Edit
        </a>
        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header bg-light">
                <h5 class="mb-0">Product Information</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td class="fw-bold">Name</td>
                        <td>{{ $product->name }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Category</td>
                        <td><span class="badge bg-secondary">{{ $product->category->name }}</span></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Brand</td>
                        <td>{{ $product->brand }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Model</td>
                        <td>{{ $product->model }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">SKU</td>
                        <td>{{ $product->sku ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Serial Number</td>
                        <td>{{ $product->serial_number ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Supplier</td>
                        <td>{{ $product->supplier }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header bg-light">
                <h5 class="mb-0">Pricing & Stock</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-6">
                        <small class="text-muted d-block">Cost Price</small>
                        <h5 class="mb-0">₵{{ number_format($product->cost_price, 2) }}</h5>
                    </div>
                    <div class="col-6">
                        <small class="text-muted d-block">Selling Price</small>
                        <h5 class="mb-0">₵{{ number_format($product->selling_price, 2) }}</h5>
                    </div>
                </div>
                <hr>
                <div class="row mb-3">
                    <div class="col-6">
                        <small class="text-muted d-block">Profit per Unit</small>
                        <h5 class="mb-0 text-success">₵{{ number_format($product->getProfit(), 2) }}</h5>
                    </div>
                    <div class="col-6">
                        <small class="text-muted d-block">Profit Margin</small>
                        <h5 class="mb-0 text-success">{{ number_format($product->getProfitMargin(), 1) }}%</h5>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-6">
                        <small class="text-muted d-block">Quantity in Stock</small>
                        <h5 class="mb-0">
                            <span class="badge {{ $product->isLowStock() ? 'bg-danger' : 'bg-success' }}">
                                {{ $product->quantity_in_stock }}
                            </span>
                        </h5>
                    </div>
                    <div class="col-6">
                        <small class="text-muted d-block">Low Stock Threshold</small>
                        <h5 class="mb-0">{{ $product->low_stock_threshold }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if($product->saleItems->count())
<div class="card">
    <div class="card-header bg-light">
        <h5 class="mb-0">Recent Sales</h5>
    </div>
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Staff</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($product->saleItems()->with('sale.user')->latest()->limit(10)->get() as $item)
                    <tr>
                        <td>{{ $item->sale->created_at->format('d M Y h:i A') }}</td>
                        <td>{{ $item->sale->user->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>₵{{ number_format($item->unit_price, 2) }}</td>
                        <td>₵{{ number_format($item->total_price, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif
@endsection
