@extends('layouts.app')

@section('title', 'Categories')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title mb-0">
        <i class="bi bi-tags"></i> Categories
    </h1>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Add Category
    </a>
</div>

<div class="card">
    <table class="table mb-0">
        <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Products</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($categories as $category)
                <tr>
                    <td><strong>{{ $category->name }}</strong></td>
                    <td>{{ $category->description ?? '-' }}</td>
                    <td>
                        <span class="badge bg-secondary">{{ $category->products_count }}</span>
                    </td>
                    <td>
                        <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" style="display: inline;" onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash"></i> Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center text-muted py-4">
                        No categories found. <a href="{{ route('admin.categories.create') }}">Create one</a>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
