<div class="modal-header" style="background: linear-gradient(135deg, var(--accent) 0%, var(--accent-deep) 100%); color: white; border: none;">
    <h1 class="modal-title fs-5 fw-bold">
        <i class="fas fa-shopping-cart me-2"></i>Order Details #{{ $order->tracking_number }}
    </h1>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body" style="background-color: var(--bg); padding: 30px;">
    <div class="row g-4">
        <!-- Order Status Card -->
        <div class="col-12">
            <div class="order-status-card" style="background: var(--surface); border-radius: 16px; padding: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); border-left: 4px solid var(--accent);">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-1 fw-semibold" style="color: var(--text);">Order Status</h6>
                        <small class="text-muted">Current order status</small>
                    </div>
                    @php
                        $badge_class = '';
                        $badge_icon = '';
                        switch ($order->status) {
                            case 'order_received':
                                $badge_class = 'bg-warning';
                                $badge_icon = 'fas fa-clock';
                                break;
                            case 'order_confirmed':
                                $badge_class = 'bg-success';
                                $badge_icon = 'fas fa-check-circle';
                                break;
                            case 'order_processed':
                                $badge_class = 'bg-info';
                                $badge_icon = 'fas fa-cogs';
                                break;
                            case 'order_shipped':
                                $badge_class = 'bg-primary';
                                $badge_icon = 'fas fa-shipping-fast';
                                break;
                            case 'order_delivered':
                                $badge_class = 'bg-success';
                                $badge_icon = 'fas fa-check-double';
                                break;
                            case 'order_returned':
                                $badge_class = 'bg-danger';
                                $badge_icon = 'fas fa-undo';
                                break;
                            case 'order_cancelled':
                                $badge_class = 'bg-danger';
                                $badge_icon = 'fas fa-times-circle';
                                break;
                        }
                    @endphp
                    <span class="rh-badge {{ $badge_class }} fs-6 px-3 py-2">
                        <i class="{{ $badge_icon }} me-1"></i>{{ ucwords(str_replace('_', ' ', $order->status)) }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Product Information Card (Multi-product) -->
        <div class="col-12">
            <div class="info-card" style="background: var(--surface); border-radius: 16px; padding: 25px; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
                <div class="d-flex align-items-center mb-4">
                    <div class="icon-wrapper me-3" style="width: 40px; height: 40px; background: linear-gradient(135deg, var(--accent), var(--accent-soft)); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-boxes-stacked text-white"></i>
                    </div>
                    <h6 class="mb-0 fw-bold" style="color: var(--text);">Product Information</h6>
                </div>
                @if ($order->products && $order->products->count())
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Product</th>
                                    <th class="text-center">Price (BDT)</th>
                                    <th class="text-center">Purchase Cost (BDT)</th>
                                    <th class="text-center">Qty</th>
                                    <th class="text-end">Subtotal (BDT)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $grandTotal = 0; @endphp
                                @foreach ($order->products as $index => $product)
                                    @php
                                        $subtotal = ($product->product_price ?? 0) + ($product->purchase_cost ?? 0);
                                        $grandTotal += $subtotal;
                                    @endphp
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <a href="{{ $product->product_url }}" target="_blank" class="text-decoration-none" style="color: var(--accent);">
                                                    <i class="fa-solid fa-arrow-up-right-from-square me-1"></i>{{ Str::limit($product->product_url, 30) }}
                                                </a>
                                                <small class="text-muted">{{ $product->product_name ?? 'N/A' }}</small>
                                            </div>
                                        </td>
                                        <td class="text-center">{{ $product->product_price ? number_format($product->product_price, 2) : '—' }}</td>
                                        <td class="text-center">{{ $product->purchase_cost ? number_format($product->purchase_cost, 2) : '—' }}</td>
                                        <td class="text-center"><span class="badge bg-light text-dark">{{ $product->product_quantity }}</span></td>
                                        <td class="text-end">{{ $subtotal ? number_format($subtotal, 2) : '—' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="5" class="text-end">Products Total</th>
                                    <th class="text-end">{{ number_format($grandTotal, 2) }} BDT</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                @else
                    <div class="alert alert-light mb-0">No products added to this order.</div>
                @endif
            </div>
        </div>

        <!-- Recipient Information Card -->
        <div class="col-12">
            <div class="info-card" style="background: var(--surface); border-radius: 16px; padding: 25px; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
                <div class="d-flex align-items-center mb-4">
                    <div class="icon-wrapper me-3" style="width: 40px; height: 40px; background: linear-gradient(135deg, var(--accent), var(--accent-soft)); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-user text-white"></i>
                    </div>
                    <h6 class="mb-0 fw-bold" style="color: var(--text);">Recipient Information</h6>
                </div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="info-item d-flex align-items-center gap-2">
                            <span class="fw-semibold" style="color: var(--muted);">Name:</span>
                            <span style="color: var(--text);">{{ $order->recipient_name }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-item d-flex align-items-center gap-2">
                            <span class="fw-semibold" style="color: var(--muted);">Mobile:</span>
                            <span style="color: var(--text);">{{ $order->recipient_mobile }}</span>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="info-item d-flex align-items-start gap-2">
                            <span class="fw-semibold" style="color: var(--muted);">Address:</span>
                            <span style="color: var(--text); text-align: right; max-width: 60%;">{{ $order->recipient_address }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Details Card -->
        <div class="col-12">
            <div class="info-card" style="background: var(--surface); border-radius: 16px; padding: 25px; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
                <div class="d-flex align-items-center mb-4">
                    <div class="icon-wrapper me-3" style="width: 40px; height: 40px; background: linear-gradient(135deg, var(--accent), var(--accent-soft)); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-receipt text-white"></i>
                    </div>
                    <h6 class="mb-0 fw-bold" style="color: var(--text);">Order Details</h6>
                </div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="info-item d-flex align-items-center gap-2">
                            <span class="fw-semibold" style="color: var(--muted);">Tracking Number:</span>
                            <span style="color: var(--text);">{{ $order->tracking_number ?? 'Not assigned' }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-item d-flex align-items-center gap-2">
                            <span class="fw-semibold" style="color: var(--muted);">Order Date:</span>
                            <span style="color: var(--text);">{{ $order->created_at->format('M d, Y H:i A') }}</span>
                        </div>
                    </div>
                    @if ($order->notes)
                        <div class="col-12">
                            <div class="info-item d-flex align-items-start gap-2">
                                <span class="fw-semibold" style="color: var(--muted);">Notes:</span>
                                <span style="color: var(--text); text-align: right; max-width: 60%;">{{ $order->notes }}</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Pricing Information Card -->
        <div class="col-12">
            <div class="info-card" style="background: var(--surface); border-radius: 16px; padding: 25px; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
                <div class="d-flex align-items-center mb-4">
                    <div class="icon-wrapper me-3" style="width: 40px; height: 40px; background: linear-gradient(135deg, var(--accent), var(--accent-soft)); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-calculator text-white"></i>
                    </div>
                    <h6 class="mb-0 fw-bold" style="color: var(--text);">Pricing Breakdown</h6>
                </div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="info-item d-flex align-items-center gap-2">
                            <span class="fw-semibold" style="color: var(--muted);">Products Total:</span>
                            <span style="color: var(--text);">{{ number_format($grandTotal, 2) }} BDT</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-item d-flex align-items-center gap-2">
                            <span class="fw-semibold" style="color: var(--muted);">Shipping Charge:</span>
                            <span style="color: var(--text);">{{ $order->shipping_charge !== null ? number_format($order->shipping_charge, 2) . ' BDT' : 'N/A' }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-item d-flex align-items-center gap-2">
                            <span class="fw-semibold" style="color: var(--muted);">Service Charge:</span>
                            <span style="color: var(--text);">{{ $order->service_charge !== null ? number_format($order->service_charge, 2) . ' BDT' : 'N/A' }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-item d-flex align-items-center gap-2">
                            <span class="fw-semibold" style="color: var(--muted);">Discount:</span>
                            <span style="color: var(--text);">{{ $order->discount !== null ? number_format($order->discount, 2) . ' BDT' : 'N/A' }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-item d-flex align-items-center gap-2">
                            <span class="fw-semibold" style="color: var(--muted);">Payment Status:</span>
                            @php
                                $paymentBadgeClass = 'bg-secondary';
                                switch ($order->payment_status) {
                                    case 'pending':
                                        $paymentBadgeClass = 'bg-warning';
                                        break;
                                    case 'partially':
                                        $paymentBadgeClass = 'bg-info';
                                        break;
                                    case 'paid':
                                        $paymentBadgeClass = 'bg-success';
                                        break;
                                }
                            @endphp
                            <span class="rh-badge {{ $paymentBadgeClass }} px-3 py-1 d-inline-flex align-items-center" style="border-radius: 999px; color: #fff;">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-item d-flex align-items-center gap-2">
                            <span class="fw-semibold" style="color: var(--muted);">Paid Amount:</span>
                            <span style="color: var(--text);">{{ number_format($order->total_paid_amount ?? 0, 2) }} BDT</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-item d-flex align-items-center gap-2">
                            <span class="fw-semibold" style="color: var(--muted);">Due Amount:</span>
                            @php $due = max(0, (float)($order->total_amount ?? 0) - (float)($order->total_paid_amount ?? 0)); @endphp
                            <span style="color: var(--text);">{{ number_format($due, 2) }} BDT</span>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="total-amount-section" style="background: linear-gradient(135deg, var(--accent-soft), var(--accent)); border-radius: 12px; padding: 20px; margin-top: 15px;">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="mb-0 fw-bold text-white">Total Amount</h6>
                                <h4 class="mb-0 fw-bold text-white">{{ $order->total_amount !== null ? number_format($order->total_amount, 2) . ' BDT' : 'N/A' }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customer Information Card -->
        @if ($order->user)
            <div class="col-12">
                <div class="info-card" style="background: var(--surface); border-radius: 16px; padding: 25px; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
                    <div class="d-flex align-items-center mb-4">
                        <div class="icon-wrapper me-3" style="width: 40px; height: 40px; background: linear-gradient(135deg, var(--accent), var(--accent-soft)); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-user-circle text-white"></i>
                        </div>
                        <h6 class="mb-0 fw-bold" style="color: var(--text);">Customer Information</h6>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="info-item d-flex align-items-center gap-2">
                                <span class="fw-semibold" style="color: var(--muted);">Customer Name:</span>
                                <span style="color: var(--text);">{{ $order->user->name }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item d-flex align-items-center gap-2">
                                <span class="fw-semibold" style="color: var(--muted);">Customer Email:</span>
                                <span style="color: var(--text);">{{ $order->user->email }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
<div class="modal-footer" style="background: var(--surface); border: none; padding: 20px 30px;">
    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
        <i class="fas fa-times me-2"></i>Close
    </button>
</div>
