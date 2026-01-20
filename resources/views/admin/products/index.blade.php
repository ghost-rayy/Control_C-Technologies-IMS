@extends('layouts.app')

@section('title', 'Products')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title mb-0">
        <i class="bi bi-box-seam"></i> Products
    </h1>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Add Product
    </a>
</div>

<div class="card mb-3">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.products.index') }}" class="row g-2">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Search products..." value="{{ request('search') }}">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-outline-primary w-100">
                    <i class="bi bi-search"></i> Search
                </button>
            </div>
            <div class="col-md-4">
                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary w-100">
                    <i class="bi bi-arrow-clockwise"></i> Reset
                </a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <table class="table mb-0">
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Category</th>
                <th>Brand</th>
                <th>Stock</th>
                <th>Cost/Selling</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
                <tr>
                    <td>
                        <strong>{{ $product->name }}</strong>
                        <br><small class="text-muted">{{ $product->model }}</small>
                    </td>
                    <td>
                        <span class="badge bg-secondary">{{ $product->category->name }}</span>
                    </td>
                    <td>{{ $product->brand }}</td>
                    <td>
                        <span class="badge {{ $product->isLowStock() ? 'bg-danger' : 'bg-success' }}">
                            {{ $product->quantity_in_stock }}
                        </span>
                    </td>
                    <td>
                        ₵{{ number_format($product->cost_price, 2) }} / ₵{{ number_format($product->selling_price, 2) }}
                    </td>
                    <td>
                        @if($product->isLowStock())
                            <span class="badge bg-warning">Low Stock</span>
                        @else
                            <span class="badge bg-success">In Stock</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.products.show', $product) }}" class="btn btn-sm btn-outline-info">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form method="POST" action="{{ route('admin.products.destroy', $product) }}" style="display: inline;" onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">
                        No products found. <a href="{{ route('products.create') }}">Create one</a>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-3">
    {{ $products->links() }}
</div>
@endsection
