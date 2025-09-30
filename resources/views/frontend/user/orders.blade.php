@extends('layouts.frontend')

@section('content')
    <div class="user-orders-page">
        <!-- Orders Header -->
        <div class="orders-header">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h1 class="orders-title">My Orders</h1>
                        <p class="orders-subtitle">Track and manage all your orders in one place.</p>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <a href="{{ route('user.dashboard') }}" class="btn btn-outline-light me-2">
                            <i class="fas fa-arrow-left me-2"></i>
                            Back to Dashboard
                        </a>
                        <a href="{{ route('frontend.index') }}#order-form" class="btn btn-light">
                            <i class="fas fa-plus me-2"></i>
                            New Order
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Orders Content -->
        <div class="orders-content">
            <div class="container">
                @if ($orders->count() > 0)
                    <!-- Orders List -->
                    <div class="orders-list">
                        @foreach ($orders as $order)
                            <div class="order-card">
                                <div class="order-header">
                                    <div class="order-info">
                                        <h3 class="order-id">{{ $order->tracking_number }}</h3>
                                        <span class="order-date">{{ $order->created_at->format('M d, Y \a\t h:i A') }}</span>
                                    </div>
                                    <div class="order-status text-end">
                                        <span class="status-badge status-{{ $order->status }}">
                                            {{ ucwords(str_replace('_', ' ', $order->status)) }}
                                        </span>
                                        @php $due = max(0, (float)($order->total_amount ?? 0) - (float)($order->total_paid_amount ?? 0)); @endphp
                                        <div class="mt-1">
                                            <span class="badge bg-light text-dark me-1">Payment: {{ ucfirst($order->payment_status) }}</span>
                                            @if ($order->total_amount)
                                                <span class="text-muted" style="font-size: .85rem;">Paid: {{ number_format($order->total_paid_amount ?? 0, 2) }} | Due: {{ number_format($due, 2) }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="order-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="order-details">
                                                <h5 class="detail-title">Recipient Information</h5>
                                                <p class="detail-item"><strong>Name:</strong> {{ $order->recipient_name }}</p>
                                                <p class="detail-item"><strong>Mobile:</strong> {{ $order->recipient_mobile }}</p>
                                                <p class="detail-item"><strong>Address:</strong> {{ $order->recipient_address }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="order-details">
                                                <h5 class="detail-title">Order Summary</h5>
                                                <p class="detail-item"><strong>Tracking Number:</strong> {{ $order->tracking_number }}</p>
                                                <p class="detail-item"><strong>Products:</strong> {{ $order->products->count() }} item(s)</p>
                                                @if ($order->total_amount)
                                                    <p class="detail-item"><strong>Total Amount:</strong> {{ number_format($order->total_amount, 2) }} BDT</p>
                                                    <p class="detail-item"><strong>Paid:</strong> {{ number_format($order->total_paid_amount ?? 0, 2) }} BDT &nbsp;&nbsp; <strong>Due:</strong> {{ number_format($due, 2) }} BDT</p>
                                                @endif
                                                @if ($order->notes)
                                                    <p class="detail-item"><strong>Notes:</strong> {{ $order->notes }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Products List -->
                                    @if ($order->products->count() > 0)
                                        <div class="products-section">
                                            <h5 class="products-title">Products</h5>
                                            <div class="products-list">
                                                @foreach ($order->products as $index => $product)
                                                    <div class="product-item">
                                                        <div class="product-number">{{ $index + 1 }}</div>
                                                        <div class="product-details">
                                                            <a href="{{ $product->product_url }}" target="_blank" class="product-link">
                                                                {{ $product->product_url }}
                                                                <i class="fas fa-external-link-alt ms-1"></i>
                                                            </a>
                                                            <span class="product-quantity">Quantity: {{ $product->product_quantity }}</span>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <div class="order-footer">
                                    <div class="order-actions">
                                        <a href="{{ route('user.orders.show', $order->slug) }}" class="btn btn-outline">
                                            <i class="fas fa-eye me-2"></i>
                                            View Details
                                        </a>
                                        <a href="{{ route('frontend.order-request.invoice', $order->slug) }}" class="btn btn-outline-secondary">
                                            <i class="fas fa-file-invoice me-2"></i>
                                            View Invoice
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="pagination-wrapper">
                        {{ $orders->links() }}
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="fas fa-shopping-bag"></i>
                        </div>
                        <h3 class="empty-title">No Orders Yet</h3>
                        <p class="empty-description">You haven't placed any orders yet. Start shopping to see your orders here.</p>
                        <a href="{{ route('frontend.index') }}#order-form" class="btn btn-accent btn-lg">
                            <i class="fas fa-plus me-2"></i>
                            Place Your First Order
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .user-orders-page {
                background: #f8f9fa;
                min-height: 100vh;
                padding-bottom: 2rem;
            }

            .orders-header {
                background: linear-gradient(135deg, var(--accent-color) 0%, var(--accent-hover) 100%);
                color: white;
                padding: 3rem 0;
                margin-bottom: 2rem;
            }

            .orders-title {
                font-size: 2.5rem;
                font-weight: 700;
                margin-bottom: 0.5rem;
            }

            .orders-subtitle {
                font-size: 1.1rem;
                opacity: 0.9;
                margin-bottom: 0;
            }

            .orders-content {
                margin-bottom: 2rem;
            }

            .orders-list {
                space-y: 1.5rem;
            }

            .order-card {
                background: white;
                border-radius: 12px;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                overflow: hidden;
                margin-bottom: 1.5rem;
                transition: transform 0.3s ease, box-shadow 0.3s ease;
            }

            .order-card:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            }

            .order-header {
                background: #f8f9fa;
                padding: 1.5rem;
                border-bottom: 1px solid #e9ecef;
                display: flex;
                justify-content: space-between;
                align-items: center;
                flex-wrap: wrap;
                gap: 1rem;
            }

            .order-info {
                flex: 1;
            }

            .order-id {
                font-size: 1.25rem;
                font-weight: 600;
                margin-bottom: 0.25rem;
                color: var(--dark-color);
                font-family: monospace;
            }

            .order-date {
                font-size: 0.9rem;
                color: var(--text-muted);
            }

            .order-status {
                flex-shrink: 0;
            }

            .status-badge {
                padding: 6px 16px;
                border-radius: 20px;
                font-size: 0.85rem;
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

            .status-order_returned {
                background: #6c757d;
                color: white;
            }

            .status-order_cancelled {
                background: #dc3545;
                color: white;
            }

            .order-body {
                padding: 1.5rem;
            }

            .order-details {
                margin-bottom: 1.5rem;
            }

            .detail-title {
                font-size: 1rem;
                font-weight: 600;
                color: var(--accent-color);
                margin-bottom: 1rem;
            }

            .detail-item {
                margin-bottom: 0.5rem;
                color: var(--dark-color);
            }

            .detail-item strong {
                color: var(--dark-color);
            }

            .products-section {
                margin-top: 1.5rem;
                padding-top: 1.5rem;
                border-top: 1px solid #e9ecef;
            }

            .products-title {
                font-size: 1rem;
                font-weight: 600;
                color: var(--accent-color);
                margin-bottom: 1rem;
            }

            .products-list {
                space-y: 0.75rem;
            }

            .product-item {
                display: flex;
                align-items: flex-start;
                gap: 1rem;
                padding: 1rem;
                background: #f8f9fa;
                border-radius: 8px;
                border: 1px solid #e9ecef;
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

            .product-link {
                color: var(--accent-color);
                text-decoration: none;
                font-weight: 500;
                word-break: break-all;
                display: block;
                margin-bottom: 0.5rem;
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

            .order-footer {
                background: #f8f9fa;
                padding: 1rem 1.5rem;
                border-top: 1px solid #e9ecef;
            }

            .order-actions {
                display: flex;
                gap: 0.75rem;
                flex-wrap: wrap;
            }

            .empty-state {
                text-align: center;
                padding: 4rem 2rem;
                background: white;
                border-radius: 12px;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            }

            .empty-icon {
                font-size: 4rem;
                color: var(--text-muted);
                margin-bottom: 1.5rem;
            }

            .empty-title {
                font-size: 1.5rem;
                font-weight: 600;
                color: var(--dark-color);
                margin-bottom: 1rem;
            }

            .empty-description {
                color: var(--text-muted);
                margin-bottom: 2rem;
                max-width: 400px;
                margin-left: auto;
                margin-right: auto;
            }

            .pagination-wrapper {
                margin-top: 2rem;
                display: flex;
                justify-content: center;
            }

            /* Responsive Design */
            @media (max-width: 768px) {
                .orders-title {
                    font-size: 2rem;
                }

                .order-header {
                    flex-direction: column;
                    align-items: flex-start;
                }

                .order-actions {
                    flex-direction: column;
                }

                .order-actions .btn {
                    width: 100%;
                }

                .product-item {
                    flex-direction: column;
                    align-items: flex-start;
                }

                .product-number {
                    margin-bottom: 0.5rem;
                }
            }

            @media (max-width: 576px) {
                .orders-header {
                    padding: 2rem 0;
                }

                .orders-title {
                    font-size: 1.75rem;
                }

                .order-body {
                    padding: 1rem;
                }

                .order-footer {
                    padding: 1rem;
                }

                .empty-state {
                    padding: 3rem 1rem;
                }
            }
        </style>
    @endpush
@endsection
