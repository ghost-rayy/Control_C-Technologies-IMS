@extends('layouts.app')

@section('title', 'Categories')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title-new">
        <i class="bi bi-tag-fill text-primary"></i> Categories
    </h1>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-add-category">
        <i class="bi bi-plus"></i> Add Category
    </a>
</div>

<div class="card recent-sales-card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table categories-table mb-0">
                <thead>
                    <tr>
                        <th style="width: 250px;">Name</th>
                        <th>Description</th>
                        <th class="text-center" style="width: 120px;">Products</th>
                        <th class="text-end" style="width: 200px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                        <tr>
                            <td class="category-name-cell">{{ $category->name }}</td>
                            <td class="text-muted small">{{ $category->description ?? '-' }}</td>
                            <td class="text-center">
                                <span class="products-count-badge">{{ $category->products_count }}</span>
                            </td>
                            <td class="text-end">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-action-outline btn-action-edit">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </a>
                                    <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this category?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-action-outline btn-action-delete">
                                            <i class="bi bi-trash3-fill"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-5">
                                <div class="empty-state">
                                    <i class="bi bi-tags display-4 text-light-grey mb-3 d-block"></i>
                                    <span class="text-muted">No categories found. <a href="{{ route('admin.categories.create') }}">Create one</a></span>
                                </div>
                            </td>
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

.btn-add-category {
    background-color: #3b82f6;
    color: #fff;
    font-weight: 600;
    padding: 8px 16px;
    border-radius: 8px;
    border: none;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-add-category:hover {
    background-color: #2563eb;
    color: #fff;
    transform: translateY(-1px);
    box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.2);
}

.recent-sales-card {
    border-radius: 12px;
    background: #fff;
}

.categories-table thead th {
    background: #fff;
    border-bottom: 1px solid #f0f0f0;
    color: #94a3b8;
    font-size: 10px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    padding: 1.25rem 1.5rem;
}

.categories-table tbody td {
    padding: 1.25rem 1.5rem;
    vertical-align: middle;
    border-bottom: 1px solid #f8fafc;
}

.category-name-cell {
    font-weight: 700;
    color: #1e293b;
    font-size: 0.95rem;
}

.products-count-badge {
    background-color: #f1f5f9;
    color: #64748b;
    font-weight: 600;
    font-size: 0.8rem;
    padding: 4px 12px;
    border-radius: 20px;
}

.btn-action-outline {
    background: #fff;
    border: 1px solid #e2e8f0;
    padding: 6px 14px;
    border-radius: 6px;
    font-size: 0.85rem;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: all 0.2s;
}

.btn-action-edit {
    color: #475569;
}

.btn-action-edit:hover {
    background-color: #f1f5f9;
    border-color: #cbd5e1;
}

.btn-action-delete {
    color: #ef4444;
    border-color: #fee2e2;
}

.btn-action-delete:hover {
    background-color: #fef2f2;
    border-color: #fecaca;
}

.text-light-grey { color: #e2e8f0; }

.empty-state {
    padding: 2rem;
}
</style>
@endsection
