@extends('layouts.admin')

@section('title', 'Admin Dashboard - Smart Rental Hub')

@push('styles')
<style>
    .stats-card {
        transition: all 0.3s ease;
    }
    .stats-card:hover {
        transform: translateY(-5px);
    }
    .welcome-section {
        background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
        border-radius: 1rem;
        position: relative;
        overflow: hidden;
    }
    .welcome-section::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        background: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23ffffff' fill-opacity='0.1' fill-rule='evenodd'/%3E%3C/svg%3E");
        opacity: 0.1;
    }
    .action-button {
        transition: all 0.3s ease;
        border: none;
    }
    .action-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    .stats-icon {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        transition: all 0.3s ease;
    }
    .stats-icon i {
        transition: all 0.3s ease;
    }
    .stats-card:hover .stats-icon {
        transform: scale(1.1);
    }
    .stats-card:hover .stats-icon i {
        transform: rotate(15deg);
    }
    .chart-container {
        position: relative;
    }
    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 9999px;
        font-weight: 500;
    }
    .activity-item {
        transition: all 0.3s ease;
    }
    .activity-item:hover {
        background-color: rgba(79, 70, 229, 0.05);
    }
    .rentals-table tr {
        transition: all 0.3s ease;
    }
    .rentals-table tr:hover {
        background-color: rgba(79, 70, 229, 0.05);
    }
    .welcome-section .btn {
        position: relative;
        z-index: 10;
        transition: all 0.3s ease;
    }
    .welcome-section .btn:hover {
        transform: translateY(-2px);
    }
    .welcome-section .btn-light {
        background: #ffffff;
        color: #4f46e5;
    }
    .welcome-section .btn-outline-light {
        border: 2px solid #ffffff;
    }
    .welcome-section .btn-outline-light:hover {
        background: rgba(255, 255, 255, 0.1);
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Welcome Header -->
    <div class="welcome-section text-white p-4 mb-4">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-5 fw-bold mb-2">Welcome Back, {{ Auth::user()->name }}! 👋</h1>
                <p class="lead mb-0 opacity-75">Here's what's happening with your rental business today.</p>
            </div>
            <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                <button onclick="window.location.href='{{ route('admin.devices.create') }}'" 
                        class="btn btn-light btn-lg me-2">
                    <i class="fas fa-plus-circle me-2"></i>Add Device
                </button>
                <button onclick="window.location.href='{{ route('admin.categories.create') }}'" 
                        class="btn btn-outline-light btn-lg">
                    <i class="fas fa-folder-plus me-2"></i>New Category
                </button>
            </div>
        </div>
    </div>

    <!-- Stats Cards Row -->
    <div class="row g-4 mb-4">
        <!-- Total Revenue Card -->
        <div class="col-xl-3 col-md-6">
            <div class="stats-card card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted fw-normal mb-2">Monthly Revenue</h6>
                            <h3 class="mb-2 fw-bold">${{ number_format($stats['revenue']['value'], 2) }}</h3>
                            <div class="d-flex align-items-center">
                                <span class="badge bg-{{ $stats['revenue']['trend'] === 'up' ? 'success' : 'danger' }} me-2">
                                    <i class="fas fa-arrow-{{ $stats['revenue']['trend'] }} me-1"></i>{{ $stats['revenue']['growth'] }}%
                                </span>
                                <small class="text-muted">vs last month</small>
                            </div>
                        </div>
                        <div class="stats-icon bg-primary bg-opacity-10">
                            <i class="fas fa-dollar-sign text-primary fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Users Card -->
        <div class="col-xl-3 col-md-6">
            <div class="stats-card card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted fw-normal mb-2">Total Users</h6>
                            <h3 class="mb-2 fw-bold">{{ number_format($stats['total_users']) }}</h3>
                        </div>
                        <div class="stats-icon bg-info bg-opacity-10">
                            <i class="fas fa-users text-info fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Devices Card -->
        <div class="col-xl-3 col-md-6">
            <div class="stats-card card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted fw-normal mb-2">Total Devices</h6>
                            <h3 class="mb-2 fw-bold">{{ number_format($stats['total_devices']) }}</h3>
                        </div>
                        <div class="stats-icon bg-warning bg-opacity-10">
                            <i class="fas fa-laptop text-warning fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Rentals Card -->
        <div class="col-xl-3 col-md-6">
            <div class="stats-card card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted fw-normal mb-2">Total Rentals</h6>
                            <h3 class="mb-2 fw-bold">{{ number_format($stats['total_rentals']) }}</h3>
                        </div>
                        <div class="stats-icon bg-success bg-opacity-10">
                            <i class="fas fa-calendar-check text-success fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row g-4 mb-4">
        <!-- Device Status Chart -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Device Status Overview</h5>
                    <div class="dropdown">
                        <button class="btn btn-link text-muted p-0" data-bs-toggle="dropdown">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-download me-2"></i>Download Report</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-print me-2"></i>Print</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="p-3 rounded-3 bg-success bg-opacity-10 text-center">
                                <h3 class="text-success mb-1">{{ number_format($devicesByStatus['Available'] ?? 0) }}</h3>
                                <p class="text-muted mb-0">Available</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 rounded-3 bg-warning bg-opacity-10 text-center">
                                <h3 class="text-warning mb-1">{{ number_format($devicesByStatus['Currently Rented'] ?? 0) }}</h3>
                                <p class="text-muted mb-0">Rented</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 rounded-3 bg-danger bg-opacity-10 text-center">
                                <h3 class="text-danger mb-1">{{ number_format($devicesByStatus['Under Maintenance'] ?? 0) }}</h3>
                                <p class="text-muted mb-0">Maintenance</p>
                            </div>
                        </div>
                    </div>
                    <div class="chart-container" style="height: 300px;">
                        <canvas id="deviceStatusChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-0">
                    <h5 class="mb-0">Recent Activity</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @forelse($recentActivities ?? [] as $activity)
                        <div class="activity-item list-group-item border-0 py-3">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <div class="stats-icon bg-primary bg-opacity-10">
                                        <i class="fas fa-{{ $activity['icon'] ?? 'bell' }} text-primary"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <p class="mb-1 fw-medium">{{ $activity['message'] }}</p>
                                    <small class="text-muted">{{ Carbon\Carbon::parse($activity['time'])->diffForHumans() }}</small>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-5">
                            <i class="fas fa-inbox text-muted fa-2x mb-3"></i>
                            <p class="text-muted mb-0">No recent activities</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Rentals Table -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Recent Rentals</h5>
            <a href="{{ route('admin.rentals.index') }}" class="btn btn-primary btn-sm">
                View All
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table rentals-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User</th>
                            <th>Device</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($stats['recent_rentals'] as $rental)
                        <tr>
                            <td>#{{ $rental->id }}</td>
                            <td>{{ $rental->user->name }}</td>
                            <td>{{ $rental->device->name }}</td>
                            <td>{{ $rental->start_date->format('M d, Y') }}</td>
                            <td>{{ $rental->end_date->format('M d, Y') }}</td>
                            <td>
                                <span class="badge bg-{{ $rental->status === 'active' ? 'success' : ($rental->status === 'pending' ? 'warning' : 'secondary') }}">
                                    {{ ucfirst($rental->status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.rentals.show', $rental) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Popular Devices Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Popular Devices</h5>
            <a href="{{ route('admin.devices.index') }}" class="btn btn-primary btn-sm">
                View All
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Device</th>
                            <th>Category</th>
                            <th>Total Rentals</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($stats['popular_devices'] as $device)
                        <tr>
                            <td>{{ $device->name }}</td>
                            <td>{{ $device->category->name }}</td>
                            <td>{{ $device->rentals_count }}</td>
                            <td>
                                <span class="badge bg-{{ $device->status === 'available' ? 'success' : ($device->status === 'rented' ? 'warning' : 'secondary') }}">
                                    {{ ucfirst($device->status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.devices.edit', $device) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Device Status Chart
    const ctx = document.getElementById('deviceStatusChart').getContext('2d');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Available', 'Rented', 'Maintenance'],
            datasets: [{
                data: [
                    {{ $devicesByStatus['Available'] ?? 0 }},
                    {{ $devicesByStatus['Currently Rented'] ?? 0 }},
                    {{ $devicesByStatus['Under Maintenance'] ?? 0 }}
                ],
                backgroundColor: [
                    'rgba(16, 185, 129, 0.2)',  // Success
                    'rgba(245, 158, 11, 0.2)',   // Warning
                    'rgba(239, 68, 68, 0.2)'    // Danger
                ],
                borderColor: [
                    'rgb(16, 185, 129)',  // Success
                    'rgb(245, 158, 11)',  // Warning
                    'rgb(239, 68, 68)'   // Danger
                ],
                borderWidth: 2,
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '75%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        padding: 20,
                        font: {
                            size: 12
                        }
                    }
                }
            },
            animation: {
                animateScale: true,
                animateRotate: true
            }
        }
    });
</script>
@endpush
@endsection
