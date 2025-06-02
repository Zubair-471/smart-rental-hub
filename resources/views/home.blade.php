@extends('layouts.app')

@section('title', 'Smart Rental Hub - Home')

@push('styles')
<style>
    .device-card-link {
        text-decoration: none;
        display: block;
        height: 100%;
    }
    .device-card-link .card {
        transition: all 0.3s ease;
    }
    .device-card-link:hover .card {
        transform: translateY(-5px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }
    .device-card-link:hover .btn-primary {
        background-color: #4338ca;
        border-color: #4338ca;
    }
</style>
@endpush

@section('content')
<!-- Header Section -->
<div class="bg-gradient-primary text-white py-5 mb-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4">Rent Smart Devices Hassle-Free</h1>
                <p class="lead mb-4">Get access to the latest tech without the commitment. Perfect for short-term projects, events, or trying before buying.</p>
                <div class="d-flex gap-3">
                    <a href="{{ route('devices.index') }}" class="btn btn-light btn-lg px-4">
                        <i class="fas fa-search me-2"></i> Browse Devices
                    </a>
                    <a href="{{ route('about') }}" class="btn btn-outline-light btn-lg px-4">
                        <i class="fas fa-info-circle me-2"></i> Learn More
                    </a>
                </div>
            </div>
            <div class="col-lg-6 d-none d-lg-block">
                <img src="{{ asset('images/hero-illustration.svg') }}" alt="Tech Devices" class="img-fluid">
            </div>
        </div>
    </div>
</div>

<div class="container">
    <!-- Categories Section -->
    <section class="mb-5">
        <h2 class="section-title">Browse Categories</h2>
        <div class="row g-4">
            @foreach($categories as $category)
            <div class="col-md-4">
                <a href="{{ route('devices.index', ['category' => $category->id]) }}" class="text-decoration-none">
                    <div class="card h-100">
                        <img src="{{ $category->image_url ?? asset('images/categories/default.jpg') }}" 
                             class="card-img-top" alt="{{ $category->name }}" style="height: 200px; object-fit: cover;">
                        <div class="card-body text-center">
                            <h5 class="card-title mb-2">{{ $category->name }}</h5>
                            <p class="text-muted small mb-0">{{ $category->devices_count ?? 0 }} devices available</p>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </section>

    <!-- Featured Devices Section -->
    <section class="mb-5">
        <h2 class="section-title">Featured Devices</h2>
        <div class="row g-4">
            @foreach($featuredDevices as $device)
            <div class="col-md-6 col-lg-4">
                <a href="{{ route('devices.show', $device) }}" class="device-card-link">
                    <div class="card h-100">
                        <img src="{{ $device->image_url ?? asset('images/devices/default.jpg') }}" 
                             class="card-img-top" alt="{{ $device->name }}" style="height: 200px; object-fit: cover;">
                        <div class="status-badge bg-{{ $device->status_badge }}">
                            {{ $device->availability_status }}
                        </div>
                        <div class="card-body">
                            <h5 class="card-title mb-2 text-dark">{{ $device->name }}</h5>
                            <p class="card-text text-muted">{{ Str::limit($device->description, 100) }}</p>
                            <div class="price-tag mb-3">${{ number_format($device->daily_rate, 2) }}/day</div>
                        </div>
                        <div class="card-footer bg-transparent border-top-0">
                            <span class="btn btn-primary w-100">View Details</span>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </section>

    <!-- Latest Devices Section -->
    <section class="mb-5">
        <h2 class="section-title">Latest Additions</h2>
        <div class="row g-4">
            @foreach($latestDevices as $device)
            <div class="col-md-6 col-lg-4">
                <a href="{{ route('devices.show', $device) }}" class="device-card-link">
                    <div class="card h-100">
                        <img src="{{ $device->image_url ?? asset('images/devices/default.jpg') }}" 
                             class="card-img-top" alt="{{ $device->name }}" style="height: 200px; object-fit: cover;">
                        <div class="status-badge bg-{{ $device->status_badge }}">
                            {{ $device->availability_status }}
                        </div>
                        <div class="card-body">
                            <h5 class="card-title mb-2 text-dark">{{ $device->name }}</h5>
                            <p class="card-text text-muted">{{ Str::limit($device->description, 100) }}</p>
                            <div class="price-tag mb-3">${{ number_format($device->daily_rate, 2) }}/day</div>
                        </div>
                        <div class="card-footer bg-transparent border-top-0">
                            <span class="btn btn-primary w-100">View Details</span>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-5 bg-white rounded-3 shadow-sm">
        <div class="container">
            <h2 class="section-title text-center">Why Choose Us</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="text-center">
                        <div class="bg-gradient-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                            <i class="fas fa-check-circle text-white fa-2x"></i>
                        </div>
                        <h4>Quality Assured</h4>
                        <p class="text-muted">All our devices are thoroughly tested and maintained to ensure the best performance.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="text-center">
                        <div class="bg-gradient-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                            <i class="fas fa-truck text-white fa-2x"></i>
                        </div>
                        <h4>Fast Delivery</h4>
                        <p class="text-muted">Get your rented devices delivered to your doorstep quickly and securely.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="text-center">
                        <div class="bg-gradient-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                            <i class="fas fa-headset text-white fa-2x"></i>
                        </div>
                        <h4>24/7 Support</h4>
                        <p class="text-muted">Our dedicated support team is always ready to help you with any questions.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
