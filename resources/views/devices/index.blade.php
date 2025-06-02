@extends('layouts.app')

@section('title', 'Browse Devices - Smart Rental Hub')

@section('content')
<div class="bg-gradient-primary text-white py-5 mb-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="display-4 fw-bold mb-4">Browse Our Devices</h1>
                <p class="lead mb-4">Find the perfect device for your needs from our extensive collection</p>
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <form action="{{ route('devices.index') }}" method="GET" class="d-flex gap-2">
                            <input type="text" name="search" class="form-control form-control-lg" 
                                   placeholder="Search devices..." value="{{ request('search') }}">
                            <button type="submit" class="btn btn-light btn-lg px-4">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <!-- Filters Section -->
    <div class="mb-4">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div class="d-flex gap-2 flex-wrap">
                @foreach($categories as $category)
                    <a href="{{ route('devices.index', ['category' => $category->id]) }}" 
                       class="btn {{ request('category') == $category->id ? 'btn-primary' : 'btn-outline-secondary' }}">
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>
            <div class="d-flex gap-2">
                <select name="sort" class="form-select" onchange="window.location.href=this.value">
                    <option value="{{ route('devices.index', ['sort' => 'newest']) }}" 
                            {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                    <option value="{{ route('devices.index', ['sort' => 'price_low']) }}"
                            {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="{{ route('devices.index', ['sort' => 'price_high']) }}"
                            {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Devices Grid -->
    <div class="row g-4">
        @forelse($devices as $device)
            <div class="col-md-6 col-lg-4">
                <div class="card device-card h-100">
                    <img src="{{ $device->image_url ?? asset('images/devices/default.jpg') }}" 
                         class="card-img-top" alt="{{ $device->name }}">
                    <div class="status-badge bg-{{ $device->status_badge }}">
                        {{ $device->availability_status }}
                    </div>
                    <div class="card-body">
                        <h5 class="card-title mb-2">{{ $device->name }}</h5>
                        <p class="card-text text-muted">{{ Str::limit($device->description, 100) }}</p>
                        <div class="price-tag">${{ number_format($device->daily_rate, 2) }}/day</div>
                        <div class="d-flex align-items-center text-muted small mb-3">
                            <i class="fas fa-tag me-2"></i>
                            {{ $device->category->name }}
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('devices.show', $device) }}" class="btn btn-primary w-100">View Details</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <i class="fas fa-search fa-3x text-muted mb-3"></i>
                <h3>No devices found</h3>
                <p class="text-muted">Try adjusting your search or filter criteria</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-5">
        {{ $devices->links() }}
    </div>
</div>
@endsection
