@extends('layouts.frontend')

@section('content')
    <div class="track-order-page">
        <!-- Header (match tracking page style) -->
        <div class="tracking-header">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-10 text-center">
                        <h1 class="tracking-title">About BorderlesShopping</h1>
                        <p class="tracking-subtitle">Shop from Australia, ship to Bangladesh — simple, transparent, reliable</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Body -->
        <div class="tracking-form-section">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <!-- Who we are -->
                        <div class="tracking-form-card mb-4">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-circle-info me-2"></i>Who we are</h3>
                            </div>
                            <div class="card-body">
                                <p class="text-muted mb-3">BorderlesShopping is a specialized service that bridges the gap between Australian online retailers and customers in Bangladesh. We understand the challenges of international shopping and have built a comprehensive solution that handles every aspect of the process.</p>
                                <p class="text-muted mb-3">Our mission is to make Australian products accessible to Bangladeshi consumers with complete transparency, security, and reliability. We believe in upfront pricing, clear communication, and exceptional customer service.</p>
                                <p class="text-muted mb-0">Founded with the vision of connecting two markets, we've successfully delivered thousands of orders and built lasting relationships with customers across Bangladesh.</p>
                            </div>
                        </div>

                        <!-- How it works (timeline-like to echo tracking) -->
                        <div class="timeline-card mb-4">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-route me-2"></i>How it works</h3>
                            </div>
                            <div class="card-body">
                                <div class="timeline">
                                    <div class="timeline-item completed">
                                        <div class="timeline-marker"></div>
                                        <div class="timeline-content">
                                            <h6 class="timeline-title">Submit Product Link</h6>
                                            <p class="timeline-description">Send URLs from any Australian store (Apple, Amazon AU, Woolworths, JB Hi‑Fi, and more).</p>
                                        </div>
                                    </div>
                                    <div class="timeline-item completed">
                                        <div class="timeline-marker"></div>
                                        <div class="timeline-content">
                                            <h6 class="timeline-title">Get Transparent Quote</h6>
                                            <p class="timeline-description">We show product price, shipping cost, and our dynamic service fee — no hidden charges.</p>
                                        </div>
                                    </div>
                                    <div class="timeline-item active">
                                        <div class="timeline-marker"></div>
                                        <div class="timeline-content">
                                            <h6 class="timeline-title">We Handle Purchase & Shipping</h6>
                                            <p class="timeline-description">We purchase, package, and ship securely with full tracking to your address in Bangladesh.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Why choose us (summary cards) -->
                        <div class="order-details-section p-0">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="order-summary-card h-100">
                                        <div class="card-header">
                                            <h3 class="card-title"><i class="fa-solid fa-shield-check me-2"></i>Secure & Reliable</h3>
                                        </div>
                                        <div class="card-body">
                                            <p class="mb-0 text-muted">Handling and careful packaging from store to your doorstep.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="order-summary-card h-100">
                                        <div class="card-header">
                                            <h3 class="card-title"><i class="fa-solid fa-bolt me-2"></i>Fast Processing</h3>
                                        </div>
                                        <div class="card-body">
                                            <p class="mb-0 text-muted">Responsive updates and optimized timelines for quick delivery.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="order-summary-card h-100">
                                        <div class="card-header">
                                            <h3 class="card-title"><i class="fa-solid fa-eye me-2"></i>Transparent Pricing</h3>
                                        </div>
                                        <div class="card-body">
                                            <p class="mb-0 text-muted">All costs are itemized upfront — no surprises.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="order-summary-card h-100">
                                        <div class="card-header">
                                            <h3 class="card-title"><i class="fa-solid fa-headset me-2"></i>24/7 Support</h3>
                                        </div>
                                        <div class="card-body">
                                            <p class="mb-0 text-muted">Friendly help via email, phone, and WhatsApp around the clock.</p>
                                            <p class="text-muted small fst-italic">(Note: This sometimes might affect due to time zone difference)</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- CTA -->
                        <div class="quick-actions-card mt-4">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-paper-plane me-2"></i>Ready to get started?</h3>
                            </div>
                            <div class="card-body d-flex flex-wrap gap-2">
                                <a href="{{ route('frontend.index') }}#order-form" class="btn btn-outline"><i class="fa-solid fa-link me-2"></i>Submit Product Link</a>
                                <a href="{{ route('frontend.track-order') }}" class="btn btn-outline"><i class="fa-solid fa-truck-fast me-2"></i>Track an Order</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
