@extends('layouts.app')

@section('title', 'My Rentals - Smart Rental Hub')

@section('content')
<div class="container py-5">
    <h1 class="mb-4 text-center">My Rental History</h1>
    <p class="lead text-center mb-5 text-muted">Keep track of your current and past device rentals.</p>

    @auth
        @php
            // Dummy data for rentals, replace with data from your controller ($rentals)
            if (!isset($rentals)) {
                $rentals = [
                    (object)[
                        'id' => 101,
                        'device_name' => 'Dell XPS 15',
                        'device_image' => 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?auto=format&fit=crop&q=80&w=2000&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                        'start_date' => '2024-05-01',
                        'end_date' => '2024-05-15',
                        'total_cost' => 525.00,
                        'status' => 'Completed',
                        'return_date' => '2024-05-15'
                    ],
                    (object)[
                        'id' => 102,
                        'device_name' => 'iPad Pro 12.9"',
                        'device_image' => 'https://images.unsplash.com/photo-1587829288286-cd07593d6e5a?auto=format&fit=crop&q=80&w=2000&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                        'start_date' => '2024-06-01',
                        'end_date' => '2024-06-10',
                        'total_cost' => 200.00,
                        'status' => 'Active',
                        'return_date' => null
                    ],
                     (object)[
                        'id' => 103,
                        'device_name' => 'Sony WH-1000XM5',
                        'device_image' => 'https://images.unsplash.com/photo-1620023602161-12c8a49c6931?auto=format&fit=crop&q=80&w=2000&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                        'start_date' => '2024-04-10',
                        'end_date' => '2024-04-12',
                        'total_cost' => 30.00,
                        'status' => 'Completed',
                        'return_date' => '2024-04-12'
                    ]
                ];
            }
            // Helper for badge color based on status
            function getStatusBadgeClass($status) {
                switch ($status) {
                    case 'Active': return 'bg-primary';
                    case 'Completed': return 'bg-success';
                    case 'Pending': return 'bg-warning text-dark';
                    case 'Cancelled': return 'bg-danger';
                    default: return 'bg-secondary';
                }
            }
        @endphp

        @forelse($rentals as $rental)
        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-2 text-center mb-3 mb-md-0">
                        <img src="{{ $rental->device_image }}" class="img-fluid rounded" style="max-height: 80px; object-fit: contain;" alt="{{ $rental->device_name }}">
                    </div>
                    <div class="col-md-5 mb-3 mb-md-0">
                        <h5 class="card-title mb-1">{{ $rental->device_name }}</h5>
                        <p class="card-text text-muted mb-0">
                            <strong>Rental ID:</strong> #{{ $rental->id }}
                        </p>
                        <p class="card-text text-muted mb-0">
                            <strong>Period:</strong> {{ \Carbon\Carbon::parse($rental->start_date)->format('M d, Y') }} - {{ \Carbon\Carbon::parse($rental->end_date)->format('M d, Y') }}
                        </p>
                    </div>
                    <div class="col-md-3 text-md-end mb-3 mb-md-0">
                        <p class="mb-1"><strong>Total:</strong> <span class="h5 text-primary">${{ number_format($rental->total_cost, 2) }}</span></p>
                        <span class="badge {{ getStatusBadgeClass($rental->status) }} py-2 px-3">{{ $rental->status }}</span>
                    </div>
                    <div class="col-md-2 text-center">
                        <a href="{{ route('rentals.show', $rental->id) }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-info-circle me-1"></i> Details
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="alert alert-info text-center" role="alert">
            You haven't rented any devices yet. <a href="{{ route('devices.index') }}" class="alert-link">Browse devices</a> to get started!
        </div>
        @endforelse

        {{-- Pagination (if applicable) --}}
        {{-- <div class="d-flex justify-content-center mt-5">
            {{ $rentals->links() }}
        </div> --}}

    @else
        <div class="alert alert-warning text-center" role="alert">
            Please <a href="{{ route('login') }}" class="alert-link">log in</a> to view your rentals.
        </div>
    @endauth
</div>
@endsection