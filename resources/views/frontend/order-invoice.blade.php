@extends('layouts.frontend')

@section('content')
    <div class="container py-5">
        <div class="invoice-card shadow-sm">
            <div class="invoice-header d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-3">
                    <img src="{{ asset('assets/images/logos/borderless-logo-icon.png') }}" alt="{{ config('app.name') }}" style="height:40px;width:auto;">
                    <h2 class="mb-0">Invoice</h2>
                </div>
                <div class="text-end">
                    <div class="text-muted small">Tracking ID</div>
                    <div class="fw-bold tracking-id">#{{ $order->tracking_number }}</div>
                </div>
            </div>

            <div class="row g-4 mt-1 invoice-meta">
                <div class="col-md-6">
                    <div class="card-meta p-3 h-100">
                        <div class="text-muted small mb-1">Billed To</div>
                        <div class="fw-semibold">{{ $order->recipient_name }}</div>
                        <div class="text-muted">{{ $order->recipient_mobile }}</div>
                        <div class="text-muted">{{ $order->recipient_address }}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card-meta p-3 h-100">
                        <div class="text-muted small mb-1">Invoice Details</div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Status:</span>
                            <span class="badge status-badge">{{ ucwords(str_replace('_', ' ', $order->status ?? 'order_received')) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Payment Status:</span>
                            <span>{{ ucfirst($order->payment_status) }}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Date:</span>
                            <span>{{ $order->created_at->format('d F Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive mt-4">
                <table class="table table-bordered align-middle mb-0 invoice-table">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th class="text-center">Price</th>
                            <th class="text-center">Purchase Cost</th>
                            <th class="text-center">Qty</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $itemsSubtotal = 0;
                        @endphp
                        @forelse($order->products as $product)
                            @php
                                $price = $product->product_price ?? 0;
                                $purchaseCost = $product->purchase_cost ?? 0;
                                $qty = $product->product_quantity ?? 1;
                                $subtotal = $price + $purchaseCost;
                                $itemsSubtotal += $subtotal;
                            @endphp
                            <tr>
                                <td>
                                    {{ $product->product_name ?? 'Product' }}
                                    @if ($product->product_url)
                                        <div class="small"><a href="{{ $product->product_url }}" class="link-secondary text-decoration-none" target="_blank"><i class="fa-solid fa-arrow-up-right-from-square me-1"></i>View Product</a></div>
                                    @endif
                                </td>
                                <td class="text-center">{{ $price ? number_format($price, 2) : '-' }}</td>
                                <td class="text-center">{{ $purchaseCost ? number_format($purchaseCost, 2) : '-' }}</td>
                                <td class="text-center">{{ $qty }}</td>
                                <td class="text-end">{{ $price ? number_format($subtotal, 2) : '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">No products added</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @php
                $shipping = $order->shipping_charge ?? 0;
                $service = $order->service_charge ?? 0;
                $discount = $order->discount ?? 0;
                $calculatedTotal = max(0, $itemsSubtotal + (float) $shipping + (float) $service - (float) $discount);
                $total = $order->total_amount ?? $calculatedTotal;
            @endphp

            <div class="row mt-4">
                <div class="col-md-6">
                    @if ($order->notes)
                        <div class="p-3 rounded notes-box">
                            <div class="text-muted small mb-2">Notes</div>
                            <div>{{ $order->notes }}</div>
                        </div>
                    @endif
                </div>
                <div class="col-md-6">
                    <div class="totals-box p-3">
                        <div class="d-flex justify-content-between mb-2"><span class="text-muted">Items Subtotal</span><span>{{ number_format($itemsSubtotal, 2) }}</span></div>
                        <div class="d-flex justify-content-between mb-2"><span class="text-muted">Shipping</span><span>{{ number_format((float) $shipping, 2) }}</span></div>
                        <div class="d-flex justify-content-between mb-2"><span class="text-muted">Service Charge</span><span>{{ number_format((float) $service, 2) }}</span></div>
                        <div class="d-flex justify-content-between mb-3"><span class="text-muted">Discount</span><span>-{{ number_format((float) $discount, 2) }}</span></div>
                        <div class="d-flex justify-content-between fw-bold total-row"><span>Total</span><span>{{ number_format((float) $total, 2) }} BDT</span></div>
                        @php $due = max(0, (float)($order->total_amount ?? 0) - (float)($order->total_paid_amount ?? 0)); @endphp
                        @if ($order->total_amount)
                            <div class="d-flex justify-content-between mb-1 mt-3"><span class="text-muted">Paid</span><span>{{ number_format($order->total_paid_amount ?? 0, 2) }} BDT</span></div>
                            <div class="d-flex justify-content-between"><span class="text-muted">Due</span><span>{{ number_format($due, 2) }} BDT</span></div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="mt-4 d-print-none d-flex justify-content-start">
                <a class="btn btn-accent" href="{{ route('frontend.order-request.invoice.download', $order->slug) }}"><i class="fa-solid fa-download"></i> Download Invoice</a>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        :root {
            --accent-color: #ec1d25;
            --accent-hover: #d11922;
            --dark-color: #212529;
            --text-muted: #6c757d;
        }

        .invoice-card {
            background: #fff;
            border: 1px solid #e9ecef;
            border-radius: 12px;
            padding: 2rem;
            width: 210mm;
            min-height: 297mm;
            margin: 0 auto;
        }

        .invoice-header {
            border-bottom: 2px solid rgba(236, 29, 37, 0.15);
            padding-bottom: 1rem;
            margin-bottom: 1rem
        }

        .tracking-id {
            color: var(--text-muted);
            font-family: monospace
        }

        .card-meta {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 10px
        }

        .invoice-table thead th {
            background: var(--accent-color);
            color: #fff;
        }

        .invoice-table tbody tr td {
            vertical-align: middle
        }

        .invoice-table th.text-center,
        .invoice-table td.text-center {
            text-align: center;
        }

        .totals-box {
            border: 1px solid #e9ecef;
            border-radius: 10px;
            background: #fff
        }

        .total-row {
            font-size: 1.1rem;
            border-top: 2px dashed rgba(33, 37, 41, 0.1);
            padding-top: .5rem
        }

        .status-badge {
            background: var(--accent-color);
            line-height: 1.5;
        }

        .notes-box {
            background: #fff;
            border: 1px dashed rgba(236, 29, 37, 0.35)
        }

        @media print {

            .navbar,
            .footer,
            .btn,
            .d-print-none {
                display: none !important
            }

            body {
                background: #fff
            }

            .invoice-card {
                box-shadow: none;
                border: 0;
                padding: 0
            }
        }
    </style>
@endpush
