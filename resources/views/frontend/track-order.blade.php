@extends('layouts.frontend')

@section('content')
    <div class="track-order-page">
        <!-- Tracking Header -->
        <div class="tracking-header">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 text-center">
                        <h1 class="tracking-title">Track Your Order</h1>
                        <p class="tracking-subtitle">Enter your tracking number to see the current status and timeline of your order</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tracking Form Section -->
        <div class="tracking-form-section">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <div class="tracking-form-card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-search me-2"></i>
                                    Enter Tracking Number
                                </h3>
                            </div>
                            <div class="card-body">
                                @if (session('error'))
                                    <div class="alert alert-danger">
                                        <i class="fas fa-exclamation-circle me-2"></i>
                                        {{ session('error') }}
                                    </div>
                                @endif

                                <form id="trackOrderForm">
                                    @csrf
                                    <div class="form-group">
                                        <label for="tracking_number" class="form-label">Tracking Number</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="tracking_number" name="tracking_number" placeholder="Enter tracking number (e.g., AU-XXXXXXXX)" value="{{ request('tracking_number') }}" required>
                                            <button class="btn btn-accent" type="submit" id="trackButton">
                                                <i class="fas fa-search me-2"></i>
                                                <span class="button-text">Track Order</span>
                                            </button>
                                        </div>
                                        <div id="error-message" class="invalid-feedback" style="display: none;"></div>
                                        <small class="form-text text-muted">Enter the tracking number provided in your order confirmation</small>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Results Container -->
        <div id="order-results" class="order-details-section" style="display: none;">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <!-- Order Header -->
                        <div class="order-header-card">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <h2 class="order-title" id="order-title">Order #<span id="order-tracking-number"></span></h2>
                                    <p class="order-subtitle" id="order-date">Placed on <span id="order-created-date"></span></p>
                                </div>
                                <div class="col-md-4 text-md-end">
                                    <span class="status-badge" id="order-status-badge"></span>
                                </div>
                            </div>
                        </div>

                        <!-- Order Information -->
                        <div class="row mt-4">
                            <!-- Order Timeline -->
                            <div class="col-md-8">
                                <div class="timeline-card">
                                    <div class="card-header">
                                        <h3 class="card-title">
                                            <i class="fas fa-history me-2"></i>
                                            Order Timeline
                                        </h3>
                                    </div>
                                    <div class="card-body">
                                        <div id="timeline-container">
                                            <!-- Timeline will be populated by AJAX -->
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Order Summary -->
                            <div class="col-md-4">
                                <div class="order-summary-card">
                                    <div class="card-header">
                                        <h3 class="card-title">
                                            <i class="fas fa-info-circle me-2"></i>
                                            Order Summary
                                        </h3>
                                    </div>
                                    <div class="card-body" id="order-summary">
                                        <!-- Order summary will be populated by AJAX -->
                                    </div>
                                </div>

                                <!-- Quick Actions -->
                                <div class="quick-actions-card mt-4">
                                    <div class="card-header">
                                        <h3 class="card-title">
                                            <i class="fas fa-bolt me-2"></i>
                                            Quick Actions
                                        </h3>
                                    </div>
                                    <div class="card-body" id="quick-actions">
                                        <!-- Quick actions will be populated by AJAX -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if (isset($order))
            <!-- Order Details Section -->
            <div class="order-details-section">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-10">
                            <!-- Order Header -->
                            <div class="order-header-card">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <h2 class="order-title">Order #{{ $order->tracking_number }}</h2>
                                        <p class="order-subtitle">Placed on {{ $order->created_at->format('M d, Y') }}</p>
                                    </div>
                                    <div class="col-md-4 text-md-end">
                                        <span class="status-badge status-{{ $order->status }}">
                                            {{ ucwords(str_replace('_', ' ', $order->status)) }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Order Information -->
                            <div class="row mt-4">
                                <!-- Order Timeline -->
                                <div class="col-md-8">
                                    <div class="timeline-card">
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

                                <!-- Order Summary -->
                                <div class="col-md-4">
                                    <div class="order-summary-card">
                                        <div class="card-header">
                                            <h3 class="card-title">
                                                <i class="fas fa-info-circle me-2"></i>
                                                Order Summary
                                            </h3>
                                        </div>
                                        <div class="card-body">
                                            <div class="summary-item">
                                                <span class="summary-label">Tracking Number</span>
                                                <span class="summary-value tracking-number">{{ $order->tracking_number }}</span>
                                            </div>
                                            <div class="summary-item">
                                                <span class="summary-label">Order Date</span>
                                                <span class="summary-value">{{ $order->created_at->format('M d, Y') }}</span>
                                            </div>
                                            <div class="summary-item">
                                                <span class="summary-label">Status</span>
                                                <span class="summary-value">
                                                    <span class="status-badge status-{{ $order->status }}">
                                                        {{ ucwords(str_replace('_', ' ', $order->status)) }}
                                                    </span>
                                                </span>
                                            </div>
                                            <div class="summary-item">
                                                <span class="summary-label">Recipient</span>
                                                <span class="summary-value">{{ $order->recipient_name }}</span>
                                            </div>
                                            <div class="summary-item">
                                                <span class="summary-label">Mobile</span>
                                                <span class="summary-value">{{ $order->recipient_mobile }}</span>
                                            </div>
                                            <div class="summary-item">
                                                <span class="summary-label">Products</span>
                                                <span class="summary-value">{{ $order->products->count() }} item(s)</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Quick Actions -->
                                    <div class="quick-actions-card mt-4">
                                        <div class="card-header">
                                            <h3 class="card-title">
                                                <i class="fas fa-bolt me-2"></i>
                                                Quick Actions
                                            </h3>
                                        </div>
                                        <div class="card-body">
                                            <a href="{{ route('frontend.order-request.invoice', $order->slug) }}" class="btn btn-outline w-100 mb-2">
                                                <i class="fas fa-file-invoice me-2"></i>
                                                View Invoice
                                            </a>
                                            <a href="{{ route('frontend.order-request.invoice.download', $order->slug) }}" class="btn btn-outline w-100">
                                                <i class="fas fa-download me-2"></i>
                                                Download Invoice
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#trackOrderForm').on('submit', function(e) {
                    e.preventDefault();

                    const trackingNumber = $('#tracking_number').val().trim();
                    const trackButton = $('#trackButton');
                    const buttonText = trackButton.find('.button-text');
                    const errorMessage = $('#error-message');

                    // Clear previous errors
                    errorMessage.hide();
                    $('#tracking_number').removeClass('is-invalid');

                    if (!trackingNumber) {
                        showError('Please enter a tracking number');
                        return;
                    }

                    // Show loading state
                    trackButton.prop('disabled', true);
                    buttonText.text('Tracking...');
                    trackButton.find('i').removeClass('fa-search').addClass('fa-spinner fa-spin');

                    // Make AJAX request
                    $.ajax({
                        url: '{{ route('frontend.track-order.submit') }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            tracking_number: trackingNumber
                        },
                        success: function(response) {
                            if (response.success) {
                                displayOrderResults(response.order, response.timeline, response.products);
                                $('#order-results').show();
                                $('html, body').animate({
                                    scrollTop: $('#order-results').offset().top - 100
                                }, 500);
                            } else {
                                showError(response.message);
                            }
                        },
                        error: function(xhr) {
                            if (xhr.status === 404) {
                                showError('No order found with this tracking number. Please check and try again.');
                            } else {
                                showError('An error occurred while tracking your order. Please try again.');
                            }
                        },
                        complete: function() {
                            // Reset button state
                            trackButton.prop('disabled', false);
                            buttonText.text('Track Order');
                            trackButton.find('i').removeClass('fa-spinner fa-spin').addClass('fa-search');
                        }
                    });
                });

                // Auto-submit if tracking number provided in query string
                var presetTracking = "{{ request('tracking_number') }}";
                if (presetTracking && presetTracking.trim().length > 0) {
                    $('#tracking_number').val(presetTracking.trim());
                    $('#trackOrderForm').trigger('submit');
                }

                function showError(message) {
                    $('#error-message').text(message).show();
                    $('#tracking_number').addClass('is-invalid');
                }

                function displayOrderResults(order, timeline, products) {
                    // Update order header
                    $('#order-tracking-number').text(order.tracking_number);
                    $('#order-created-date').text(new Date(order.created_at).toLocaleDateString('en-US', {
                        year: 'numeric',
                        month: 'short',
                        day: 'numeric'
                    }));

                    // Update status badge
                    const statusBadge = $('#order-status-badge');
                    statusBadge.removeClass().addClass('status-badge status-' + order.status);
                    statusBadge.text(order.status.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase()));

                    // Update timeline
                    displayTimeline(timeline, order.status);

                    // Update order summary (uses payment status)
                    displayOrderSummary(order, products);

                    // Update quick actions
                    displayQuickActions(order);
                }

                function displayTimeline(timeline, currentStatus) {
                    let timelineHtml = '';

                    if (timeline && timeline.length > 0) {
                        timeline.forEach(function(item) {
                            const isActive = item.status === currentStatus;
                            const isCompleted = item.status !== currentStatus;

                            timelineHtml += `
                                <div class="timeline-item ${isActive ? 'active' : (isCompleted ? 'completed' : '')}">
                                    <div class="timeline-marker"></div>
                                    <div class="timeline-content">
                                        <h6 class="timeline-title">${item.status.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase())}</h6>
                                        <p class="timeline-description">${item.description || 'Status updated'}</p>
                                        <div class="timeline-meta">
                                            <span class="timeline-date">${new Date(item.created_at).toLocaleDateString('en-US', {
                                                year: 'numeric',
                                                month: 'short',
                                                day: 'numeric',
                                                hour: '2-digit',
                                                minute: '2-digit'
                                            })}</span>
                                            ${item.action_by_display ? `<span class="timeline-action">by ${item.action_by_display}</span>` : ''}
                                        </div>
                                    </div>
                                </div>
                            `;
                        });
                    } else {
                        // Fallback static timeline
                        timelineHtml = generateStaticTimeline(currentStatus);
                    }

                    $('#timeline-container').html(`<div class="timeline">${timelineHtml}</div>`);
                }

                function generateStaticTimeline(currentStatus) {
                    const statuses = [{
                            key: 'order_received',
                            title: 'Order Received',
                            description: 'Your order has been received and is being processed.'
                        },
                        {
                            key: 'order_confirmed',
                            title: 'Order Confirmed',
                            description: 'Your order has been confirmed and is ready for processing.'
                        },
                        {
                            key: 'order_processed',
                            title: 'Order Processed',
                            description: 'Your order is being prepared for shipping.'
                        },
                        {
                            key: 'order_shipped',
                            title: 'Order Shipped',
                            description: 'Your order has been shipped and is on its way.'
                        },
                        {
                            key: 'order_delivered',
                            title: 'Order Delivered',
                            description: 'Your order has been successfully delivered.'
                        }
                    ];

                    let timelineHtml = '';
                    let foundCurrent = false;

                    statuses.forEach(function(status) {
                        if (status.key === currentStatus || foundCurrent) {
                            const isActive = status.key === currentStatus;
                            timelineHtml += `
                                <div class="timeline-item ${isActive ? 'active' : 'completed'}">
                                    <div class="timeline-marker"></div>
                                    <div class="timeline-content">
                                        <h6 class="timeline-title">${status.title}</h6>
                                        <p class="timeline-description">${status.description}</p>
                                        <span class="timeline-date">${isActive ? 'Current' : 'Pending'}</span>
                                    </div>
                                </div>
                            `;
                            if (status.key === currentStatus) foundCurrent = true;
                        }
                    });

                    return timelineHtml;
                }

                function displayOrderSummary(order, products) {
                    const paymentStatus = (order.payment_status || 'pending');
                    const paymentBadgeClass = paymentStatus === 'paid' ? 'payment-paid' : (paymentStatus === 'partially' ? 'payment-partially' : 'payment-pending');
                    const summaryHtml = `
                        <div class="summary-item">
                            <span class="summary-label">Tracking Number</span>
                            <span class="summary-value tracking-number">${order.tracking_number}</span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-label">Order Date</span>
                            <span class="summary-value">${new Date(order.created_at).toLocaleDateString('en-US', {
                                year: 'numeric',
                                month: 'short',
                                day: 'numeric'
                            })}</span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-label">Payment Status</span>
                            <span class="summary-value">
                                <span class="status-badge ${paymentBadgeClass}">
                                    ${paymentStatus.charAt(0).toUpperCase() + paymentStatus.slice(1)}
                                </span>
                            </span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-label">Recipient</span>
                            <span class="summary-value">${order.recipient_name}</span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-label">Mobile</span>
                            <span class="summary-value">${order.recipient_mobile}</span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-label">Products</span>
                            <span class="summary-value">${products ? products.length : 0} item(s)</span>
                        </div>
                    `;

                    $('#order-summary').html(summaryHtml);
                }

                function displayQuickActions(order) {
                    const actionsHtml = `
                        <a href="/orders/${order.slug}" class="btn btn-outline w-100 mb-2">
                            <i class="fas fa-file-invoice me-2"></i>
                            View Invoice
                        </a>
                        <a href="/orders/${order.slug}/invoice" class="btn btn-outline w-100">
                            <i class="fas fa-download me-2"></i>
                            Download Invoice
                        </a>
                    `;

                    $('#quick-actions').html(actionsHtml);
                }
            });
        </script>
    @endpush
