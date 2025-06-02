<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin - Smart Rental Hub')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/theme.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin-theme.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    
    @stack('styles')
</head>
<body class="admin-layout">
    <!-- Sidebar -->
    <aside class="admin-sidebar">
        <a href="{{ route('home') }}" class="admin-sidebar-logo">
            <i class="fas fa-laptop-house"></i>
            <span>Smart Rental Hub</span>
        </a>

        <nav class="admin-nav">
            <div class="nav-section">Dashboard</div>
            <a href="{{ route('admin.dashboard') }}" class="admin-nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt"></i>
                <span>Overview</span>
            </a>

            <div class="nav-section">Management</div>
            <a href="{{ route('admin.devices.index') }}" class="admin-nav-item {{ request()->routeIs('admin.devices.*') ? 'active' : '' }}">
                <i class="fas fa-laptop"></i>
                <span>Devices</span>
            </a>
            <a href="{{ route('admin.categories.index') }}" class="admin-nav-item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                <i class="fas fa-folder"></i>
                <span>Categories</span>
            </a>
            <a href="{{ route('admin.rentals.index') }}" class="admin-nav-item {{ request()->routeIs('admin.rentals.*') ? 'active' : '' }}">
                <i class="fas fa-calendar"></i>
                <span>Rentals</span>
            </a>
            <a href="{{ route('admin.users.index') }}" class="admin-nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <i class="fas fa-users"></i>
                <span>Users</span>
            </a>

            <div class="nav-section">System</div>
            <a href="{{ route('admin.roles.index') }}" class="admin-nav-item {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">
                <i class="fas fa-user-shield"></i>
                <span>Roles</span>
            </a>
            <a href="{{ route('admin.settings.edit') }}" class="admin-nav-item {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                <i class="fas fa-cog"></i>
                <span>Settings</span>
            </a>
        </nav>
    </aside>

    <!-- Header -->
    <header class="admin-header">
        <div class="d-flex justify-content-between align-items-center w-100">
            <div class="admin-header-brand">
                <button class="header-action-btn d-md-none" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar">
                    <i class="fas fa-bars"></i>
                </button>
                <h4>Smart Rental Hub</h4>
            </div>
            <div class="admin-header-actions">
                <button class="header-action-btn" type="button">
                    <i class="fas fa-bell"></i>
                    <span class="notification-badge">3</span>
                </button>
                <div class="profile-dropdown">
                    <button class="profile-btn" type="button" data-bs-toggle="dropdown">
                        <div class="profile-info">
                            <p class="profile-name">{{ Auth::user()->name }}</p>
                            <p class="profile-role">Administrator</p>
                        </div>
                        <i class="fas fa-chevron-down ms-2"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="{{ route('admin.profile.edit') }}">
                                <i class="fas fa-user"></i>
                                My Profile
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('admin.settings.edit') }}">
                                <i class="fas fa-cog"></i>
                                Settings
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="fas fa-sign-out-alt"></i>
                                    Sign Out
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="admin-main">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="admin-footer text-center">
        <div class="container">
            <p class="mb-0">&copy; {{ date('Y') }} Smart Rental Hub. All rights reserved.</p>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Set up CSRF token for all AJAX requests
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        // Mobile sidebar toggle
        document.addEventListener('DOMContentLoaded', function() {
            // Sidebar toggle
            const sidebarToggle = document.querySelector('[data-bs-toggle="collapse"][data-bs-target="#sidebar"]');
            const sidebar = document.querySelector('.admin-sidebar');
            
            if (sidebarToggle && sidebar) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('show');
                });
            }

            // Handle delete confirmations
            document.addEventListener('submit', function(e) {
                const form = e.target;
                if (form.classList.contains('delete-form')) {
                    e.preventDefault();
                    const userName = form.dataset.userName;
                    if (confirm(`Are you sure you want to delete user "${userName}"? This action cannot be undone.`)) {
                        form.submit();
                    }
                }
            });

            // Handle alerts auto-dismiss
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    const closeButton = alert.querySelector('.btn-close');
                    if (closeButton) {
                        closeButton.click();
                    }
                }, 5000);
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
