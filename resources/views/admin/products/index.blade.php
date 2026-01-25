@extends('layouts.app')

@section('title', 'Products')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title-new">
        <i class="bi bi-box-fill text-primary"></i> Products
    </h1>
    <a href="{{ route('admin.products.create') }}" class="btn btn-add-product">
        <i class="bi bi-plus"></i> Add Product
    </a>
</div>

<div class="card recent-sales-card border-0 shadow-sm mb-4">
    <div class="card-body p-3">
        <form method="GET" action="{{ route('admin.products.index') }}" class="row g-2 align-items-center">
            <div class="col-md-5">
                <input type="text" name="search" class="form-control-new" placeholder="Search products..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-search-new w-100">
                    <i class="bi bi-search"></i> Search
                </button>
            </div>
            <div class="col-md-2">
                <a href="{{ route('admin.products.index') }}" class="btn btn-reset-new w-100">
                    <i class="bi bi-arrow-clockwise"></i> Reset
                </a>
            </div>
        </form>
    </div>
</div>

<div class="card recent-sales-card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table products-table mb-0">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Category</th>
                        <th>Brand</th>
                        <th class="text-center">Stock</th>
                        <th>Cost/Selling</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr>
                            <td>
                                <div class="product-info-cell">
                                    <span class="product-name-bold">{{ $product->name }}</span>
                                    <span class="product-sku">{{ $product->model ?? 'SKU-'.$product->id }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="category-pill">{{ $product->category->name }}</span>
                            </td>
                            <td>{{ $product->brand }}</td>
                            <td class="text-center">
                                <span class="badge-circle {{ $product->isLowStock() ? 'badge-red' : 'badge-green' }}">
                                    {{ $product->quantity_in_stock }}
                                </span>
                            </td>
                            <td class="price-cell">
                                ₵{{ number_format($product->cost_price, 2) }} / ₵{{ number_format($product->selling_price, 2) }}
                            </td>
                            <td>
                                @if($product->isLowStock())
                                    <span class="status-pill status-low">Low Stock</span>
                                @else
                                    <span class="status-pill status-in">In Stock</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('admin.products.show', $product) }}" class="btn-action-view" title="View Details">
                                        <i class="bi bi-eye-fill"></i>
                                    </a>
                                    <a href="{{ route('admin.products.edit', $product) }}" class="btn-action-view" title="Edit Product">
                                        <i class="bi bi-pencil-fill"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.products.destroy', $product) }}" style="display: inline;" onsubmit="return confirm('Are you sure?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action-view text-danger border-0" title="Delete Product">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="empty-state">
                                    <i class="bi bi-box display-4 text-light-grey mb-3 d-block"></i>
                                    <span class="text-muted">No products found. <a href="{{ route('admin.products.create') }}">Create one</a></span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-4 d-flex justify-content-between align-items-center">
    <div class="text-muted small">
        Showing {{ $products->firstItem() ?? 0 }} to {{ $products->lastItem() ?? 0 }} of {{ $products->total() }} results
    </div>
    <div>
        {{ $products->links() }}
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

.btn-add-product {
    background-color: #3b82f6;
    color: #fff;
    font-weight: 600;
    padding: 8px 16px;
    border-radius: 8px;
}

.btn-add-product:hover {
    background-color: #2563eb;
    color: #fff;
}

.form-control-new {
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 8px 12px;
    width: 100%;
}

.btn-search-new {
    background-color: #eff6ff;
    color: #3b82f6;
    border: 1px solid #dbeafe;
    border-radius: 8px;
    padding: 8px 16px;
    font-weight: 600;
}

.btn-search-new:hover {
    background-color: #dbeafe;
}

.btn-reset-new {
    background-color: #f8fafc;
    color: #64748b;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 8px 16px;
    font-weight: 600;
    text-decoration: none;
    display: inline-block;
    text-align: center;
}

.btn-reset-new:hover {
    background-color: #f1f5f9;
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
    padding: 1.25rem 1.5rem;
}

.products-table tbody td {
    padding: 1.25rem 1.5rem;
    vertical-align: middle;
    border-bottom: 1px solid #f8fafc;
}

.product-info-cell {
    display: flex;
    flex-direction: column;
}

.product-name-bold {
    font-weight: 700;
    color: #1e293b;
    font-size: 0.95rem;
}

.product-sku {
    font-size: 11px;
    color: #94a3b8;
}

.category-pill {
    display: inline-block;
    padding: 4px 12px;
    border-radius: 20px;
    background-color: #f1f5f9;
    color: #64748b;
    font-size: 10px;
    font-weight: 600;
}

.badge-circle {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 28px;
    height: 28px;
    border-radius: 50%;
    font-weight: 600;
    font-size: 0.8rem;
    color: white;
}

.badge-red { background-color: #ef4444; }
.badge-green { background-color: #22c55e; }

.price-cell {
    font-weight: 500;
    color: #475569;
    font-size: 0.9rem;
}

.status-pill {
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 10px;
    font-weight: 700;
}

.status-in { background-color: #f0fdf4; color: #16a34a; }
.status-low { background-color: #fffbeb; color: #d97706; }

.btn-action-view {
    width: 32px;
    height: 32px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background: #f1f5f9;
    color: #3b82f6;
    transition: all 0.2s;
    text-decoration: none;
}

.btn-action-view:hover {
    background: #e2e8f0;
}

.text-light-grey { color: #e2e8f0; }
</style>
@endsection
