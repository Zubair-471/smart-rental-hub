@extends('layouts.app')

@section('title', 'Contact Us - Smart Rental Hub')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <h2 class="text-center mb-4">Contact Us</h2>
                    
                    <form action="{{ route('contact.send') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Your Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="subject" class="form-label">Subject</label>
                            <input type="text" class="form-control @error('subject') is-invalid @enderror" 
                                   id="subject" name="subject" value="{{ old('subject') }}" required>
                            @error('subject')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="message" class="form-label">Message</label>
                            <textarea class="form-control @error('message') is-invalid @enderror" 
                                      id="message" name="message" rows="5" required>{{ old('message') }}</textarea>
                            @error('message')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Send Message</button>
                        </div>
                    </form>

                    <div class="mt-5">
                        <h4 class="mb-3">Other Ways to Reach Us</h4>
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-envelope me-3 text-primary"></i>
                            <span>support@smartrentalhub.com</span>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-phone me-3 text-primary"></i>
                            <span>+1 (555) 123-4567</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-map-marker-alt me-3 text-primary"></i>
                            <span>123 Rental Street, Tech City, TC 12345</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 