@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Rentals</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Rentals</li>
    </ol>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Rental List
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Device</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Status</th>
                        <th>Total Cost</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rentals as $rental)
                        <tr>
                            <td>{{ $rental->id }}</td>
                            <td>{{ $rental->user->name }}</td>
                            <td>{{ $rental->device->name }}</td>
                            <td>{{ $rental->start_date->format('Y-m-d') }}</td>
                            <td>{{ $rental->end_date->format('Y-m-d') }}</td>
                            <td>
                                <span class="badge bg-{{ $rental->status_color }}">
                                    {{ $rental->status }}
                                </span>
                            </td>
                            <td>${{ number_format($rental->total_cost, 2) }}</td>
                            <td>
                                <a href="{{ route('admin.rentals.show', $rental) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4">
                {{ $rentals->links() }}
            </div>
        </div>
    </div>
</div>
@endsection 