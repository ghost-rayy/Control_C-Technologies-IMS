@extends('layouts.app')

@section('title', 'Edit Category')

@section('content')
<div class="mb-4">
    <h1 class="page-title-new mb-1">
        <i class="bi bi-tag-fill text-primary"></i> Edit Category
    </h1>
    <!-- <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0" style="font-size: 11px;">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-muted text-decoration-none">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}" class="text-muted text-decoration-none">Categories</a></li>
            <li class="breadcrumb-item active text-primary fw-bold" aria-current="page">Edit Category</li>
        </ol>
    </nav> -->
</div>

<div class="card recent-sales-card border-0 shadow-sm mb-4" style="max-width: 650px;">
    <div class="card-header bg-white border-bottom py-3">
        <h6 class="mb-1" style="font-weight: 700; color: #1e293b;">Category Information</h6>
        <p class="text-muted small mb-0">Update the category details below</p>
    </div>
    <div class="card-body p-4">
        <form method="POST" action="{{ route('admin.categories.update', $category) }}">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label for="name" class="form-label-new">Category Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                       id="name" name="name" value="{{ old('name', $category->name) }}" 
                       placeholder="Enter category name" required>
                <div class="form-text-small mt-1">Enter a unique name for this category</div>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="description" class="form-label-new">Description</label>
                <textarea class="form-control @error('description') is-invalid @enderror" 
                          id="description" name="description" rows="4" 
                          placeholder="Enter category description (optional)">{{ old('description', $category->description) }}</textarea>
                <div class="form-text-small mt-1">Provide a brief description of what this category includes</div>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-save-new px-3">
                    <i class="bi bi-check-lg"></i> Update Category
                </button>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-cancel-new px-3">
                    <i class="bi bi-x-lg"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<div class="tip-box-blue" style="max-width: 650px;">
    <div class="d-flex gap-2 align-items-center mb-2">
        <i class="bi bi-info-circle-fill text-primary"></i>
        <h6 class="mb-0" style="font-weight: 700; color: #1e293b; font-size: 14px;">Category Guidelines</h6>
    </div>
    <ul class="mb-0 text-muted" style="font-size: 12px; list-style-type: disc; padding-left: 1rem;">
        <li>Category names should be unique and descriptive</li>
        <li>Use clear, concise descriptions to help users understand the category</li>
        <li>Changes will be reflected immediately across the system</li>
    </ul>
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

.form-control {
    border-color: #e2e8f0;
    border-radius: 8px;
    padding: 10px 12px;
    font-size: 0.95rem;
}

.form-control::placeholder {
    color: #94a3b8;
    opacity: 0.6;
}

.form-text-small {
    font-size: 11px;
    color: #64748b;
    font-weight: 500;
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
    background-color: #fff;
    color: #475569;
    border: 1px solid #e2e8f0;
    padding: 10px 24px;
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.2s;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.btn-cancel-new:hover {
    background-color: #f8fafc;
    border-color: #cbd5e1;
}

.tip-box-blue {
    background-color: #eff6ff;
    border: 1px solid #dbeafe;
    border-radius: 12px;
    padding: 1.25rem;
}

.tip-icon-circle {
    width: 32px;
    height: 32px;
    background-color: #3b82f6;
    color: #fff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    flex-shrink: 0;
}
</style>
@endsection
