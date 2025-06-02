@extends('layouts.admin')

@section('title', isset($role) ? 'Edit Role - Smart Rental Hub' : 'Create Role - Smart Rental Hub')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            {{ isset($role) ? 'Edit Role' : 'Create Role' }}
        </h1>
        <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Roles
        </a>
    </div>

    <!-- Role Form Card -->
    <div class="card">
        <div class="card-body">
            <form action="{{ isset($role) ? route('admin.roles.update', $role) : route('admin.roles.store') }}" 
                  method="POST">
                @csrf
                @if(isset($role))
                    @method('PUT')
                @endif

                <div class="mb-3">
                    <label for="name" class="form-label">Role Name</label>
                    <input type="text" 
                           class="form-control @error('name') is-invalid @enderror" 
                           id="name" 
                           name="name" 
                           value="{{ old('name', $role->name ?? '') }}" 
                           required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" 
                              id="description" 
                              name="description" 
                              rows="3">{{ old('description', $role->description ?? '') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label">Permissions</label>
                    <div class="row g-3">
                        @php
                            $permissions = [
                                'view_dashboard' => 'View Dashboard',
                                'manage_users' => 'Manage Users',
                                'manage_roles' => 'Manage Roles',
                                'manage_devices' => 'Manage Devices',
                                'manage_categories' => 'Manage Categories',
                                'manage_rentals' => 'Manage Rentals',
                                'view_reports' => 'View Reports',
                                'manage_settings' => 'Manage Settings'
                            ];
                            $rolePermissions = isset($role) ? $role->permissions ?? [] : [];
                        @endphp

                        @foreach($permissions as $key => $label)
                            <div class="col-md-6 col-lg-4">
                                <div class="form-check">
                                    <input class="form-check-input" 
                                           type="checkbox" 
                                           name="permissions[]" 
                                           value="{{ $key }}" 
                                           id="perm_{{ $key }}"
                                           @if(in_array($key, old('permissions', $rolePermissions))) checked @endif>
                                    <label class="form-check-label" for="perm_{{ $key }}">
                                        {{ $label }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @error('permissions')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <button type="reset" class="btn btn-light">Reset</button>
                    <button type="submit" class="btn btn-primary">
                        {{ isset($role) ? 'Update Role' : 'Create Role' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 