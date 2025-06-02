@extends('layouts.admin')

@section('title', 'Manage Roles - Smart Rental Hub')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manage Roles</h1>
        <a href="{{ route('admin.roles.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle me-2"></i>Create New Role
        </a>
    </div>

    <!-- Roles Table Card -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="bg-light">
                        <tr>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Description</th>
                            <th>Users</th>
                            <th>Permissions</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($roles as $role)
                        <tr>
                            <td class="fw-medium">{{ $role->name }}</td>
                            <td><code>{{ $role->slug }}</code></td>
                            <td>{{ $role->description ?? 'No description' }}</td>
                            <td>
                                <span class="badge bg-info">{{ $role->users_count }} users</span>
                            </td>
                            <td>
                                @if($role->permissions)
                                    @foreach($role->permissions as $permission)
                                        <span class="badge bg-primary me-1">{{ $permission }}</span>
                                    @endforeach
                                @else
                                    <span class="text-muted">No permissions</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('admin.roles.edit', $role) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if($role->slug !== 'admin')
                                    <form action="{{ route('admin.roles.destroy', $role) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this role?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="fas fa-user-shield fa-2x mb-3"></i>
                                    <p class="mb-0">No roles found</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-end mt-4">
                {{ $roles->links() }}
            </div>
        </div>
    </div>
</div>
@endsection 