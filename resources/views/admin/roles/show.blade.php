@extends('layouts.admin')

@section('title', $role->name . ' Role Details - Smart Rental Hub')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Role Details</h1>
        <div class="btn-group">
            <a href="{{ route('admin.roles.edit', $role) }}" class="btn btn-primary">
                <i class="fas fa-edit me-2"></i>Edit Role
            </a>
            <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to Roles
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Role Information Card -->
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">Role Information</h5>
                </div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-3">Name</dt>
                        <dd class="col-sm-9">{{ $role->name }}</dd>

                        <dt class="col-sm-3">Slug</dt>
                        <dd class="col-sm-9"><code>{{ $role->slug }}</code></dd>

                        <dt class="col-sm-3">Description</dt>
                        <dd class="col-sm-9">{{ $role->description ?: 'No description provided' }}</dd>

                        <dt class="col-sm-3">Created</dt>
                        <dd class="col-sm-9">{{ $role->created_at->format('M d, Y H:i') }}</dd>

                        <dt class="col-sm-3">Updated</dt>
                        <dd class="col-sm-9">{{ $role->updated_at->format('M d, Y H:i') }}</dd>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Permissions Card -->
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">Permissions</h5>
                </div>
                <div class="card-body">
                    @if($role->permissions && count($role->permissions) > 0)
                        <div class="row g-2">
                            @foreach($role->permissions as $permission)
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-check-circle text-success me-2"></i>
                                        <span>{{ Str::title(str_replace('_', ' ', $permission)) }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted mb-0">No permissions assigned to this role.</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Users with this Role Card -->
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Users with this Role</h5>
                </div>
                <div class="card-body">
                    @if($role->users->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Joined</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($role->users as $user)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=4e73df&color=ffffff" 
                                                         class="rounded-circle me-2" 
                                                         width="32" 
                                                         height="32" 
                                                         alt="{{ $user->name }}">
                                                    {{ $user->name }}
                                                </div>
                                            </td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->created_at->format('M d, Y') }}</td>
                                            <td>
                                                <a href="{{ route('admin.users.edit', $user) }}" 
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted mb-0">No users have been assigned this role.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 