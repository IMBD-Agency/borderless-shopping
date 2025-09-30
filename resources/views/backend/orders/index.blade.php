@extends('layouts.backend')

@section('content')
    <div class="page-header">
        <h1 class="page-title">Orders Management</h1>
        <p class="page-description">Manage and process orders</p>
    </div>

    <!-- Filters Section -->
    <div class="filters-container mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fa-solid fa-filter me-2"></i>Filters
                </h5>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('backend.orders.index') }}" id="orders-filter-form">
                    <div class="row g-3">
                        <!-- Order Status Filter -->
                        <div class="col-md-3">
                            <label for="order_status" class="form-label">Order Status</label>
                            <select class="form-select" id="order_status" name="order_status">
                                <option value="">All Statuses</option>
                                <option value="order_received" {{ ($filters['order_status'] ?? '') == 'order_received' ? 'selected' : '' }}>Order Received</option>
                                <option value="order_confirmed" {{ ($filters['order_status'] ?? '') == 'order_confirmed' ? 'selected' : '' }}>Order Confirmed</option>
                                <option value="order_processed" {{ ($filters['order_status'] ?? '') == 'order_processed' ? 'selected' : '' }}>Order Processed</option>
                                <option value="order_shipped" {{ ($filters['order_status'] ?? '') == 'order_shipped' ? 'selected' : '' }}>Order Shipped</option>
                                <option value="order_delivered" {{ ($filters['order_status'] ?? '') == 'order_delivered' ? 'selected' : '' }}>Order Delivered</option>
                                <option value="order_returned" {{ ($filters['order_status'] ?? '') == 'order_returned' ? 'selected' : '' }}>Order Returned</option>
                                <option value="order_cancelled" {{ ($filters['order_status'] ?? '') == 'order_cancelled' ? 'selected' : '' }}>Order Cancelled</option>
                            </select>
                        </div>

                        <!-- Payment Status Filter -->
                        <div class="col-md-3">
                            <label for="payment_status" class="form-label">Payment Status</label>
                            <select class="form-select" id="payment_status" name="payment_status">
                                <option value="">All Payment Statuses</option>
                                <option value="pending" {{ ($filters['payment_status'] ?? '') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="partially" {{ ($filters['payment_status'] ?? '') == 'partially' ? 'selected' : '' }}>Partially Paid</option>
                                <option value="paid" {{ ($filters['payment_status'] ?? '') == 'paid' ? 'selected' : '' }}>Paid</option>
                            </select>
                        </div>

                        <!-- Search Type Dropdown -->
                        <div class="col-md-2">
                            <label for="search_type" class="form-label">Search By</label>
                            <select class="form-select" id="search_type" name="search_type">
                                <option value="">Select Type</option>
                                <option value="name" {{ ($filters['search_type'] ?? '') == 'name' ? 'selected' : '' }}>Name</option>
                                <option value="email" {{ ($filters['search_type'] ?? '') == 'email' ? 'selected' : '' }}>Email</option>
                                <option value="mobile" {{ ($filters['search_type'] ?? '') == 'mobile' ? 'selected' : '' }}>Mobile No</option>
                                <option value="tracking" {{ ($filters['search_type'] ?? '') == 'tracking' ? 'selected' : '' }}>Tracking Number</option>
                            </select>
                        </div>

                        <!-- Search Input -->
                        <div class="col-md-3">
                            <label for="search_term" class="form-label">Search Term</label>
                            <input type="text" class="form-control" id="search_term" name="search_term" value="{{ $filters['search_term'] ?? '' }}" placeholder="Enter search term...">
                        </div>

                        <!-- Action Buttons -->
                        <div class="col-md-1">
                            <label class="form-label d-none d-md-block">&nbsp;</label>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa-solid fa-search"></i>
                                </button>
                                <a href="{{ route('backend.orders.index') }}" class="btn btn-outline-secondary" title="Clear Filters">
                                    <i class="fa-solid fa-times"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="data-table-container">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle order-list-table">
                <thead>
                    <tr>
                        <th class="text-center">SN</th>
                        <th class="text-center">Recipient Name</th>
                        <th class="text-center">Recipient Mobile</th>
                        <th class="text-center">Tracking Number</th>
                        <th class="text-center" width="200">Status</th>
                        <th class="text-center">Total Amount</th>
                        <th class="text-center">Payment Status</th>
                        <th class="text-center" width="80">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        @php
                            $badge_class = '';
                            $final_statuses = ['order_delivered', 'order_returned', 'order_cancelled'];
                            $hasTotalAmount = $order->total_amount !== null;
                            switch ($order->status) {
                                case 'order_received':
                                    $badge_class = 'bg-warning';
                                    break;
                                case 'order_confirmed':
                                    $badge_class = 'bg-success';
                                    break;
                                case 'order_processed':
                                    $badge_class = 'bg-info';
                                    break;
                                case 'order_shipped':
                                    $badge_class = 'bg-primary';
                                    break;
                                case 'order_delivered':
                                    $badge_class = 'bg-success';
                                    break;
                                case 'order_returned':
                                    $badge_class = 'bg-danger';
                                    break;
                                case 'order_cancelled':
                                    $badge_class = 'bg-danger';
                                    break;
                            }
                        @endphp
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">{{ $order->recipient_name }}</td>
                            <td class="text-center">{{ $order->recipient_mobile }}</td>
                            <td class="text-center">{{ $order->tracking_number }}</td>
                            <td class="text-center">
                                @if (in_array($order->status, $final_statuses))
                                    @php
                                        $badge_class = '';
                                        switch ($order->status) {
                                            case 'order_delivered':
                                                $badge_class = 'bg-success';
                                                break;
                                            case 'order_returned':
                                                $badge_class = 'bg-danger';
                                                break;
                                            case 'order_cancelled':
                                                $badge_class = 'bg-danger';
                                                break;
                                        }
                                    @endphp
                                    <span class="rh-badge {{ $badge_class }}">
                                        {{ ucwords(str_replace('_', ' ', $order->status)) }}
                                    </span>
                                @else
                                    @php
                                        $border_class = '';
                                        switch ($order->status) {
                                            case 'order_received':
                                                $border_class = 'border-warning';
                                                break;
                                            case 'order_confirmed':
                                                $border_class = 'border-success';
                                                break;
                                            case 'order_processed':
                                                $border_class = 'border-info';
                                                break;
                                            case 'order_shipped':
                                                $border_class = 'border-primary';
                                                break;
                                        }
                                    @endphp
                                    <select class="form-select form-select-sm status-select {{ $border_class }}" data-order-id="{{ $order->id }}" style="min-width: 140px; border-radius: 8px; border-width: 2px !important;">
                                        <option value="order_received" {{ $order->status == 'order_received' ? 'selected' : '' }}>Order Received</option>
                                        <option value="order_confirmed" {{ $order->status == 'order_confirmed' ? 'selected' : '' }}>Order Confirmed</option>
                                        <option value="order_processed" {{ $order->status == 'order_processed' ? 'selected' : '' }}>Order Processed</option>
                                        <option value="order_shipped" {{ $order->status == 'order_shipped' ? 'selected' : '' }}>Order Shipped</option>
                                        <option value="order_delivered" {{ $order->status == 'order_delivered' ? 'selected' : '' }}>Order Delivered</option>
                                        <option value="order_returned" {{ $order->status == 'order_returned' ? 'selected' : '' }}>Order Returned</option>
                                        <option value="order_cancelled" {{ $order->status == 'order_cancelled' ? 'selected' : '' }}>Order Cancelled</option>
                                    </select>
                                @endif
                            </td>
                            <td class="text-center">
                                @php $due = max(0, (float)($order->total_amount ?? 0) - (float)($order->total_paid_amount ?? 0)); @endphp
                                {{ $order->total_amount ? number_format($order->total_amount, 2) . ' BDT' : '-' }}
                                @if ($order->total_amount)
                                    <div class="text-muted" style="font-size: 12px;">Due: {{ number_format($due, 2) }} BDT</div>
                                @endif
                            </td>
                            <td class="text-center">
                                @switch($order->payment_status)
                                    @case('paid')
                                        <span class="rh-badge bg-success">Paid</span>
                                    @break

                                    @case('partially')
                                        <span class="rh-badge bg-info">Partially Paid</span>
                                    @break

                                    @case('pending')
                                        <span class="rh-badge bg-danger">Pending</span>
                                    @break
                                @endswitch
                            </td>
                            <td class="text-center">
                                <div class="dropdown order-actions-dropdown">
                                    <button class="btn btn-action-dropdown dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" title="Actions">
                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end order-dropdown-menu">
                                        <li>
                                            <button class="dropdown-item action-item view-order" data-order-id="{{ $order->id }}">
                                                <i class="fa-solid fa-eye action-icon"></i>
                                                <span class="action-text">View Details</span>
                                            </button>
                                        </li>
                                        <li>
                                            <button class="dropdown-item action-item edit-order" data-order-id="{{ $order->id }}">
                                                <i class="fa-solid fa-edit action-icon"></i>
                                                <span class="action-text">Edit Order</span>
                                            </button>
                                        </li>
                                        @if ($hasTotalAmount)
                                            <li>
                                                <a class="dropdown-item action-item" href="{{ route('frontend.order-request.invoice', $order->slug) }}" target="_blank">
                                                    <i class="fa-solid fa-file-invoice-dollar action-icon"></i>
                                                    <span class="action-text">View Invoice</span>
                                                </a>
                                            </li>
                                            <li>
                                                <button class="dropdown-item action-item send-invoice" data-order-id="{{ $order->id }}" data-order-slug="{{ $order->slug }}">
                                                    <i class="fa-solid fa-envelope action-icon"></i>
                                                    <span class="action-text">Send Invoice</span>
                                                </button>
                                            </li>
                                            <li>
                                                <button class="dropdown-item action-item add-payment" data-order-id="{{ $order->id }}">
                                                    <i class="fa-solid fa-plus-circle action-icon"></i>
                                                    <span class="action-text">Add Payment</span>
                                                </button>
                                            </li>
                                            <li>
                                                <button class="dropdown-item action-item view-payments" data-order-id="{{ $order->id }}">
                                                    <i class="fa-solid fa-list action-icon"></i>
                                                    <span class="action-text">View Payments</span>
                                                </button>
                                            </li>
                                        @endif
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li>
                                            <button class="dropdown-item action-item action-danger delete-order" data-order-id="{{ $order->id }}">
                                                <i class="fa-solid fa-trash action-icon"></i>
                                                <span class="action-text">Delete Order</span>
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">No orders found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endsection

    @push('scripts')
        <script>
            $(document).ready(function() {
                // Filter form functionality
                $('#orders-filter-form').on('submit', function(e) {
                    e.preventDefault();
                    var formData = $(this).serialize();
                    var url = $(this).attr('action') + '?' + formData;

                    // Show loading state
                    $('.data-table-container').html('<div class="text-center p-4"><i class="fa-solid fa-spinner fa-spin me-2"></i>Loading orders...</div>');

                    // Reload page with filters
                    window.location.href = url;
                });

                // Auto-submit on filter change (optional - can be removed if manual submit is preferred)
                $('#order_status, #payment_status').on('change', function() {
                    $('#orders-filter-form').submit();
                });

                // Clear search when search type changes
                $('#search_type').on('change', function() {
                    $('#search_term').val('');
                });

                // Enable/disable search input based on search type selection
                $('#search_type').on('change', function() {
                    var searchType = $(this).val();
                    var searchInput = $('#search_term');

                    if (searchType) {
                        searchInput.prop('disabled', false);
                        searchInput.focus();

                        // Update placeholder based on search type
                        var placeholders = {
                            'name': 'Enter recipient name...',
                            'email': 'Enter email address...',
                            'mobile': 'Enter mobile number...',
                            'tracking': 'Enter tracking number...'
                        };
                        searchInput.attr('placeholder', placeholders[searchType] || 'Enter search term...');
                    } else {
                        searchInput.prop('disabled', true);
                        searchInput.val('');
                        searchInput.attr('placeholder', 'Select search type first...');
                    }
                });

                // Initialize search input state
                var searchType = $('#search_type').val();
                if (!searchType) {
                    $('#search_term').prop('disabled', true);
                    $('#search_term').attr('placeholder', 'Select search type first...');
                }
                $('.view-order').click(function() {
                    modalLoading(MODAL_XL);
                    var id = $(this).data('order-id');
                    $.ajax({
                        url: '{{ route('backend.orders.show', ':id') }}'.replace(':id', id),
                        type: 'GET',
                        success: function(response) {
                            MODAL_XL_CONTENT.html(response);
                        }
                    });
                });

                $('.edit-order').click(function() {
                    modalLoading(MODAL_XL);
                    var id = $(this).data('order-id');
                    $.ajax({
                        url: '{{ route('backend.orders.edit', ':id') }}'.replace(':id', id),
                        type: 'GET',
                        success: function(response) {
                            MODAL_XL_CONTENT.html(response);
                        }
                    });
                });

                $('.add-payment').click(function() {
                    var id = $(this).data('order-id');
                    modalLoading(MODAL_MD);
                    $.ajax({
                        url: '{{ route('backend.orders.payments.create', ':id') }}'.replace(':id', id),
                        type: 'GET',
                        success: function(response) {
                            MODAL_MD_CONTENT.html(response);
                        }
                    });
                });

                $('.delete-order').click(function() {
                    var id = $(this).data('order-id');
                    let url = "{{ route('backend.orders.destroy', ':id') }}";
                    url = url.replace(':id', id);
                    delete_warning(url);
                });

                // Status change handler
                $('.status-select').change(function() {
                    var orderId = $(this).data('order-id');
                    var newStatus = $(this).val();
                    var selectElement = $(this);

                    // Update border color immediately
                    updateStatusBorder(selectElement, newStatus);

                    // Show loading state
                    selectElement.prop('disabled', true);

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, do it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: '{{ route('backend.orders.update-status', ':id') }}'.replace(':id', orderId),
                                type: 'PUT',
                                data: {
                                    status: newStatus,
                                    _token: "{{ csrf_token() }}"
                                },
                                success: function(response) {
                                    if (response.success) {
                                        // Show success message
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Success!',
                                            text: response.message,
                                            timer: 1500,
                                            showConfirmButton: false
                                        });
                                    }
                                },
                                error: function(xhr) {
                                    // Revert the select value and border color on error
                                    selectElement.val(selectElement.data('original-value'));
                                    updateStatusBorder(selectElement, selectElement.data('original-value'));

                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error!',
                                        text: 'Failed to update order status. Please try again.',
                                        timer: 2000,
                                        showConfirmButton: false
                                    });
                                },
                                complete: function() {
                                    // Re-enable the select
                                    selectElement.prop('disabled', false);
                                }
                            });
                        } else {
                            selectElement.val(selectElement.data('original-value'));
                            updateStatusBorder(selectElement, selectElement.data('original-value'));
                        }
                    });
                });

                // Function to update border color based on status
                function updateStatusBorder(selectElement, status) {
                    // Remove all border classes
                    selectElement.removeClass('border-warning border-success border-info border-primary border-danger');

                    // Add appropriate border class
                    switch (status) {
                        case 'order_received':
                            selectElement.addClass('border-warning');
                            break;
                        case 'order_confirmed':
                            selectElement.addClass('border-success');
                            break;
                        case 'order_processed':
                            selectElement.addClass('border-info');
                            break;
                        case 'order_shipped':
                            selectElement.addClass('border-primary');
                            break;
                        case 'order_delivered':
                            selectElement.addClass('border-success');
                            break;
                        case 'order_returned':
                            selectElement.addClass('border-danger');
                            break;
                        case 'order_cancelled':
                            selectElement.addClass('border-danger');
                            break;
                    }
                }

                // Store original values for error handling (only for select elements)
                $('.status-select').each(function() {
                    $(this).data('original-value', $(this).val());
                });

                $('.view-payments').click(function() {
                    var id = $(this).data('order-id');
                    modalLoading(MODAL_MD);
                    $.ajax({
                        url: '{{ route('backend.orders.payments.index', ':id') }}'.replace(':id', id),
                        type: 'GET',
                        success: function(response) {
                            MODAL_MD_CONTENT.html(response);
                        }
                    });
                });

                $('.send-invoice').click(function() {
                    var id = $(this).data('order-id');
                    Swal.fire({
                        title: 'Send invoice?',
                        text: 'This will email the invoice to the customer associated with this order.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Send',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: '{{ route('backend.orders.send-invoice', ':id') }}'.replace(':id', id),
                                type: 'POST',
                                data: {
                                    _token: '{{ csrf_token() }}'
                                },
                                success: function(resp) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Sent',
                                        text: resp.message,
                                        timer: 1500,
                                        showConfirmButton: false
                                    });
                                },
                                error: function(xhr) {
                                    var msg = (xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : 'Failed to send invoice.';
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: msg
                                    });
                                }
                            });
                        }
                    });
                });
            });
        </script>
    @endpush
