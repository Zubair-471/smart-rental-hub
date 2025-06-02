@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Settings</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Settings</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#general" role="tab">General</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#email" role="tab">Email</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#rental" role="tab">Rental</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#payment" role="tab">Payment</a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.settings.update') }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="tab-content">
                    <!-- General Settings -->
                    <div class="tab-pane fade show active" id="general" role="tabpanel">
                        <div class="mb-3">
                            <label for="site_name" class="form-label">Site Name</label>
                            <input type="text" class="form-control" id="site_name" name="site_name" 
                                   value="{{ old('site_name', $settings['general']['site_name'] ?? '') }}">
                        </div>
                        <div class="mb-3">
                            <label for="site_description" class="form-label">Site Description</label>
                            <textarea class="form-control" id="site_description" name="site_description" rows="3">{{ old('site_description', $settings['general']['site_description'] ?? '') }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="contact_email" class="form-label">Contact Email</label>
                            <input type="email" class="form-control" id="contact_email" name="contact_email" 
                                   value="{{ old('contact_email', $settings['general']['contact_email'] ?? '') }}">
                        </div>
                        <div class="mb-3">
                            <label for="support_phone" class="form-label">Support Phone</label>
                            <input type="text" class="form-control" id="support_phone" name="support_phone" 
                                   value="{{ old('support_phone', $settings['general']['support_phone'] ?? '') }}">
                        </div>
                    </div>

                    <!-- Email Settings -->
                    <div class="tab-pane fade" id="email" role="tabpanel">
                        <div class="mb-3">
                            <label for="mail_driver" class="form-label">Mail Driver</label>
                            <select class="form-select" id="mail_driver" name="mail_driver">
                                <option value="smtp" {{ old('mail_driver', $settings['email']['driver'] ?? '') == 'smtp' ? 'selected' : '' }}>SMTP</option>
                                <option value="sendmail" {{ old('mail_driver', $settings['email']['driver'] ?? '') == 'sendmail' ? 'selected' : '' }}>Sendmail</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="mail_host" class="form-label">Mail Host</label>
                            <input type="text" class="form-control" id="mail_host" name="mail_host" 
                                   value="{{ old('mail_host', $settings['email']['host'] ?? '') }}">
                        </div>
                        <div class="mb-3">
                            <label for="mail_port" class="form-label">Mail Port</label>
                            <input type="number" class="form-control" id="mail_port" name="mail_port" 
                                   value="{{ old('mail_port', $settings['email']['port'] ?? '') }}">
                        </div>
                        <div class="mb-3">
                            <label for="mail_username" class="form-label">Mail Username</label>
                            <input type="text" class="form-control" id="mail_username" name="mail_username" 
                                   value="{{ old('mail_username', $settings['email']['username'] ?? '') }}">
                        </div>
                        <div class="mb-3">
                            <label for="mail_password" class="form-label">Mail Password</label>
                            <input type="password" class="form-control" id="mail_password" name="mail_password" 
                                   value="{{ old('mail_password', $settings['email']['password'] ?? '') }}">
                        </div>
                        <div class="mb-3">
                            <label for="mail_encryption" class="form-label">Mail Encryption</label>
                            <select class="form-select" id="mail_encryption" name="mail_encryption">
                                <option value="tls" {{ old('mail_encryption', $settings['email']['encryption'] ?? '') == 'tls' ? 'selected' : '' }}>TLS</option>
                                <option value="ssl" {{ old('mail_encryption', $settings['email']['encryption'] ?? '') == 'ssl' ? 'selected' : '' }}>SSL</option>
                            </select>
                        </div>
                    </div>

                    <!-- Rental Settings -->
                    <div class="tab-pane fade" id="rental" role="tabpanel">
                        <div class="mb-3">
                            <label for="minimum_rental_days" class="form-label">Minimum Rental Days</label>
                            <input type="number" class="form-control" id="minimum_rental_days" name="minimum_rental_days" 
                                   value="{{ old('minimum_rental_days', $settings['rental']['minimum_rental_days'] ?? 1) }}">
                        </div>
                        <div class="mb-3">
                            <label for="maximum_rental_days" class="form-label">Maximum Rental Days</label>
                            <input type="number" class="form-control" id="maximum_rental_days" name="maximum_rental_days" 
                                   value="{{ old('maximum_rental_days', $settings['rental']['maximum_rental_days'] ?? 30) }}">
                        </div>
                        <div class="mb-3">
                            <label for="deposit_percentage" class="form-label">Deposit Percentage</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="deposit_percentage" name="deposit_percentage" 
                                       value="{{ old('deposit_percentage', $settings['rental']['deposit_percentage'] ?? 20) }}">
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="rental_terms" class="form-label">Rental Terms</label>
                            <textarea class="form-control" id="rental_terms" name="rental_terms" rows="5">{{ old('rental_terms', $settings['rental']['rental_terms'] ?? '') }}</textarea>
                        </div>
                    </div>

                    <!-- Payment Settings -->
                    <div class="tab-pane fade" id="payment" role="tabpanel">
                        <div class="mb-3">
                            <label for="currency" class="form-label">Currency</label>
                            <select class="form-select" id="currency" name="currency">
                                <option value="USD" {{ old('currency', $settings['rental']['currency'] ?? '') == 'USD' ? 'selected' : '' }}>USD</option>
                                <option value="EUR" {{ old('currency', $settings['rental']['currency'] ?? '') == 'EUR' ? 'selected' : '' }}>EUR</option>
                                <option value="GBP" {{ old('currency', $settings['rental']['currency'] ?? '') == 'GBP' ? 'selected' : '' }}>GBP</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Save Settings</button>
                    <a href="{{ route('admin.settings.test-email') }}" class="btn btn-secondary">Test Email</a>
                    <a href="{{ route('admin.settings.clear-cache') }}" class="btn btn-warning">Clear Cache</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 