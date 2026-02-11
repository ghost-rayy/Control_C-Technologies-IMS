@extends('layouts.app')

@section('title', 'Add Category')

@section('content')
<div class="row justify-content-center">
    <div class="col-xl-6 col-lg-8">
        <div class="mb-4">
            <h1 class="page-title-new mb-1">
                <i class="bi bi-tag-fill text-primary"></i> Add New Category
            </h1>
            <p class="text-muted small">Create a new category for organizing your products</p>
        </div>

        <div class="card recent-sales-card border-0 shadow-sm mb-4">
            <div class="card-body p-4 p-lg-5">
                <form method="POST" action="{{ route('admin.categories.store') }}">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="name" class="form-label-new">Category Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name') }}" 
                               placeholder="Enter category name" required>
                        <div class="form-text-small mt-1">Choose a clear and descriptive name for your category</div>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="description" class="form-label-new">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="4" 
                                  placeholder="Enter category description (optional)">{{ old('description') }}</textarea>
                        <div class="form-text-small mt-1">Provide additional details about this category</div>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-save-new px-4">
                            <i class="bi bi-check-lg"></i> Save Category
                        </button>
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-cancel-new px-4">
                            <i class="bi bi-x-lg"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="tip-box-blue mt-4">
            <div class="d-flex gap-3">
                <div class="tip-icon-circle">
                    <i class="bi bi-info-circle-fill"></i>
                </div>
                <div>
                    <h6 class="mb-2" style="font-weight: 700; color: #1e293b; font-size: 14px;">Tips for Creating Categories</h6>
                    <ul class="mb-0 text-muted" style="font-size: 13px; list-style-type: disc; padding-left: 1rem;">
                        <li>Use clear and concise names that users can easily understand</li>
                        <li>Keep categories broad enough to include multiple products</li>
                        <li>Avoid creating too many overlapping categories</li>
                        <li>Add descriptions to help users understand what belongs in each category</li>
                    </ul>
                </div>
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
