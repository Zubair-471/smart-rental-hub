@extends('layouts.admin')

@section('title', 'Settings - Smart Rental Hub')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col">
            <h2 class="mb-4">System Settings</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- General Settings Form -->
            <form action="{{ route('admin.settings.update') }}" method="POST" class="card border-0 shadow-sm mb-4">
                @csrf
                @method('PUT')
                
                <div class="card-header bg-transparent border-0">
                    <h5 class="mb-0">General Settings</h5>
                </div>
                
                <div class="card-body">
                    <!-- Site Name -->
                    <div class="mb-3">
                        <label for="site_name" class="form-label">Site Name</label>
                        <input type="text" class="form-control @error('site_name') is-invalid @enderror" 
                               id="site_name" name="site_name" value="{{ old('site_name', $settings['site_name'] ?? '') }}">
                        @error('site_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Contact Email -->
                    <div class="mb-3">
                        <label for="contact_email" class="form-label">Contact Email</label>
                        <input type="email" class="form-control @error('contact_email') is-invalid @enderror" 
                               id="contact_email" name="contact_email" value="{{ old('contact_email', $settings['contact_email'] ?? '') }}">
                        @error('contact_email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Maintenance Mode -->
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input type="checkbox" class="form-check-input" id="maintenance_mode" name="maintenance_mode" 
                                   value="1" {{ old('maintenance_mode', $settings['maintenance_mode'] ?? false) ? 'checked' : '' }}>
                            <label class="form-check-label" for="maintenance_mode">Maintenance Mode</label>
                        </div>
                        <small class="text-muted">When enabled, only administrators can access the site.</small>
                    </div>

                    <!-- Rental Terms -->
                    <div class="mb-3">
                        <label for="rental_terms" class="form-label">Rental Terms</label>
                        <textarea class="form-control @error('rental_terms') is-invalid @enderror" 
                                  id="rental_terms" name="rental_terms" rows="5">{{ old('rental_terms', $settings['rental_terms'] ?? '') }}</textarea>
                        @error('rental_terms')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Privacy Policy -->
                    <div class="mb-3">
                        <label for="privacy_policy" class="form-label">Privacy Policy</label>
                        <textarea class="form-control @error('privacy_policy') is-invalid @enderror" 
                                  id="privacy_policy" name="privacy_policy" rows="5">{{ old('privacy_policy', $settings['privacy_policy'] ?? '') }}</textarea>
                        @error('privacy_policy')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="card-footer bg-transparent border-0">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>

            <!-- Cache Management -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent border-0">
                    <h5 class="mb-0">Cache Management</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">Clear the application cache to ensure all changes take effect immediately.</p>
                    <form action="{{ route('admin.settings.clear-cache') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-sync-alt me-2"></i>Clear Cache
                        </button>
                    </form>
                </div>
            </div>

            <!-- Email Testing -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0">
                    <h5 class="mb-0">Email Testing</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">Send a test email to verify your email configuration is working correctly.</p>
                    <form action="{{ route('admin.settings.test-email') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-info">
                            <i class="fas fa-paper-plane me-2"></i>Send Test Email
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- System Information -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent border-0">
                    <h5 class="mb-0">System Information</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span>PHP Version</span>
                            <span class="badge bg-primary">{{ phpversion() }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span>Laravel Version</span>
                            <span class="badge bg-primary">{{ app()->version() }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span>Environment</span>
                            <span class="badge bg-{{ app()->environment('production') ? 'success' : 'warning' }}">
                                {{ app()->environment() }}
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span>Debug Mode</span>
                            <span class="badge bg-{{ config('app.debug') ? 'danger' : 'success' }}">
                                {{ config('app.debug') ? 'Enabled' : 'Disabled' }}
                            </span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0">
                    <h5 class="mb-0">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.profile.edit') }}" class="btn btn-outline-primary">
                            <i class="fas fa-user-cog me-2"></i>Edit Profile
                        </a>
                        <a href="{{ route('admin.roles.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-user-shield me-2"></i>Manage Roles
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 