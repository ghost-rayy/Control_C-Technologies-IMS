@extends('layouts.app')

@section('title', 'Add Product')

@section('content')
<div class="row justify-content-center">
    <div class="col-xl-8 col-lg-10">
        <div class="mb-4">
            <h1 class="page-title-new mb-1">
                <i class="bi bi-plus-square-fill text-primary"></i> Add New Product
            </h1>
            <p class="text-muted small">Fill in the details below to add a new product to your inventory</p>
        </div>

        <div class="card recent-sales-card border-0 shadow-sm mb-4">
            <div class="card-body p-4 p-lg-5">
                <form method="POST" action="{{ route('admin.products.store') }}">
                    @csrf

                    <div class="row g-4">
                        <div class="col-md-6">
                            <label for="category_id" class="form-label-new">Category <span class="text-danger">*</span></label>
                            <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="name" class="form-label-new">Product Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" 
                                   placeholder="Enter product name" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="brand" class="form-label-new">Brand <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('brand') is-invalid @enderror" 
                                   id="brand" name="brand" value="{{ old('brand') }}" 
                                   placeholder="Enter brand" required>
                            @error('brand')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="model" class="form-label-new">Model <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('model') is-invalid @enderror" 
                                   id="model" name="model" value="{{ old('model') }}" 
                                   placeholder="Enter model" required>
                            @error('model')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="sku" class="form-label-new">SKU</label>
                            <input type="text" class="form-control @error('sku') is-invalid @enderror" 
                                   id="sku" name="sku" value="{{ old('sku') }}" placeholder="Enter SKU">
                            @error('sku')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="serial_number" class="form-label-new">Serial Number</label>
                            <input type="text" class="form-control @error('serial_number') is-invalid @enderror" 
                                   id="serial_number" name="serial_number" value="{{ old('serial_number') }}" 
                                   placeholder="Enter serial number">
                            @error('serial_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="supplier" class="form-label-new">Supplier <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('supplier') is-invalid @enderror" 
                                   id="supplier" name="supplier" value="{{ old('supplier') }}" 
                                   placeholder="Enter supplier name" required>
                            @error('supplier')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="cost_price" class="form-label-new">Cost Price (₵) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0">₵</span>
                                <input type="number" class="form-control border-start-0 @error('cost_price') is-invalid @enderror" 
                                       id="cost_price" name="cost_price" value="{{ old('cost_price') }}" 
                                       step="0.01" placeholder="0.00" required>
                            </div>
                            @error('cost_price')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="selling_price" class="form-label-new">Selling Price (₵) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0">₵</span>
                                <input type="number" class="form-control border-start-0 @error('selling_price') is-invalid @enderror" 
                                       id="selling_price" name="selling_price" value="{{ old('selling_price') }}" 
                                       step="0.01" placeholder="0.00" required>
                            </div>
                            @error('selling_price')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="quantity_in_stock" class="form-label-new">Quantity in Stock <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('quantity_in_stock') is-invalid @enderror" 
                                   id="quantity_in_stock" name="quantity_in_stock" value="{{ old('quantity_in_stock', 0) }}" 
                                   min="0" required>
                            @error('quantity_in_stock')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="low_stock_threshold" class="form-label-new">Low Stock Threshold <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('low_stock_threshold') is-invalid @enderror" 
                                   id="low_stock_threshold" name="low_stock_threshold" value="{{ old('low_stock_threshold', 5) }}" 
                                   min="0" required>
                            @error('low_stock_threshold')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label for="description" class="form-label-new">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="3" 
                                      placeholder="Enter product description (optional)">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-5 pt-4 border-top">
                        <button type="submit" class="btn btn-save-new px-5">
                            <i class="bi bi-check-lg"></i> Save Product
                        </button>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-cancel-new px-4">
                            <i class="bi bi-x-lg"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
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

.form-label-new {
    font-size: 13px;
    font-weight: 600;
    color: #475569;
    margin-bottom: 8px;
    display: block;
}

.form-control, .form-select {
    border-color: #e2e8f0;
    border-radius: 8px;
    padding: 10px 12px;
    font-size: 0.95rem;
}

.form-control::placeholder {
    color: #94a3b8;
    opacity: 0.6;
}

.input-group-text {
    border-color: #e2e8f0;
    border-radius: 8px 0 0 8px;
    color: #64748b;
}

.btn-save-new {
    background-color: #3b82f6;
    color: #fff;
    border: none;
    padding: 10px 24px;
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.2s;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.btn-save-new:hover {
    background-color: #2563eb;
    color: #fff;
}

.btn-cancel-new {
    background-color: #f1f5f9;
    color: #475569;
    border: none;
    padding: 10px 24px;
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.2s;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.btn-cancel-new:hover {
    background-color: #e2e8f0;
}
</style>
@endsection
