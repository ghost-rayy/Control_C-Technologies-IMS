@extends('layouts.app')

@section('title', 'Staff Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title mb-0">
        <i class="bi bi-people"></i> Staff Management
    </h1>
    <a href="{{ route('admin.staff.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Add Staff
    </a>
</div>

<div class="card">
    <table class="table mb-0">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Status</th>
                <th>Joined</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($staff as $member)
                <tr>
                    <td><strong>{{ $member->name }}</strong></td>
                    <td>{{ $member->email }}</td>
                    <td>
                        @if($member->is_active)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-danger">Inactive</span>
                        @endif
                    </td>
                    <td>{{ $member->created_at->format('d M Y') }}</td>
                    <td>
                        <a href="{{ route('admin.staff.edit', $member) }}" class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form method="POST" action="{{ route('admin.staff.toggle-active', $member) }}" style="display: inline;">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-sm {{ $member->is_active ? 'btn-outline-warning' : 'btn-outline-success' }}">
                                <i class="bi bi-{{ $member->is_active ? 'lock' : 'unlock' }}"></i>
                            </button>
                        </form>
                        <form method="POST" action="{{ route('admin.staff.destroy', $member) }}" style="display: inline;" onsubmit="return confirm('Are you sure?');">
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
                    <td colspan="5" class="text-center text-muted py-4">
                        No staff members found. <a href="{{ route('staff.create') }}">Create one</a>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-3">
    {{ $staff->links() }}
</div>
@endsection
