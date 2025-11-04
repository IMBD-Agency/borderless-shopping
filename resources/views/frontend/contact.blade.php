@extends('layouts.frontend')

@section('content')
    <div class="track-order-page">
        <div class="tracking-header">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-10 text-center">
                        <h1 class="tracking-title">Contact Us</h1>
                        <p class="tracking-subtitle">Reach our team anytime. We typically reply within a few hours.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="tracking-form-section">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <div class="order-details-section p-0">
                            <div class="row g-3">
                                <!-- Email -->
                                <div class="col-md-4">
                                    <div class="order-summary-card h-100">
                                        <div class="card-header">
                                            <h3 class="card-title"><i class="fa-regular fa-envelope me-2"></i>Email Support</h3>
                                        </div>
                                        <div class="card-body">
                                            @if (!empty($contact_details?->email))
                                                <p class="text-muted mb-3">Send us an email for detailed inquiries, order support, or general questions.</p>
                                                <a href="mailto:{{ $contact_details->email }}" class="btn btn-outline w-100">{{ $contact_details->email }}</a>
                                            @else
                                                <p class="text-muted mb-0">Email support will be available soon.</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <!-- Phone -->
                                <div class="col-md-4">
                                    <div class="order-summary-card h-100">
                                        <div class="card-header">
                                            <h3 class="card-title"><i class="fa-solid fa-phone me-2"></i>Phone Support</h3>
                                        </div>
                                        <div class="card-body">
                                            @if (!empty($contact_details?->phone))
                                                <p class="text-muted mb-3">Call us directly for immediate assistance with urgent matters.</p>
                                                <a href="tel:{{ $contact_details->phone }}" class="btn btn-outline w-100">{{ $contact_details->phone }}</a>
                                            @else
                                                <p class="text-muted mb-0">Phone support will be available soon.</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <!-- WhatsApp -->
                                <div class="col-md-4">
                                    <div class="order-summary-card h-100">
                                        <div class="card-header">
                                            <h3 class="card-title"><i class="fa-brands fa-whatsapp me-2"></i>WhatsApp Chat</h3>
                                        </div>
                                        <div class="card-body">
                                            @if (!empty($contact_details?->whatsapp))
                                                <p class="text-muted mb-3">Quick chat support for instant responses to your questions.</p>
                                                <a href="https://wa.me/{{ str_replace('+', '', $contact_details->whatsapp) }}" target="_blank" class="btn btn-outline w-100">{{ $contact_details->whatsapp }}</a>
                                            @else
                                                <p class="text-muted mb-0">WhatsApp support will be available soon.</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Business Hours -->
                        <div class="tracking-form-card mt-4">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-clock me-2"></i>Business Hours</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6 class="fw-semibold mb-2">Customer Support</h6>
                                        <p class="text-muted mb-1">Monday - Friday: 9:00 AM - 6:00 PM (BDT)</p>
                                        <p class="text-muted mb-0">Saturday: 10:00 AM - 4:00 PM (BDT)</p>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="fw-semibold mb-2">Order Processing</h6>
                                        <p class="text-muted mb-1">Monday - Friday: 8:00 AM - 8:00 PM (BDT)</p>
                                        <p class="text-muted mb-0">Saturday: 9:00 AM - 5:00 PM (BDT)</p>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Emergency support available 24/7 via WhatsApp for urgent order issues.
                                    </small>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
