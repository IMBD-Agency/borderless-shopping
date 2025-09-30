@extends('layouts.frontend')

@section('content')
    <div class="thank-you-page">
        <!-- Success Hero Section -->
        <div class="success-hero">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8 text-center">
                        <div class="success-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <h1 class="success-title">Order Placed Successfully!</h1>
                        <p class="success-subtitle">Thank you for choosing Borderless. Your order has been received and is being processed.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Information Section -->
        <div class="order-info-section">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="order-summary-card">
                            <div class="card-header">
                                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                                    <h3 class="card-title mb-2 mb-md-0">
                                        <i class="fas fa-receipt me-2"></i>
                                        Order Summary
                                    </h3>
                                    <div class="order-status">
                                        <span class="status-badge status-{{ $order->status }}">
                                            {{ ucwords(str_replace('_', ' ', $order->status)) }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <!-- Order Details -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="info-group">
                                            <h5 class="info-label">Order Information</h5>
                                            <div class="info-item">
                                                <span class="info-key">Tracking Number:</span>
                                                <span class="info-value tracking-number">{{ $order->tracking_number }}</span>
                                            </div>
                                            <div class="info-item">
                                                <span class="info-key">Order Date:</span>
                                                <span class="info-value">{{ $order->created_at->format('M d, Y \a\t h:i A') }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="info-group">
                                            <h5 class="info-label">Recipient Information</h5>
                                            <div class="info-item">
                                                <span class="info-key">Name:</span>
                                                <span class="info-value">{{ $order->recipient_name }}</span>
                                            </div>
                                            <div class="info-item">
                                                <span class="info-key">Mobile:</span>
                                                <span class="info-value">{{ $order->recipient_mobile }}</span>
                                            </div>
                                            <div class="info-item">
                                                <span class="info-key">Address:</span>
                                                <span class="info-value">{{ $order->recipient_address }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Products Section -->
                                @if ($order->products && $order->products->count() > 0)
                                    <div class="products-section">
                                        <h5 class="section-title">
                                            <i class="fas fa-shopping-bag me-2"></i>
                                            Products ({{ $order->products->count() }})
                                        </h5>
                                        <div class="products-list">
                                            @foreach ($order->products as $index => $product)
                                                <div class="product-item">
                                                    <div class="product-number">{{ $index + 1 }}</div>
                                                    <div class="product-details">
                                                        <div class="product-url">
                                                            <a href="{{ $product->product_url }}" target="_blank" class="product-link">
                                                                {{ $product->product_url }}
                                                                <i class="fas fa-external-link-alt ms-1"></i>
                                                            </a>
                                                        </div>
                                                        <div class="product-quantity">
                                                            <span class="quantity-label">Quantity:</span>
                                                            <span class="quantity-value">{{ $product->product_quantity }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                <!-- Order Notes -->
                                @if ($order->notes)
                                    <div class="notes-section">
                                        <h5 class="section-title">
                                            <i class="fas fa-sticky-note me-2"></i>
                                            Special Instructions
                                        </h5>
                                        <div class="notes-content">
                                            {{ $order->notes }}
                                        </div>
                                    </div>
                                @endif

                                <!-- Pricing Information -->
                                @if ($order->service_charge || $order->shipping_charge || $order->discount || $order->total_amount)
                                    <div class="pricing-section">
                                        <h5 class="section-title">
                                            <i class="fas fa-calculator me-2"></i>
                                            Pricing Breakdown
                                        </h5>
                                        <div class="pricing-table">
                                            @if ($order->service_charge)
                                                <div class="pricing-row">
                                                    <span class="pricing-label">Service Charge:</span>
                                                    <span class="pricing-value">{{ number_format($order->service_charge, 2) }} BDT</span>
                                                </div>
                                            @endif
                                            @if ($order->shipping_charge)
                                                <div class="pricing-row">
                                                    <span class="pricing-label">Shipping Charge:</span>
                                                    <span class="pricing-value">{{ number_format($order->shipping_charge, 2) }} BDT</span>
                                                </div>
                                            @endif
                                            @if ($order->discount)
                                                <div class="pricing-row discount">
                                                    <span class="pricing-label">Discount:</span>
                                                    <span class="pricing-value">-{{ number_format($order->discount, 2) }} BDT</span>
                                                </div>
                                            @endif
                                            @if ($order->total_amount)
                                                <div class="pricing-row total">
                                                    <span class="pricing-label">Total Amount:</span>
                                                    <span class="pricing-value">{{ number_format($order->total_amount, 2) }} BDT</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons Section -->
        <div class="action-buttons-section">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8 text-center">
                        <div class="action-buttons d-flex justify-content-center">
                            <a href="{{ route('frontend.index') }}" class="btn btn-accent btn-lg">
                                <i class="fas fa-home me-2"></i>
                                Back to Home
                            </a>
                        </div>

                        <div class="tracking-info mt-4">
                            <p class="tracking-text">
                                <i class="fas fa-info-circle me-2"></i>
                                You can track your order using the tracking number: <strong>{{ $order->tracking_number }}</strong>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Next Steps Section -->
        <div class="next-steps-section">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <h3 class="steps-title text-center mb-5">What happens next?</h3>
                        <div class="row g-4">
                            <div class="col-lg-3 col-md-6 col-sm-6">
                                <div class="step-card h-100">
                                    <div class="step-icon">
                                        <i class="fas fa-search"></i>
                                    </div>
                                    <h5 class="step-title">Order Review</h5>
                                    <p class="step-description">We'll review your order and product links to ensure everything is correct.</p>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6">
                                <div class="step-card h-100">
                                    <div class="step-icon">
                                        <i class="fas fa-shopping-cart"></i>
                                    </div>
                                    <h5 class="step-title">Purchase</h5>
                                    <p class="step-description">We'll purchase the items from the Australian stores on your behalf.</p>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6">
                                <div class="step-card h-100">
                                    <div class="step-icon">
                                        <i class="fas fa-shipping-fast"></i>
                                    </div>
                                    <h5 class="step-title">Shipping</h5>
                                    <p class="step-description">Items will be shipped to our warehouse and then to Bangladesh.</p>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6">
                                <div class="step-card h-100">
                                    <div class="step-icon">
                                        <i class="fas fa-truck"></i>
                                    </div>
                                    <h5 class="step-title">Delivery</h5>
                                    <p class="step-description">Your order will be delivered to your specified address in Bangladesh.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .thank-you-page {
                background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
                min-height: 100vh;
            }

            .success-hero {
                background: linear-gradient(135deg, var(--accent-color) 0%, var(--accent-hover) 100%);
                color: white;
                padding: 80px 0;
                text-align: center;
            }

            .success-icon {
                font-size: 5rem;
                margin-bottom: 2rem;
                animation: bounceIn 1s ease-out;
            }

            .success-title {
                font-size: 3rem;
                font-weight: 700;
                margin-bottom: 1rem;
                animation: fadeInUp 0.8s ease-out 0.2s both;
            }

            .success-subtitle {
                font-size: 1.2rem;
                opacity: 0.9;
                margin-bottom: 0;
                animation: fadeInUp 0.8s ease-out 0.4s both;
            }

            .order-info-section {
                padding: 60px 0;
            }

            .order-summary-card {
                background: white;
                border-radius: 16px;
                box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
                overflow: hidden;
                animation: slideInUp 0.8s ease-out 0.6s both;
            }

            .card-header {
                background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
                padding: 2rem;
                border-bottom: 1px solid #e9ecef;
            }

            .card-title {
                margin: 0;
                color: var(--dark-color);
                font-weight: 600;
                font-size: 1.5rem;
            }

            .order-status {
                display: flex;
                align-items: center;
            }

            .status-badge {
                padding: 8px 16px;
                border-radius: 20px;
                font-size: 0.9rem;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }

            .status-order_received {
                background: #17a2b8;
                color: white;
            }

            .status-order_confirmed {
                background: #ffc107;
                color: #212529;
            }

            .status-order_processed {
                background: #fd7e14;
                color: white;
            }

            .status-order_shipped {
                background: #007bff;
                color: white;
            }

            .status-order_delivered {
                background: #28a745;
                color: white;
            }

            .card-body {
                padding: 2rem;
            }

            .info-group {
                margin-bottom: 2rem;
            }

            .info-label {
                color: var(--accent-color);
                font-weight: 600;
                margin-bottom: 1rem;
                font-size: 1.1rem;
            }

            .info-item {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 0.75rem 0;
                border-bottom: 1px solid #f8f9fa;
            }

            .info-item:last-child {
                border-bottom: none;
            }

            .info-key {
                font-weight: 500;
                color: var(--text-muted);
                flex: 1;
            }

            .info-value {
                font-weight: 600;
                color: var(--dark-color);
                text-align: right;
                flex: 1;
            }

            .tracking-number {
                font-family: monospace;
                background: rgba(236, 29, 37, 0.1);
                padding: 4px 8px;
                border-radius: 4px;
                color: var(--accent-color);
            }

            .products-section,
            .notes-section,
            .pricing-section {
                margin-top: 2rem;
                padding-top: 2rem;
                border-top: 1px solid #e9ecef;
            }

            .section-title {
                color: var(--accent-color);
                font-weight: 600;
                margin-bottom: 1.5rem;
                font-size: 1.1rem;
            }

            .products-list {
                space-y: 1rem;
            }

            .product-item {
                display: flex;
                align-items: flex-start;
                padding: 1rem;
                background: #f8f9fa;
                border-radius: 8px;
                margin-bottom: 1rem;
                border: 1px solid #e9ecef;
                transition: all 0.3s ease;
            }

            .product-item:hover {
                border-color: var(--accent-color);
                box-shadow: 0 2px 8px rgba(236, 29, 37, 0.1);
            }

            .product-number {
                width: 32px;
                height: 32px;
                background: var(--accent-color);
                color: white;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-weight: 600;
                margin-right: 1rem;
                flex-shrink: 0;
            }

            .product-details {
                flex: 1;
            }

            .product-url {
                margin-bottom: 0.5rem;
            }

            .product-link {
                color: var(--accent-color);
                text-decoration: none;
                font-weight: 500;
                word-break: break-all;
                transition: color 0.3s ease;
            }

            .product-link:hover {
                color: var(--accent-hover);
                text-decoration: underline;
            }

            .product-quantity {
                font-size: 0.9rem;
                color: var(--text-muted);
            }

            .quantity-label {
                margin-right: 0.5rem;
            }

            .quantity-value {
                font-weight: 600;
                color: var(--dark-color);
            }

            .notes-content {
                background: #f8f9fa;
                padding: 1rem;
                border-radius: 8px;
                border-left: 4px solid var(--accent-color);
                font-style: italic;
                color: var(--text-muted);
            }

            .pricing-table {
                background: #f8f9fa;
                border-radius: 8px;
                padding: 1rem;
            }

            .pricing-row {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 0.75rem 0;
                border-bottom: 1px solid #e9ecef;
            }

            .pricing-row:last-child {
                border-bottom: none;
            }

            .pricing-row.total {
                font-weight: 700;
                font-size: 1.1rem;
                color: var(--accent-color);
                border-top: 2px solid var(--accent-color);
                margin-top: 0.5rem;
                padding-top: 1rem;
            }

            .pricing-row.discount {
                color: #28a745;
            }

            .pricing-label {
                color: var(--text-muted);
            }

            .pricing-value {
                font-weight: 600;
                color: var(--dark-color);
            }

            .action-buttons-section {
                padding: 40px 0;
                background: white;
            }

            .action-buttons {
                margin-bottom: 2rem;
            }

            .btn-outline {
                border: 2px solid var(--accent-color);
                color: var(--accent-color);
                background: transparent;
                border-radius: 8px;
                padding: 12px 24px;
                font-weight: 600;
                transition: all 0.3s ease;
            }

            .btn-outline:hover {
                background: var(--accent-color);
                color: white;
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(236, 29, 37, 0.3);
            }

            .tracking-info {
                background: rgba(236, 29, 37, 0.05);
                padding: 1rem;
                border-radius: 8px;
                border: 1px solid rgba(236, 29, 37, 0.1);
            }

            .tracking-text {
                margin: 0;
                color: var(--text-muted);
                font-size: 0.95rem;
            }

            .next-steps-section {
                padding: 60px 0;
                background: #f8f9fa;
            }

            .steps-title {
                color: var(--dark-color);
                font-weight: 700;
                font-size: 2rem;
            }

            .step-card {
                background: white;
                padding: 2rem;
                border-radius: 12px;
                text-align: center;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
                transition: transform 0.3s ease, box-shadow 0.3s ease;
                height: 100%;
            }

            .step-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            }

            .step-icon {
                width: 60px;
                height: 60px;
                background: linear-gradient(135deg, var(--accent-color), var(--accent-hover));
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                margin: 0 auto 1.5rem;
                font-size: 1.5rem;
                color: white;
            }

            .step-title {
                color: var(--dark-color);
                font-weight: 600;
                margin-bottom: 1rem;
                font-size: 1.1rem;
            }

            .step-description {
                color: var(--text-muted);
                font-size: 0.9rem;
                line-height: 1.5;
                margin: 0;
            }

            /* Animations */
            @keyframes bounceIn {
                0% {
                    opacity: 0;
                    transform: scale(0.3);
                }

                50% {
                    opacity: 1;
                    transform: scale(1.05);
                }

                70% {
                    transform: scale(0.9);
                }

                100% {
                    opacity: 1;
                    transform: scale(1);
                }
            }

            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(30px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            @keyframes slideInUp {
                from {
                    opacity: 0;
                    transform: translateY(50px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            /* Responsive Design */
            @media (max-width: 992px) {
                .order-info-section {
                    padding: 40px 0;
                }

                .next-steps-section {
                    padding: 40px 0;
                }

                .action-buttons-section {
                    padding: 30px 0;
                }
            }

            @media (max-width: 768px) {
                .success-title {
                    font-size: 2rem;
                }

                .success-subtitle {
                    font-size: 1rem;
                }

                .card-header {
                    flex-direction: column;
                    text-align: center;
                    padding: 1.5rem;
                }

                .card-title {
                    font-size: 1.3rem;
                    margin-bottom: 1rem;
                }

                .info-item {
                    flex-direction: column;
                    align-items: flex-start;
                    gap: 0.5rem;
                }

                .info-value {
                    text-align: left;
                }

                .action-buttons {
                    flex-direction: column !important;
                }

                .action-buttons .btn {
                    width: 100%;
                }

                .steps-title {
                    font-size: 1.5rem;
                }

                .product-item {
                    flex-direction: column;
                    align-items: flex-start;
                }

                .product-number {
                    margin-right: 0;
                    margin-bottom: 1rem;
                }

                .pricing-table {
                    padding: 0.75rem;
                }

                .pricing-row {
                    flex-direction: column;
                    align-items: flex-start;
                    gap: 0.25rem;
                }

                .pricing-value {
                    font-weight: 700;
                }
            }

            @media (max-width: 576px) {
                .success-hero {
                    padding: 60px 0;
                }

                .success-icon {
                    font-size: 3.5rem;
                }

                .success-title {
                    font-size: 1.8rem;
                }

                .success-subtitle {
                    font-size: 0.95rem;
                }

                .card-body {
                    padding: 1.5rem;
                }

                .card-header {
                    padding: 1rem;
                }

                .card-title {
                    font-size: 1.2rem;
                }

                .step-card {
                    padding: 1.5rem;
                }

                .info-group {
                    margin-bottom: 1.5rem;
                }

                .info-label {
                    font-size: 1rem;
                }

                .section-title {
                    font-size: 1rem;
                }

                .product-link {
                    font-size: 0.9rem;
                    word-break: break-all;
                }

                .tracking-text {
                    font-size: 0.9rem;
                }

                .step-icon {
                    width: 50px;
                    height: 50px;
                    font-size: 1.2rem;
                }

                .step-title {
                    font-size: 1rem;
                }

                .step-description {
                    font-size: 0.85rem;
                }
            }

            @media (max-width: 480px) {
                .success-hero {
                    padding: 40px 0;
                }

                .success-icon {
                    font-size: 3rem;
                }

                .success-title {
                    font-size: 1.6rem;
                }

                .card-body {
                    padding: 1rem;
                }

                .card-header {
                    padding: 0.75rem;
                }

                .step-card {
                    padding: 1rem;
                }

                .action-buttons .btn {
                    padding: 12px 24px;
                    font-size: 0.9rem;
                    min-height: 48px;
                    /* Better touch target */
                }

                .tracking-info {
                    padding: 0.75rem;
                }

                .product-item {
                    padding: 0.75rem;
                }

                .pricing-table {
                    padding: 0.5rem;
                }

                .product-link {
                    font-size: 0.8rem;
                    line-height: 1.4;
                }

                .status-badge {
                    font-size: 0.8rem;
                    padding: 6px 12px;
                }
            }

            /* Extra small devices (phones in portrait) */
            @media (max-width: 360px) {
                .success-title {
                    font-size: 1.4rem;
                }

                .success-subtitle {
                    font-size: 0.9rem;
                }

                .card-body {
                    padding: 0.75rem;
                }

                .step-card {
                    padding: 0.75rem;
                }

                .action-buttons .btn {
                    padding: 10px 20px;
                    font-size: 0.85rem;
                }

                .step-icon {
                    width: 45px;
                    height: 45px;
                    font-size: 1rem;
                }

                .step-title {
                    font-size: 0.95rem;
                }

                .step-description {
                    font-size: 0.8rem;
                }
            }
        </style>
    @endpush
@endsection
