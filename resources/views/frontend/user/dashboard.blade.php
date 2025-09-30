@extends('layouts.frontend')

@section('content')
    <div class="user-dashboard">
        <!-- Dashboard Header with Statistics -->
        <div class="dashboard-header">
            <div class="container">
                <!-- Welcome Section -->
                <div class="row mb-4">
                    <div class="col-12">
                        <h1 class="dashboard-title">Welcome back, {{ $user->name }}!</h1>
                        <p class="dashboard-subtitle">Here's what's happening with your orders today.</p>
                    </div>
                </div>

                <!-- Statistics Cards -->
                <div class="row g-4">
                    <div class="col-lg-3 col-md-6">
                        <div class="stat-card">
                            <div class="stat-icon total-orders">
                                <i class="fas fa-shopping-bag"></i>
                            </div>
                            <div class="stat-content">
                                <h3 class="stat-number">{{ $totalOrders }}</h3>
                                <p class="stat-label">Total Orders</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="stat-card">
                            <div class="stat-icon pending-orders">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="stat-content">
                                <h3 class="stat-number">{{ $pendingOrders }}</h3>
                                <p class="stat-label">Pending Orders</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="stat-card">
                            <div class="stat-icon delivered-orders">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="stat-content">
                                <h3 class="stat-number">{{ $deliveredOrders }}</h3>
                                <p class="stat-label">Delivered Orders</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="stat-card">
                            <div class="stat-icon success-rate">
                                <i class="fas fa-percentage"></i>
                            </div>
                            <div class="stat-content">
                                <h3 class="stat-number">{{ $totalOrders > 0 ? round(($deliveredOrders / $totalOrders) * 100) : 0 }}%</h3>
                                <p class="stat-label">Success Rate</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="dashboard-content">
            <div class="container">
                <div class="row g-4">
                    <!-- Recent Orders -->
                    <div class="col-lg-8">
                        <div class="dashboard-card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-history me-2"></i>
                                    Recent Orders
                                </h3>
                                <a href="{{ route('user.orders') }}" class="btn btn-outline btn-sm">
                                    View All
                                    <i class="fas fa-arrow-right ms-1"></i>
                                </a>
                            </div>
                            <div class="card-body">
                                @if ($recentOrders->count() > 0)
                                    <div class="orders-list">
                                        @foreach ($recentOrders as $order)
                                            <div class="order-item">
                                                <div class="order-icon">
                                                    <i class="fas fa-shopping-cart"></i>
                                                </div>
                                                <div class="order-content">
                                                    <h5 class="order-title">Order {{ $order->tracking_number }}</h5>
                                                    <p class="order-description">
                                                        Order placed successfully
                                                    </p>
                                                    <span class="order-time">{{ $order->created_at->diffForHumans() }}</span>
                                                </div>
                                                <div class="order-status d-flex flex-column align-items-end gap-1">
                                                    <span class="status-badge status-{{ $order->status }}">
                                                        {{ ucwords(str_replace('_', ' ', $order->status)) }}
                                                    </span>
                                                    @php
                                                        $due = max(0, (float) ($order->total_amount ?? 0) - (float) ($order->total_paid_amount ?? 0));
                                                    @endphp
                                                    <span class="badge rounded-pill bg-light text-dark" style="font-size: .75rem;">
                                                        Payment: {{ ucfirst($order->payment_status) }}
                                                    </span>
                                                    @if ($order->total_amount)
                                                        <span class="text-muted" style="font-size: .75rem;">Paid: {{ number_format($order->total_paid_amount ?? 0, 2) }} | Due: {{ number_format($due, 2) }}</span>
                                                    @endif
                                                </div>
                                                <div class="order-actions">
                                                    <a href="{{ route('user.orders.show', $order->slug) }}" class="btn btn-sm btn-outline">
                                                        View Details
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="empty-state">
                                        <i class="fas fa-shopping-bag"></i>
                                        <h4>No orders yet</h4>
                                        <p>You haven't placed any orders yet. Start shopping to see your orders here.</p>
                                        <a href="{{ route('frontend.index') }}" class="btn btn-accent">
                                            <i class="fas fa-plus me-2"></i>
                                            Place Your First Order
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions & Profile -->
                    <div class="col-lg-4">
                        <!-- Quick Actions -->
                        <div class="dashboard-card mb-4">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-bolt me-2"></i>
                                    Quick Actions
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="quick-actions">
                                    <a href="{{ route('frontend.index') }}#order-form" class="quick-action-btn">
                                        <i class="fas fa-plus"></i>
                                        <span>New Order</span>
                                    </a>
                                    <a href="{{ route('user.orders') }}" class="quick-action-btn">
                                        <i class="fas fa-list"></i>
                                        <span>View Orders</span>
                                    </a>
                                    <a href="{{ route('user.profile') }}" class="quick-action-btn">
                                        <i class="fas fa-user"></i>
                                        <span>Edit Profile</span>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Profile Summary -->
                        <div class="dashboard-card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-user-circle me-2"></i>
                                    Profile Summary
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="profile-summary">
                                    <div class="profile-item">
                                        <span class="profile-label">Member Since:</span>
                                        <span class="profile-value">{{ $user->created_at->format('M Y') }}</span>
                                    </div>
                                    <div class="profile-item">
                                        <span class="profile-label">Total Orders:</span>
                                        <span class="profile-value">{{ $totalOrders }}</span>
                                    </div>
                                    <div class="profile-item">
                                        <span class="profile-label">Last Order:</span>
                                        <span class="profile-value">
                                            @if ($recentOrders->count() > 0)
                                                {{ $recentOrders->first()->created_at->format('M d, Y') }}
                                            @else
                                                Never
                                            @endif
                                        </span>
                                    </div>
                                    <div class="profile-actions mt-3">
                                        <a href="{{ route('user.profile') }}" class="btn btn-outline btn-sm w-100">
                                            <i class="fas fa-edit me-2"></i>
                                            Edit Profile
                                        </a>
                                    </div>
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
            .user-dashboard {
                background: #f8f9fa;
                min-height: 100vh;
                padding-bottom: 2rem;
            }

            .dashboard-header {
                background: linear-gradient(135deg, var(--accent-color) 0%, var(--accent-hover) 100%);
                color: white;
                padding: 3rem 0 2rem 0;
                margin-bottom: 2rem;
            }

            .dashboard-title {
                font-size: 2.5rem;
                font-weight: 700;
                margin-bottom: 0.5rem;
            }

            .dashboard-subtitle {
                font-size: 1.1rem;
                opacity: 0.9;
                margin-bottom: 0;
            }

            .stat-card {
                background: white;
                border-radius: 12px;
                padding: 1.5rem;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                display: flex;
                align-items: center;
                gap: 1rem;
                transition: transform 0.3s ease, box-shadow 0.3s ease;
            }

            .stat-card:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            }

            .stat-icon {
                width: 60px;
                height: 60px;
                border-radius: 12px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.5rem;
                color: white;
            }

            .stat-icon.total-orders {
                background: linear-gradient(135deg, #007bff, #0056b3);
            }

            .stat-icon.pending-orders {
                background: linear-gradient(135deg, #ffc107, #e0a800);
            }

            .stat-icon.delivered-orders {
                background: linear-gradient(135deg, #28a745, #1e7e34);
            }

            .stat-icon.success-rate {
                background: linear-gradient(135deg, #6f42c1, #5a32a3);
            }

            .stat-content {
                flex: 1;
            }

            .stat-number {
                font-size: 2rem;
                font-weight: 700;
                margin-bottom: 0.25rem;
                color: var(--dark-color);
            }

            .stat-label {
                color: var(--text-muted);
                margin: 0;
                font-size: 0.9rem;
            }

            .dashboard-content {
                margin-bottom: 2rem;
            }

            .dashboard-card {
                background: white;
                border-radius: 12px;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                overflow: hidden;
            }

            .card-header {
                background: #f8f9fa;
                padding: 1.5rem;
                border-bottom: 1px solid #e9ecef;
                display: flex;
                justify-content: space-between;
                align-items: center;
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

            .orders-list {
                space-y: 1rem;
            }

            .order-item {
                display: flex;
                align-items: flex-start;
                gap: 1rem;
                padding: 1rem;
                border: 1px solid #e9ecef;
                border-radius: 8px;
                background: white;
                margin-bottom: 1rem;
                transition: all 0.3s ease;
            }

            .order-item:hover {
                border-color: var(--accent-color);
                box-shadow: 0 2px 8px rgba(236, 29, 37, 0.1);
            }

            .order-icon {
                width: 40px;
                height: 40px;
                background: var(--accent-color);
                color: white;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1rem;
                flex-shrink: 0;
            }

            .order-content {
                flex: 1;
            }

            .order-title {
                font-size: 1rem;
                font-weight: 600;
                margin-bottom: 0.25rem;
                color: var(--dark-color);
            }

            .order-description {
                font-size: 0.9rem;
                color: var(--text-muted);
                margin-bottom: 0.25rem;
            }

            .order-time {
                font-size: 0.8rem;
                color: var(--text-muted);
            }

            .order-status {
                flex-shrink: 0;
            }

            .status-badge {
                padding: 5px 12px;
                border-radius: 20px;
                font-size: 0.8rem;
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
                color: white;
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
                background: #6c757d;
                color: white;
            }

            .empty-state {
                text-align: center;
                padding: 3rem 1rem;
            }

            .empty-state h4 {
                color: var(--dark-color);
                margin-bottom: 0.5rem;
            }

            .empty-state p {
                color: var(--text-muted);
                margin-bottom: 1.5rem;
            }

            .quick-actions {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 1rem;
            }

            .quick-action-btn {
                display: flex;
                flex-direction: column;
                align-items: center;
                padding: 1rem;
                background: #f8f9fa;
                border: 1px solid #e9ecef;
                border-radius: 8px;
                text-decoration: none;
                color: var(--dark-color);
                transition: all 0.3s ease;
            }

            .quick-action-btn:hover {
                background: var(--accent-color);
                color: white;
                border-color: var(--accent-color);
                transform: translateY(-2px);
            }

            .quick-action-btn i {
                font-size: 1.5rem;
                margin-bottom: 0.5rem;
            }

            .quick-action-btn span {
                font-size: 0.9rem;
                font-weight: 500;
            }

            .profile-summary {
                space-y: 1rem;
            }

            .profile-item {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 0.75rem 0;
                border-bottom: 1px solid #f8f9fa;
            }

            .profile-item:last-child {
                border-bottom: none;
            }

            .profile-label {
                color: var(--text-muted);
                font-size: 0.9rem;
            }

            .profile-value {
                font-weight: 600;
                color: var(--dark-color);
            }

            /* Responsive Design */
            @media (max-width: 768px) {
                .dashboard-title {
                    font-size: 2rem;
                }

                .user-avatar-section {
                    flex-direction: column;
                    text-align: center;
                    margin-top: 1rem;
                }

                .stat-card {
                    flex-direction: column;
                    text-align: center;
                }

                .order-item {
                    flex-direction: column;
                    align-items: flex-start;
                    gap: 1rem;
                }

                .order-status {
                    align-self: flex-end;
                    margin: 0;
                }

                .quick-actions {
                    grid-template-columns: 1fr;
                }
            }

            @media (max-width: 576px) {
                .dashboard-header {
                    padding: 2rem 0;
                }

                .dashboard-title {
                    font-size: 1.75rem;
                }

                .stat-card {
                    padding: 1rem;
                }

                .stat-icon {
                    width: 50px;
                    height: 50px;
                    font-size: 1.25rem;
                }

                .stat-number {
                    font-size: 1.5rem;
                }
            }
        </style>
    @endpush
@endsection
