@extends('layouts.app')

@section('title', 'About Us - Smart Rental Hub')

@section('content')
<div class="bg-gradient-primary text-white py-5 mb-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="display-4 fw-bold mb-3">About Smart Rental Hub</h1>
                <p class="lead mb-0">Revolutionizing tech rentals with quality devices and exceptional service</p>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <!-- Our Story Section -->
    <section class="mb-5">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <h2 class="section-title text-center">Our Story</h2>
                <p class="text-muted">Smart Rental Hub was founded with a simple mission: to make high-quality tech devices accessible to everyone. We understand that purchasing the latest technology can be expensive, and sometimes you only need a device for a short period. That's where we come in.</p>
                <p class="text-muted">Our platform connects people with the devices they need, when they need them, without the long-term commitment of purchasing. Whether you're a professional photographer needing a specific lens for a shoot, a gamer wanting to try the latest console, or a business requiring laptops for a temporary project, we've got you covered.</p>
            </div>
        </div>
    </section>

    <!-- Our Values Section -->
    <section class="mb-5 py-5 bg-white rounded-3 shadow-sm">
        <div class="container">
            <h2 class="section-title text-center">Our Values</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="text-center">
                        <div class="bg-gradient-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                            <i class="fas fa-star text-white fa-2x"></i>
                        </div>
                        <h4>Quality First</h4>
                        <p class="text-muted">We maintain our devices to the highest standards, ensuring you get a premium experience every time.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="text-center">
                        <div class="bg-gradient-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                            <i class="fas fa-shield-alt text-white fa-2x"></i>
                        </div>
                        <h4>Trust & Security</h4>
                        <p class="text-muted">Your security is our priority. We ensure safe transactions and protect your personal information.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="text-center">
                        <div class="bg-gradient-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                            <i class="fas fa-heart text-white fa-2x"></i>
                        </div>
                        <h4>Customer Focus</h4>
                        <p class="text-muted">We're dedicated to providing exceptional service and support to every customer.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="mb-5">
        <h2 class="section-title text-center">Meet Our Team</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100">
                    <img src="https://ui-avatars.com/api/?name=John+Doe&background=667eea&color=fff&size=400" class="card-img-top" alt="John Doe">
                    <div class="card-body text-center">
                        <h5 class="card-title mb-1">John Doe</h5>
                        <p class="text-muted mb-3">Founder & CEO</p>
                        <p class="card-text">Tech enthusiast with 15+ years of experience in the industry.</p>
                        <div class="d-flex justify-content-center gap-2">
                            <a href="#" class="btn btn-sm btn-outline-primary"><i class="fab fa-linkedin"></i></a>
                            <a href="#" class="btn btn-sm btn-outline-primary"><i class="fab fa-twitter"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100">
                    <img src="https://ui-avatars.com/api/?name=Jane+Smith&background=764ba2&color=fff&size=400" class="card-img-top" alt="Jane Smith">
                    <div class="card-body text-center">
                        <h5 class="card-title mb-1">Jane Smith</h5>
                        <p class="text-muted mb-3">Operations Director</p>
                        <p class="card-text">Expert in logistics and customer service excellence.</p>
                        <div class="d-flex justify-content-center gap-2">
                            <a href="#" class="btn btn-sm btn-outline-primary"><i class="fab fa-linkedin"></i></a>
                            <a href="#" class="btn btn-sm btn-outline-primary"><i class="fab fa-twitter"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100">
                    <img src="https://ui-avatars.com/api/?name=Mike+Johnson&background=2d3748&color=fff&size=400" class="card-img-top" alt="Mike Johnson">
                    <div class="card-body text-center">
                        <h5 class="card-title mb-1">Mike Johnson</h5>
                        <p class="text-muted mb-3">Tech Lead</p>
                        <p class="card-text">Passionate about bringing the latest tech to our customers.</p>
                        <div class="d-flex justify-content-center gap-2">
                            <a href="#" class="btn btn-sm btn-outline-primary"><i class="fab fa-linkedin"></i></a>
                            <a href="#" class="btn btn-sm btn-outline-primary"><i class="fab fa-twitter"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100">
                    <img src="https://ui-avatars.com/api/?name=Sarah+Chen&background=4c51bf&color=fff&size=400" class="card-img-top" alt="Sarah Chen">
                    <div class="card-body text-center">
                        <h5 class="card-title mb-1">Sarah Chen</h5>
                        <p class="text-muted mb-3">UX Designer</p>
                        <p class="card-text">Creating beautiful and intuitive user experiences.</p>
                        <div class="d-flex justify-content-center gap-2">
                            <a href="#" class="btn btn-sm btn-outline-primary"><i class="fab fa-linkedin"></i></a>
                            <a href="#" class="btn btn-sm btn-outline-primary"><i class="fab fa-dribbble"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100">
                    <img src="https://ui-avatars.com/api/?name=David+Kim&background=434190&color=fff&size=400" class="card-img-top" alt="David Kim">
                    <div class="card-body text-center">
                        <h5 class="card-title mb-1">David Kim</h5>
                        <p class="text-muted mb-3">Marketing Manager</p>
                        <p class="card-text">Digital marketing expert with a focus on growth.</p>
                        <div class="d-flex justify-content-center gap-2">
                            <a href="#" class="btn btn-sm btn-outline-primary"><i class="fab fa-linkedin"></i></a>
                            <a href="#" class="btn btn-sm btn-outline-primary"><i class="fab fa-twitter"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100">
                    <img src="https://ui-avatars.com/api/?name=Emma+Wilson&background=5a67d8&color=fff&size=400" class="card-img-top" alt="Emma Wilson">
                    <div class="card-body text-center">
                        <h5 class="card-title mb-1">Emma Wilson</h5>
                        <p class="text-muted mb-3">Customer Success</p>
                        <p class="card-text">Dedicated to ensuring the best customer experience.</p>
                        <div class="d-flex justify-content-center gap-2">
                            <a href="#" class="btn btn-sm btn-outline-primary"><i class="fab fa-linkedin"></i></a>
                            <a href="#" class="btn btn-sm btn-outline-primary"><i class="fab fa-twitter"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="mb-5 py-5 bg-white rounded-3 shadow-sm">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h2 class="section-title">Get in Touch</h2>
                <p class="text-muted mb-4">Have questions? We'd love to hear from you. Send us a message and we'll respond as soon as possible.</p>
                <div class="d-flex justify-content-center gap-4">
                    <div class="text-center">
                        <i class="fas fa-envelope fa-2x text-primary mb-2"></i>
                        <p class="mb-0">contact@smartrentalhub.com</p>
                    </div>
                    <div class="text-center">
                        <i class="fas fa-phone fa-2x text-primary mb-2"></i>
                        <p class="mb-0">(555) 123-4567</p>
                    </div>
                    <div class="text-center">
                        <i class="fas fa-map-marker-alt fa-2x text-primary mb-2"></i>
                        <p class="mb-0">123 Tech Street, Digital City</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection 