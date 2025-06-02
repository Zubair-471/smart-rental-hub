@extends('layouts.app')

@section('title', $device->name . ' Details - Smart Rental Hub')

@section('content')
<div class="container py-5">
    @php
        // Dummy data if $device is not passed from controller
        if (!isset($device) || is_null($device->id)) {
            $device = (object)[
                'id' => 1,
                'name' => 'Dell XPS 15',
                'image' => 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?auto=format&fit=crop&q=80&w=2000&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'description' => 'The Dell XPS 15 is a high-performance laptop known for its stunning InfinityEdge display, powerful Intel Core i7 processor, and NVIDIA GeForce RTX graphics. Ideal for demanding creative applications, video editing, and serious multitasking. Features a sleek aluminum design and a comfortable keyboard.',
                'price_per_day' => 35.00,
                'availability_status' => 'available',
                'category' => (object)['name' => 'Laptops', 'slug' => 'laptops'],
                'specifications' => [
                    'Processor' => 'Intel Core i7-12700H',
                    'RAM' => '16GB DDR5',
                    'Storage' => '512GB NVMe SSD',
                    'Display' => '15.6" FHD+ (1920x1200) InfinityEdge',
                    'Graphics' => 'NVIDIA GeForce RTX 3050 Ti',
                    'OS' => 'Windows 11 Home'
                ],
                'average_rating' => 0
            ];
        }

        // Ensure specifications is an array
        $specifications = [];
        if (!empty($device->specifications)) {
            if (is_string($device->specifications)) {
                // Try to decode if it's a JSON string
                try {
                    $specifications = json_decode($device->specifications, true) ?? [];
                } catch (\Exception $e) {
                    $specifications = [];
                }
            } elseif (is_array($device->specifications)) {
                $specifications = $device->specifications;
            } elseif (is_object($device->specifications)) {
                $specifications = (array) $device->specifications;
            }
        }
    @endphp

    {{-- Breadcrumb Navigation --}}
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('devices.index') }}">Devices</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $device->name }}</li>
        </ol>
    </nav>

    {{-- Main Device Details Section --}}
    <div class="row mb-5">
        <div class="col-lg-6">
            <div class="card p-3 shadow-sm rounded-3">
                <img src="{{ $device->image ?: $device->image_url ?? 'https://placehold.co/800x600/E0E0E0/333333?text=No+Image' }}" class="img-fluid rounded-3" alt="{{ $device->name }}">
            </div>
        </div>
        <div class="col-lg-6 mt-4 mt-lg-0">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h1 class="mb-0">{{ $device->name }}</h1>
                <span class="badge fs-6 py-2 px-3
                    @if($device->availability_status === 'available') bg-success
                    @elseif($device->availability_status === 'rented') bg-warning text-dark
                    @elseif($device->availability_status === 'maintenance') bg-info
                    @else bg-secondary @endif">
                    {{ ucfirst($device->availability_status) }}
                </span>
            </div>

            {{-- Rating Stars --}}
            <div class="mb-3">
                @php
                    $rating = $device->average_rating ?? 0;
                @endphp
                @for($i = 1; $i <= 5; $i++)
                    <i class="fas fa-star{{ $rating >= $i ? ' text-warning' : ' text-muted' }}"></i>
                @endfor
                <span class="ms-2 text-muted">({{ number_format($rating, 1) }})</span>
            </div>

            {{-- Price --}}
            <p class="lead text-primary fw-bold fs-3">${{ number_format($device->daily_rate ?? $device->price_per_day, 2) }}/day</p>

            {{-- Description --}}
            <p class="text-muted">{{ $device->description }}</p>

            {{-- Specifications --}}
            @if(!empty($specifications))
                <h4 class="mt-4 mb-3">Specifications</h4>
                <ul class="list-group list-group-flush mb-4">
                    @foreach($specifications as $key => $value)
                        @if(!is_array($value))
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <strong>{{ $key }}:</strong>
                                <span>{{ $value }}</span>
                            </li>
                        @endif
                    @endforeach
                </ul>
            @endif

            {{-- Rental Action Button / Auth Prompt --}}
            <div class="mt-auto pt-3 border-top border-light">
                @auth
                    @if($device->availability_status === 'available')
                        <a href="{{ route('rentals.create', $device->id) }}" class="btn btn-primary btn-lg w-100">
                            <i class="fas fa-calendar-alt me-2"></i> Rent This Device
                        </a>
                    @else
                        <p class="text-danger text-center small mt-2">This device is currently not available for rent.</p>
                    @endif
                @else
                    <p class="text-center text-muted small mt-2">
                        <a href="{{ route('login') }}" class="text-primary fw-bold">Log in</a> or
                        <a href="{{ route('register') }}" class="text-primary fw-bold">Register</a> to request a rental.
                    </p>
                @endauth
            </div>
        </div>
    </div>

</div>
@endsection