@endsection

@push('styles')
    <style>
        :root {
            --accent-color: #ec1d25;
            --dark-color: #2c3e50;
            --text-muted: #6c757d;
            --light-bg: #f8f9fa;
            --border-color: #e9ecef;
        }

        .track-order-page {
            min-height: 100vh;
            background: linear-gradient(135deg, #fef7f7 0%, #fdf2f2 100%);
        }

        /* Tracking Header */
        .tracking-header {
            padding: 2.5rem 0 1.5rem;
            background: linear-gradient(135deg, var(--accent-color) 0%, #d32f2f 100%);
            color: white;
            position: relative;
            overflow: hidden;
        }

        .tracking-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.1"/><circle cx="10" cy="60" r="0.5" fill="white" opacity="0.1"/><circle cx="90" cy="40" r="0.5" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.1;
        }

        .tracking-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.75rem;
            position: relative;
            z-index: 1;
            color: white;
        }

        .tracking-subtitle {
            font-size: 1.1rem;
            opacity: 0.95;
            position: relative;
            z-index: 1;
            color: white;
        }

        /* Tracking Form Section */
        .tracking-form-section {
            padding: 3rem 0;
            position: relative;
            z-index: 2;
        }

        .tracking-form-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            border: none;
        }

        .card-header {
            background: linear-gradient(135deg, var(--accent-color) 0%, #d32f2f 100%);
            color: white;
            padding: 1rem;
            border: none;
        }

        .card-title {
            margin: 0;
            font-size: 1.3rem;
            font-weight: 600;
        }

        .card-body {
            padding: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 0.5rem;
        }

        .input-group .form-control {
            border-radius: 10px 0 0 10px;
            border: 2px solid var(--border-color);
            padding: 1rem;
            font-size: 1.1rem;
            font-weight: 600;
            letter-spacing: 1px;
        }

        .input-group .form-control:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 0.2rem rgba(236, 29, 37, 0.25);
        }

        .btn-accent {
            background: var(--accent-color);
            border: 2px solid var(--accent-color);
            color: white;
            border-radius: 0 10px 10px 0;
            padding: 1rem 2rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-accent:hover {
            background: #d32f2f;
            border-color: #d32f2f;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(236, 29, 37, 0.3);
        }

        .form-text {
            margin-top: 0.5rem;
            font-size: 0.9rem;
        }

        /* Order Details Section */
        .order-details-section {
            padding: 3rem 0;
        }

        .order-header-card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }

        .order-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 0.5rem;
        }

        .order-subtitle {
            color: var(--text-muted);
            font-size: 1rem;
            margin: 0;
        }

        .status-badge {
            display: inline-block;
            padding: 0.5rem 1rem;
            border-radius: 25px;
            font-size: 0.9rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-order_received {
            background: #ffc107;
            color: #000;
        }

        .status-order_confirmed {
            background: #28a745;
            color: white;
        }

        .status-order_processed {
            background: #17a2b8;
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
            background: #dc3545;
            color: white;
        }

        .status-order_cancelled {
            background: #dc3545;
            color: white;
        }

        /* Payment Status Badges */
        .payment-paid {
            background: #28a745;
            color: #fff;
            box-shadow: 0px 0px 5px #5b5b5b63;
        }

        .payment-partially {
            background: #0dcaf0;
            color: #fff;
            box-shadow: 0px 0px 5px #5b5b5b63;
        }

        .payment-pending {
            background: #dc3545;
            color: #fff;
            box-shadow: 0px 0px 5px #5b5b5b63;
        }

        /* Timeline Card */
        .timeline-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .timeline {
            position: relative;
            padding-left: 1rem;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 7px;
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
            left: -15px;
            top: 0;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: #e9ecef;
            border: 3px solid white;
            box-shadow: 0 0 0 2px #e9ecef;
            z-index: 2;
        }

        .timeline-item.active .timeline-marker {
            background: var(--accent-color);
            box-shadow: 0 0 0 2px var(--accent-color);
        }

        .timeline-item.completed .timeline-marker {
            background: #28a745;
            box-shadow: 0 0 0 2px #28a745;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }

            100% {
                transform: scale(1);
            }
        }

        .timeline-content {
            padding-left: 1rem;
        }

        .timeline-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 0.5rem;
            line-height: 1;
        }

        .timeline-description {
            font-size: 0.95rem;
            color: var(--text-muted);
            margin-bottom: 0.5rem;
            line-height: 1.5;
        }

        .timeline-meta {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .timeline-date {
            font-size: 0.85rem;
            color: var(--text-muted);
            font-weight: 500;
        }

        .timeline-action {
            font-size: 0.8rem;
            color: var(--text-muted);
            font-style: italic;
        }

        /* Order Summary Card */
        .order-summary-card,
        .quick-actions-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;
            border-bottom: 1px solid var(--border-color);
        }

        .summary-item:last-child {
            border-bottom: none;
        }

        .summary-label {
            font-weight: 600;
            color: var(--dark-color);
        }

        .summary-value {
            color: var(--text-muted);
            font-weight: 500;
        }

        .tracking-number {
            font-family: 'Courier New', monospace;
            font-weight: 700;
            color: var(--accent-color);
            font-size: 1.1rem;
        }

        .btn-outline {
            border: 2px solid var(--accent-color);
            color: var(--accent-color);
            background: transparent;
            border-radius: 8px;
            padding: 0.5rem 1rem;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-outline:hover {
            background: var(--accent-color);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(236, 29, 37, 0.3);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .tracking-title {
                font-size: 2rem;
            }

            .tracking-subtitle {
                font-size: 1rem;
            }

            .tracking-form-section {
                padding: 2.5rem 0;
            }

            .order-title {
                font-size: 1.75rem;
            }

            .timeline {
                padding-left: 1.5rem;
            }

            .timeline-marker {
                left: -12px;
                width: 12px;
                height: 12px;
            }

            .card-header {
                padding: 1.25rem;
            }

            .card-body {
                padding: 1.25rem;
            }

            .order-header-card {
                padding: 1.5rem;
            }

            .summary-item {
                padding: 0.875rem 0;
            }
        }

        @media (max-width: 576px) {
            .tracking-header {
                padding: 1.5rem 0 0.75rem;
            }

            .tracking-title {
                font-size: 1.75rem;
                margin-bottom: 0.5rem;
            }

            .tracking-subtitle {
                font-size: 0.9rem;
            }

            .tracking-form-section {
                margin-top: -0.5rem;
                padding: 2rem 0;
            }

            .tracking-form-card {
                margin: 0 0.5rem;
            }

            .card-header {
                padding: 1rem;
            }

            .card-body {
                padding: 1rem;
            }

            .order-title {
                font-size: 1.25rem;
            }

            .order-subtitle {
                font-size: 0.9rem;
            }

            .input-group .form-control {
                font-size: 1rem;
                padding: 0.75rem;
            }

            .btn-accent {
                padding: 0.75rem 1rem;
                font-size: 0.9rem;
            }

            .btn-accent .button-text {
                display: none;
            }

            .order-header-card {
                padding: 1rem;
                margin: 0 0.5rem 1rem 0.5rem;
            }

            .timeline-card,
            .order-summary-card,
            .quick-actions-card {
                margin: 0 0.5rem 1rem 0.5rem;
            }

            .timeline {
                padding-left: 0.75rem;
            }

            .timeline-marker {
                left: -8px;
                width: 10px;
                height: 10px;
            }

            .timeline-content {
                padding-left: 0.75rem;
            }

            .timeline-title {
                font-size: 1rem;
            }

            .timeline-description {
                font-size: 0.85rem;
            }

            .timeline-date {
                font-size: 0.75rem;
            }

            .summary-item {
                padding: 0.75rem 0;
                flex-direction: column;
                align-items: flex-start;
                gap: 0.25rem;
            }

            .summary-label {
                font-size: 0.9rem;
            }

            .summary-value {
                font-size: 0.9rem;
            }

            .btn-outline {
                padding: 0.5rem 0.75rem;
                font-size: 0.85rem;
            }
        }

        @media (max-width: 480px) {
            .tracking-header {
                padding: 1.25rem 0 0.5rem;
            }

            .tracking-title {
                font-size: 1.5rem;
            }

            .tracking-subtitle {
                font-size: 0.85rem;
            }

            .tracking-form-section {
                padding: 1.5rem 0;
            }

            .tracking-form-card {
                margin: 0 0.25rem;
                border-radius: 15px;
            }

            .card-header {
                padding: 0.875rem;
            }

            .card-body {
                padding: 0.875rem;
            }

            .form-label {
                font-size: 0.9rem;
            }

            .input-group .form-control {
                font-size: 0.9rem;
                padding: 0.625rem;
            }

            .btn-accent {
                padding: 0.625rem 0.875rem;
                font-size: 0.85rem;
            }

            .btn-accent .button-text {
                display: none;
            }

            .order-header-card {
                padding: 0.875rem;
                margin: 0 0.25rem 0.75rem 0.25rem;
            }

            .order-title {
                font-size: 1.125rem;
            }

            .order-subtitle {
                font-size: 0.8rem;
            }

            .timeline-card,
            .order-summary-card,
            .quick-actions-card {
                margin: 0 0.25rem 0.75rem 0.25rem;
            }

            .timeline {
                padding-left: 0.5rem;
            }

            .timeline-marker {
                left: -4px;
                top: 2px;
                width: 8px;
                height: 8px;
            }

            .timeline-content {
                padding-left: 0.5rem;
            }

            .timeline-title {
                font-size: 0.9rem;
            }

            .timeline-description {
                font-size: 0.8rem;
            }

            .timeline-date {
                font-size: 0.7rem;
            }

            .summary-item {
                padding: 0.625rem 0;
            }

            .summary-label {
                font-size: 0.85rem;
            }

            .summary-value {
                font-size: 0.85rem;
            }

            .btn-outline {
                padding: 0.4rem 0.625rem;
                font-size: 0.8rem;
            }
        }
    </style>
@endpush
