@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title-new">
        <i class="bi bi-box-fill text-primary"></i> {{ $product->name }}
    </h1>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-save-new px-3">
            <i class="bi bi-pencil-fill"></i> Edit
        </a>
        <a href="{{ route('admin.products.index') }}" class="btn btn-cancel-new px-3">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card recent-sales-card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-bottom py-3">
                <h6 class="mb-0" style="font-weight: 700; color: #1e293b;">Product Information</h6>
            </div>
            <div class="card-body p-4">
                <div class="info-list">
                    <div class="info-item mb-3 d-flex justify-content-between">
                        <span class="text-muted small fw-500">Name</span>
                        <span class="fw-700 color-navy">{{ $product->name }}</span>
                    </div>
                    <div class="info-item mb-3 d-flex justify-content-between align-items-center">
                        <span class="text-muted small fw-500">Category</span>
                        <span class="category-pill">{{ $product->category->name }}</span>
                    </div>
                    <div class="info-item mb-3 d-flex justify-content-between">
                        <span class="text-muted small fw-500">Brand</span>
                        <span class="fw-700 color-navy">{{ $product->brand }}</span>
                    </div>
                    <div class="info-item mb-3 d-flex justify-content-between">
                        <span class="text-muted small fw-500">Model</span>
                        <span class="fw-700 color-navy">{{ $product->model }}</span>
                    </div>
                    <div class="info-item mb-3 d-flex justify-content-between">
                        <span class="text-muted small fw-500">SKU</span>
                        <span class="fw-700 color-navy">{{ $product->sku ?? '-' }}</span>
                    </div>
                    <div class="info-item mb-3 d-flex justify-content-between">
                        <span class="text-muted small fw-500">Serial Number</span>
                        <span class="fw-700 color-navy">{{ $product->serial_number ?? '-' }}</span>
                    </div>
                    <div class="info-item d-flex justify-content-between">
                        <span class="text-muted small fw-500">Supplier</span>
                        <span class="fw-700 color-navy">{{ $product->supplier }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="card recent-sales-card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-bottom py-3">
                <h6 class="mb-0" style="font-weight: 700; color: #1e293b;">Pricing & Stock</h6>
            </div>
            <div class="card-body p-4">
                <div class="row g-4">
                    <div class="col-6">
                        <small class="text-muted d-block mb-1 small-label">Cost Price</small>
                        <h4 class="mb-0 fw-800 color-navy">₵{{ number_format($product->cost_price, 2) }}</h4>
                    </div>
                    <div class="col-6">
                        <small class="text-muted d-block mb-1 small-label">Selling Price</small>
                        <h4 class="mb-0 fw-800 color-navy">₵{{ number_format($product->selling_price, 2) }}</h4>
                    </div>
                    
                    <div class="col-12 py-1"><hr class="my-0 opacity-5"></div>

                    <div class="col-6">
                        <small class="text-muted d-block mb-1 small-label">Profit per Unit</small>
                        <h4 class="mb-0 fw-800 text-success">₵{{ number_format($product->getProfit(), 2) }}</h4>
                    </div>
                    <div class="col-6">
                        <small class="text-muted d-block mb-1 small-label">Profit Margin</small>
                        <h4 class="mb-0 fw-800 text-success">{{ number_format($product->getProfitMargin(), 1) }}%</h4>
                    </div>

                    <div class="col-12 py-1"><hr class="my-0 opacity-5"></div>

                    <div class="col-6">
                        <small class="text-muted d-block mb-1 small-label">Quantity in Stock</small>
                        <span class="badge-circle {{ $product->isLowStock() ? 'badge-red' : 'badge-green' }} mt-1">
                            {{ $product->quantity_in_stock }}
                        </span>
                    </div>
                    <div class="col-6">
                        <small class="text-muted d-block mb-2 small-label">Low Stock Threshold</small>
                        <h4 class="mb-0 fw-800 color-navy">{{ $product->low_stock_threshold }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card recent-sales-card border-0 shadow-sm mt-2">
    <div class="card-header bg-white border-bottom py-3">
        <h6 class="mb-0" style="font-weight: 700; color: #1e293b;">Recent Sales</h6>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table products-table mb-0">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Staff</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th class="text-end">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($product->saleItems()->with('sale.user')->latest()->limit(10)->get() as $item)
                        <tr>
                            <td class="small text-muted">{{ $item->sale->created_at->format('d M Y h:i A') }}</td>
                            <td class="fw-600 color-navy">{{ $item->sale->user->name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>₵{{ number_format($item->unit_price, 2) }}</td>
                            <td class="text-end fw-700 color-navy">₵{{ number_format($item->total_price, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted small">No recent sales for this product.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

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

.btn-save-new {
    background-color: #3b82f6;
    color: #fff;
    border: none;
    padding: 8px 18px;
    border-radius: 8px;
    font-weight: 600;
    font-size: 13px;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.2s;
}

.btn-save-new:hover { background-color: #2563eb; color: #fff; }

.btn-cancel-new {
    background-color: #f1f5f9;
    color: #475569;
    border: none;
    padding: 8px 18px;
    border-radius: 8px;
    font-weight: 600;
    font-size: 13px;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.2s;
}

.btn-cancel-new:hover { background-color: #e2e8f0; }

.info-item { border-bottom: 1px solid #f8fafc; padding-bottom: 3px; }
.info-item:last-child { border-bottom: none; }

.color-navy { color: #1e293b; }
.fw-500 { font-weight: 500; }
.fw-600 { font-weight: 600; }
.fw-700 { font-weight: 700; }
.fw-800 { font-weight: 800; }

.category-pill {
    padding: 4px 12px;
    border-radius: 20px;
    background-color: #f1f5f9;
    color: #64748b;
    font-size: 10px;
    font-weight: 600;
}

.small-label { font-size: 10px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; }

.badge-circle {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    font-weight: 700;
    font-size: 0.9rem;
    color: white;
}

.badge-red { background-color: #ef4444; }
.badge-green { background-color: #22c55e; }

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
</style>
@endsection
