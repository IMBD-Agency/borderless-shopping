@extends('layouts.frontend')

@section('content')
    <div class="order-details-page">
        <!-- Order Details Header -->
        <div class="order-header">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <div class="order-info">
                            <h1 class="order-title">{{ $order->tracking_number }}</h1>
                            <span class="order-date">Placed on {{ $order->created_at->format('M d, Y \a\t h:i A') }}</span>
                        </div>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <div class="order-status">
                            <span class="status-badge status-{{ $order->status }}">
                                {{ ucwords(str_replace('_', ' ', $order->status)) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Details Content -->
        <div class="order-content">
            <div class="container">
                <div class="row g-4">
                    <!-- Order Information -->
                    <div class="col-lg-8">
                        <div class="order-card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Order Information
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="info-section">
                                            <h5 class="section-title">Recipient Details</h5>
                                            <div class="info-item">
                                                <span class="info-label">Name:</span>
                                                <span class="info-value">{{ $order->recipient_name }}</span>
                                            </div>
                                            <div class="info-item">
                                                <span class="info-label">Mobile:</span>
                                                <span class="info-value">{{ $order->recipient_mobile }}</span>
                                            </div>
                                            <div class="info-item">
                                                <span class="info-label">Address:</span>
                                                <span class="info-value">{{ $order->recipient_address }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="info-section">
                                            <h5 class="section-title">Order Details</h5>
                                            <div class="info-item">
                                                <span class="info-label">Tracking Number:</span>
                                                <span class="info-value tracking-number">{{ $order->tracking_number }}</span>
                                            </div>
                                            <div class="info-item">
                                                <span class="info-label">Order Date:</span>
                                                <span class="info-value"><small>{{ $order->created_at->format('M d, Y \a\t h:i A') }}</small></span>
                                            </div>
                                            <div class="info-item">
                                                <span class="info-label">Last Updated:</span>
                                                <span class="info-value"><small>{{ $order->updated_at->format('M d, Y \a\t h:i A') }}</small></span>
                                            </div>
                                            @php $due = max(0, (float)($order->total_amount ?? 0) - (float)($order->total_paid_amount ?? 0)); @endphp
                                            <div class="info-item">
                                                <span class="info-label">Payment Status:</span>
                                                <span class="info-value">
                                                    @if ($order->payment_status == 'paid')
                                                        <span class="badge bg-success">Paid</span>
                                                    @elseif ($order->payment_status == 'partially')
                                                        <span class="badge bg-info">Partially Paid</span>
                                                    @else
                                                        <span class="badge bg-danger">Pending</span>
                                                    @endif
                                                </span>
                                            </div>
                                            @if ($order->total_amount)
                                                <div class="info-item">
                                                    <span class="info-label">Paid Amount:</span>
                                                    <span class="info-value">{{ number_format($order->total_paid_amount ?? 0, 2) }} BDT</span>
                                                </div>
                                                <div class="info-item">
                                                    <span class="info-label">Due Amount:</span>
                                                    <span class="info-value">{{ number_format($due, 2) }} BDT</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                @if ($order->notes)
                                    <div class="notes-section">
                                        <h5 class="section-title">Special Instructions</h5>
                                        <div class="notes-content">
                                            {{ $order->notes }}
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Products Section -->
                        @if ($order->products->count() > 0)
                            <div class="order-card mt-4">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="fas fa-shopping-bag me-2"></i>
                                        Products ({{ $order->products->count() }})
                                    </h3>
                                </div>
                                <div class="card-body">
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
                            </div>
                        @endif

                        <!-- Pricing Section -->
                        @if ($order->service_charge || $order->shipping_charge || $order->discount || $order->total_amount)
                            <div class="order-card mt-4">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="fas fa-calculator me-2"></i>
                                        Pricing Breakdown
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <div class="pricing-table">
                                        @if ($order->service_charge)
                                            <div class="pricing-row">
                                                <span class="pricing-label">Service Charge:</span>
                                                <span class="pricing-value">${{ number_format($order->service_charge, 2) }}</span>
                                            </div>
                                        @endif
                                        @if ($order->shipping_charge)
                                            <div class="pricing-row">
                                                <span class="pricing-label">Shipping Charge:</span>
                                                <span class="pricing-value">${{ number_format($order->shipping_charge, 2) }}</span>
                                            </div>
                                        @endif
                                        @if ($order->discount)
                                            <div class="pricing-row discount">
                                                <span class="pricing-label">Discount:</span>
                                                <span class="pricing-value">-${{ number_format($order->discount, 2) }}</span>
                                            </div>
                                        @endif
                                        @if ($order->total_amount)
                                            <div class="pricing-row total">
                                                <span class="pricing-label">Total Amount:</span>
                                                <span class="pricing-value">${{ number_format($order->total_amount, 2) }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Order Actions & Timeline -->
                    <div class="col-lg-4">
                        <!-- Order Actions -->
                        <div class="order-card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-bolt me-2"></i>
                                    Actions
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="action-buttons">
                                    <a href="{{ route('frontend.order-request.invoice', $order->slug) }}" class="btn btn-outline-secondary w-100 mb-2">
                                        <i class="fas fa-file-invoice me-2"></i>
                                        View Invoice
                                    </a>
                                    <a href="{{ route('user.orders') }}" class="btn btn-outline-secondary w-100 mb-2">
                                        <i class="fas fa-list me-2"></i>
                                        Back to Orders
                                    </a>
                                    <a href="{{ route('user.dashboard') }}" class="btn btn-outline w-100">
                                        <i class="fas fa-home me-2"></i>
                                        Dashboard
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Order Timeline -->
                        <div class="order-card mt-4">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-history me-2"></i>
                                    Order Timeline
                                </h3>
                            </div>
                            <div class="card-body">
                                @if ($order->timelines->count() > 0)
                                    <div class="timeline">
                                        @foreach ($order->timelines as $timeline)
                                            <div class="timeline-item {{ $timeline->status == $order->status ? 'active' : 'completed' }}">
                                                <div class="timeline-marker"></div>
                                                <div class="timeline-content">
                                                    <h6 class="timeline-title">{{ $timeline->status_display }}</h6>
                                                    <p class="timeline-description">{{ $timeline->description ?? 'Status updated' }}</p>
                                                    <div class="timeline-meta">
                                                        <span class="timeline-date">{{ $timeline->created_at->format('M d, Y h:i A') }}</span>
                                                        @if ($timeline->action_by_display)
                                                            <span class="timeline-action">by {{ $timeline->action_by_display }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="timeline">
                                        <div class="timeline-item {{ $order->status == 'order_received' ? 'active' : 'completed' }}">
                                            <div class="timeline-marker"></div>
                                            <div class="timeline-content">
                                                <h6 class="timeline-title">Order Received</h6>
                                                <p class="timeline-description">Your order has been received and is being processed.</p>
                                                <span class="timeline-date">{{ $order->created_at->format('M d, Y h:i A') }}</span>
                                            </div>
                                        </div>

                                        @if ($order->status != 'order_received')
                                            <div class="timeline-item {{ $order->status == 'order_confirmed' ? 'active' : (in_array($order->status, ['order_processed', 'order_shipped', 'order_delivered']) ? 'completed' : '') }}">
                                                <div class="timeline-marker"></div>
                                                <div class="timeline-content">
                                                    <h6 class="timeline-title">Order Confirmed</h6>
                                                    <p class="timeline-description">Your order has been confirmed and is ready for processing.</p>
                                                    <span class="timeline-date">Pending</span>
                                                </div>
                                            </div>
                                        @endif

                                        @if (in_array($order->status, ['order_processed', 'order_shipped', 'order_delivered']))
                                            <div class="timeline-item {{ $order->status == 'order_processed' ? 'active' : (in_array($order->status, ['order_shipped', 'order_delivered']) ? 'completed' : '') }}">
                                                <div class="timeline-marker"></div>
                                                <div class="timeline-content">
                                                    <h6 class="timeline-title">Order Processed</h6>
                                                    <p class="timeline-description">Your order is being prepared for shipping.</p>
                                                    <span class="timeline-date">Pending</span>
                                                </div>
                                            </div>
                                        @endif

                                        @if (in_array($order->status, ['order_shipped', 'order_delivered']))
                                            <div class="timeline-item {{ $order->status == 'order_shipped' ? 'active' : ($order->status == 'order_delivered' ? 'completed' : '') }}">
                                                <div class="timeline-marker"></div>
                                                <div class="timeline-content">
                                                    <h6 class="timeline-title">Order Shipped</h6>
                                                    <p class="timeline-description">Your order has been shipped and is on its way.</p>
                                                    <span class="timeline-date">Pending</span>
                                                </div>
                                            </div>
                                        @endif

                                        @if ($order->status == 'order_delivered')
                                            <div class="timeline-item active">
                                                <div class="timeline-marker"></div>
                                                <div class="timeline-content">
                                                    <h6 class="timeline-title">Order Delivered</h6>
                                                    <p class="timeline-description">Your order has been successfully delivered.</p>
                                                    <span class="timeline-date">Pending</span>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .order-details-page {
                background: #f8f9fa;
                min-height: 100vh;
                padding-bottom: 2rem;
            }

            .order-header {
                background: linear-gradient(135deg, var(--accent-color) 0%, var(--accent-hover) 100%);
                color: white;
                padding: 3rem 0;
                margin-bottom: 2rem;
            }

            .order-title {
                font-size: 2.5rem;
                font-weight: 700;
                margin-bottom: 0.5rem;
                font-family: monospace;
            }

            .order-date {
                font-size: 1rem;
                opacity: 0.8;
            }

            .order-status {
                text-align: right;
            }

            .status-badge {
                padding: 8px 20px;
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

            .order-content {
                margin-bottom: 2rem;
            }

            .order-card {
                background: white;
                border-radius: 12px;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                overflow: hidden;
            }

            .card-header {
                background: #f8f9fa;
                padding: 1.5rem;
                border-bottom: 1px solid #e9ecef;
            }

            .card-title {
                margin: 0;
                font-size: 1.25rem;
                font-weight: 600;
                color: var(--dark-color);
            }

            .card-body {
                padding: 1.5rem;
            }

            .info-section {
                margin-bottom: 2rem;
            }

            .section-title {
                color: var(--accent-color);
                font-weight: 600;
                margin-bottom: 1rem;
                font-size: 1rem;
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

            .info-label {
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

            .notes-section {
                margin-top: 2rem;
                padding-top: 2rem;
                border-top: 1px solid #e9ecef;
            }

            .notes-content {
                background: #f8f9fa;
                padding: 1rem;
                border-radius: 8px;
                border-left: 4px solid var(--accent-color);
                font-style: italic;
                color: var(--text-muted);
            }

            .products-list {
                space-y: 1rem;
            }

            .product-item {
                display: flex;
                align-items: flex-start;
                gap: 1rem;
                padding: 1rem;
                background: #f8f9fa;
                border-radius: 8px;
                border: 1px solid #e9ecef;
                margin-bottom: 1rem;
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

            .action-buttons {
                space-y: 0.75rem;
            }

            .timeline {
                position: relative;
                padding-left: 2rem;
            }

            .timeline::before {
                content: '';
                position: absolute;
                left: 15px;
                top: 0;
                bottom: 0;
                width: 2px;
                background: #e9ecef;
            }

            .timeline-item {
                position: relative;
                margin-bottom: 2rem;
            }

            .timeline-item:last-child {
                margin-bottom: 0;
            }

            .timeline-marker {
                position: absolute;
                left: -23px;
                top: 0;
                width: 16px;
                height: 16px;
                border-radius: 50%;
                background: #e9ecef;
                border: 3px solid white;
                box-shadow: 0 0 0 2px #e9ecef;
            }

            .timeline-item.active .timeline-marker {
                background: var(--accent-color);
                box-shadow: 0 0 0 2px var(--accent-color);
            }

            .timeline-item.completed .timeline-marker {
                background: #28a745;
                box-shadow: 0 0 0 2px #28a745;
            }

            .timeline-content {
                padding-left: 1rem;
            }

            .timeline-title {
                font-size: 0.9rem;
                font-weight: 600;
                color: var(--dark-color);
                margin-bottom: 0.25rem;
            }

            .timeline-description {
                font-size: 0.8rem;
                color: var(--text-muted);
                margin-bottom: 0.25rem;
            }

            .timeline-date {
                font-size: 0.75rem;
                color: var(--text-muted);
            }

            .timeline-meta {
                display: flex;
                flex-direction: column;
                gap: 0.25rem;
            }

            .timeline-action {
                font-size: 0.7rem;
                color: var(--text-muted);
                font-style: italic;
            }

            /* Responsive Design */
            @media (max-width: 768px) {
                .order-title {
                    font-size: 2rem;
                }

                .order-header .col-md-4 {
                    text-align: left;
                    margin-top: 1rem;
                }

                .info-item {
                    flex-direction: column;
                    align-items: flex-start;
                    gap: 0.5rem;
                }

                .info-value {
                    text-align: left;
                }

                .product-item {
                    flex-direction: column;
                    align-items: flex-start;
                }

                .product-number {
                    margin-bottom: 0.5rem;
                }

                .timeline {
                    padding-left: 1.5rem;
                }

                .timeline-marker {
                    left: -18px;
                    width: 12px;
                    height: 12px;
                }
            }

            @media (max-width: 576px) {
                .order-header {
                    padding: 2rem 0;
                }

                .order-title {
                    font-size: 1.75rem;
                }

                .card-body {
                    padding: 1rem;
                }

                .action-buttons .btn {
                    font-size: 0.9rem;
                }
            }
        </style>
    @endpush
@endsection
