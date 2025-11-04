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
                                            <input type="text" class="form-control" id="tracking_number" name="tracking_number" placeholder="Enter tracking number (e.g., AU-XXXXXXXX)" value="{{ request('tracking_number') }}" autocomplete="off" required>
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
            border: 2px solid #e9ecef;
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

        @media (max-width: 576px) {
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

            .order-title {
                font-size: 1.25rem;
            }

            .order-subtitle {
                font-size: 0.9rem;
            }

            .timeline-date {
                font-size: 0.75rem;
            }

            .btn-outline {
                padding: 0.5rem 0.75rem;
                font-size: 0.85rem;
            }
        }

        @media (max-width: 480px) {
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

            .order-title {
                font-size: 1.125rem;
            }

            .order-subtitle {
                font-size: 0.8rem;
            }

            .timeline-date {
                font-size: 0.7rem;
            }

            .btn-outline {
                padding: 0.4rem 0.625rem;
                font-size: 0.8rem;
            }
        }
    </style>
@endpush
