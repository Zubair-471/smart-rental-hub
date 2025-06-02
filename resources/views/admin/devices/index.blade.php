@extends('layouts.admin')

@section('title', 'Manage Devices - Smart Rental Hub')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manage Devices</h1>
        <a href="{{ route('admin.devices.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle me-2"></i>Add New Device
        </a>
    </div>

    <!-- Filters -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('admin.devices.index') }}" method="GET" class="row g-3">
                <div class="col-md-3">
                    <label for="search" class="form-label">Search</label>
                    <input type="text" class="form-control" id="search" name="search" 
                           value="{{ request('search') }}" placeholder="Search devices...">
                </div>
                <div class="col-md-3">
                    <label for="category" class="form-label">Category</label>
                    <select class="form-select" id="category" name="category">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">All Statuses</option>
                        <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Available</option>
                        <option value="rented" {{ request('status') == 'rented' ? 'selected' : '' }}>Rented</option>
                        <option value="maintenance" {{ request('status') == 'maintenance' ? 'selected' : '' }}>Under Maintenance</option>
                        <option value="unavailable" {{ request('status') == 'unavailable' ? 'selected' : '' }}>Unavailable</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <div class="d-grid gap-2 w-100">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search me-2"></i>Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Devices Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="bg-light">
                        <tr>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Daily Price</th>
                            <th>Status</th>
                            <th>Featured</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($devices as $device)
                            <tr>
                                <td>
                                    @if($device->image_url)
                                        <img src="{{ asset($device->image_url) }}" alt="{{ $device->name }}" 
                                             class="img-thumbnail" style="height: 50px;">
                                    @else
                                        <div class="bg-light text-center p-2 rounded">
                                            <i class="fas fa-image text-muted"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div class="fw-medium">{{ $device->name }}</div>
                                    <div class="small text-muted">ID: {{ $device->id }}</div>
                                </td>
                                <td>{{ $device->category->name ?? 'N/A' }}</td>
                                <td>${{ number_format($device->daily_price, 2) }}</td>
                                <td>
                                    @switch($device->status)
                                        @case('available')
                                            <span class="badge bg-success">Available</span>
                                            @break
                                        @case('rented')
                                            <span class="badge bg-info">Rented</span>
                                            @break
                                        @case('maintenance')
                                            <span class="badge bg-warning">Maintenance</span>
                                            @break
                                        @default
                                            <span class="badge bg-secondary">Unavailable</span>
                                    @endswitch
                                </td>
                                <td>
                                    @if($device->is_featured)
                                        <span class="badge bg-primary">Featured</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.devices.edit', $device) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.devices.destroy', $device) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                    onclick="return confirm('Are you sure you want to delete this device?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-box-open fa-2x mb-3"></i>
                                        <p class="mb-0">No devices found</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-end mt-4">
                {{ $devices->links() }}
            </div>
        </div>
    </div>
</div>
@endsection 