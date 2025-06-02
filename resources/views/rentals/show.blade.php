@extends('layouts.app')

@section('title', 'Rental Details - Smart Rental Hub')

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('rentals.index') }}">My Rentals</a></li>
            <li class="breadcrumb-item active" aria-current="page">Rental #{{ $rental->id }}</li>
        </ol>
    </nav>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 text-center mb-4 mb-md-0">
                    <img src="{{ $rental->device->image_url }}" class="img-fluid rounded" style="max-height: 200px; object-fit: contain;" alt="{{ $rental->device->name }}">
                </div>
                <div class="col-md-8">
                    <h2 class="mb-3">{{ $rental->device->name }}</h2>
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5 class="text-muted mb-3">Rental Information</h5>
                            <p class="mb-2"><strong>Rental ID:</strong> #{{ $rental->id }}</p>
                            <p class="mb-2"><strong>Status:</strong> 
                                <span class="badge bg-{{ $rental->status === 'Active' ? 'primary' : ($rental->status === 'Completed' ? 'success' : 'secondary') }}">
                                    {{ $rental->status }}
                                </span>
                            </p>
                            <p class="mb-2"><strong>Start Date:</strong> {{ \Carbon\Carbon::parse($rental->start_date)->format('M d, Y') }}</p>
                            <p class="mb-2"><strong>End Date:</strong> {{ \Carbon\Carbon::parse($rental->end_date)->format('M d, Y') }}</p>
                            @if($rental->return_date)
                                <p class="mb-2"><strong>Returned On:</strong> {{ \Carbon\Carbon::parse($rental->return_date)->format('M d, Y') }}</p>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <h5 class="text-muted mb-3">Payment Details</h5>
                            <p class="mb-2"><strong>Total Cost:</strong> ${{ number_format($rental->total_cost, 2) }}</p>
                            <p class="mb-2"><strong>Daily Rate:</strong> ${{ number_format($rental->device->daily_rate, 2) }}</p>
                            <p class="mb-2"><strong>Rental Duration:</strong> 
                                {{ \Carbon\Carbon::parse($rental->start_date)->diffInDays(\Carbon\Carbon::parse($rental->end_date)) }} days
                            </p>
                        </div>
                    </div>

                    <div class="border-top pt-4">
                        <h5 class="text-muted mb-3">Device Details</h5>
                        <p class="mb-2"><strong>Category:</strong> {{ $rental->device->category->name }}</p>
                        <p class="mb-2"><strong>Condition:</strong> {{ ucfirst($rental->device->condition) }}</p>
                        @if($rental->device->specifications)
                            <p class="mb-2"><strong>Specifications:</strong></p>
                            <ul class="list-unstyled ps-3">
                                @foreach($rental->device->specifications as $key => $value)
                                    <li><strong>{{ ucfirst($key) }}:</strong> {{ $value }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>

                    @if($rental->status === 'Active')
                        <div class="border-top pt-4 mt-4">
                            <h5 class="text-muted mb-3">Return Device</h5>
                            <form action="{{ route('rentals.return', $rental->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-undo-alt me-2"></i>Return Device
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection