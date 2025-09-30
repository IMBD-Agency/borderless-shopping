<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Invoice - {{ $order->tracking_number }}</title>
        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                font-family: 'DejaVu Sans', Arial, sans-serif;
                font-size: 12px;
                line-height: 1.4;
                color: #333;
                background: #fff;
                padding: 20px;
            }

            .invoice-wrapper {
                width: 100%;
                max-width: 210mm;
                margin: 0 auto;
            }

            /* Header Section */
            .invoice-header {
                width: 100%;
                margin-bottom: 25px;
                border-bottom: 3px solid #ec1d25;
                padding-bottom: 15px;
            }

            .header-content {
                width: 100%;
                display: table;
            }

            .logo-area {
                display: table-cell;
                width: 60%;
                vertical-align: middle;
            }

            .logo-area img {
                max-height: 40px;
                width: auto;
            }

            .invoice-info {
                display: table-cell;
                width: 40%;
                vertical-align: middle;
                text-align: right;
            }

            .invoice-title {
                font-size: 28px;
                font-weight: bold;
                color: #333;
                margin-bottom: 5px;
            }

            .tracking-info {
                font-size: 11px;
                color: #666;
                margin-bottom: 3px;
            }

            .tracking-number {
                font-size: 15px;
                font-weight: bold;
                color: #ec1d25;
                font-family: 'DejaVu Sans Mono', monospace;
            }

            /* Bill To and Invoice Details Section */
            .invoice-details-section {
                width: 100%;
                margin-bottom: 25px;
            }

            .details-row {
                width: 100%;
                display: table;
            }

            .bill-to-column {
                display: table-cell;
                width: 48%;
                vertical-align: top;
                padding-right: 10px;
            }

            .invoice-meta-column {
                display: table-cell;
                width: 48%;
                vertical-align: top;
                padding-left: 10px;
            }

            .info-card {
                background: #f9f9f9;
                border: 1px solid #ddd;
                border-radius: 5px;
                padding: 15px;
            }

            .card-header {
                font-size: 11px;
                font-weight: bold;
                text-transform: uppercase;
                color: #666;
                margin-bottom: 10px;
                letter-spacing: 0.5px;
            }

            .customer-name {
                font-size: 14px;
                font-weight: bold;
                color: #333;
                margin-bottom: 5px;
            }

            .customer-details {
                font-size: 12px;
                color: #666;
                line-height: 1.5;
            }

            .detail-row {
                margin-bottom: 5px;
                width: 100%;
                display: table;
            }

            .detail-label {
                display: table-cell;
                width: 35%;
                font-size: 11px;
                color: #666;
            }

            .detail-value {
                display: table-cell;
                width: 65%;
                font-size: 12px;
                color: #333;
                text-align: right;
            }

            .status-badge {
                background: #ec1d25;
                color: white;
                padding: 3px 8px;
                border-radius: 3px;
                font-size: 10px;
                font-weight: bold;
                text-transform: uppercase;
            }

            /* Products Table */
            .products-table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 25px;
                border: 1px solid #ddd;
            }

            .products-table thead {
                background: #ec1d25;
            }

            .products-table th {
                color: white;
                padding: 10px 5px;
                font-size: 10.5px;
                font-weight: bold;
                text-transform: uppercase;
                text-align: left;
                border-right: 1px solid rgba(255, 255, 255, 0.2);
            }

            .products-table th:last-child {
                border-right: none;
            }

            .products-table th.text-right {
                text-align: right;
            }

            .products-table th.text-center {
                text-align: center;
            }

            .products-table td {
                padding: 10px 8px;
                border-bottom: 1px solid #eee;
                border-right: 1px solid #eee;
                font-size: 12px;
                vertical-align: top;
            }

            .products-table td:last-child {
                border-right: none;
            }

            .products-table td.text-right {
                text-align: right;
            }

            .products-table td.text-center {
                text-align: center;
            }

            .product-name {
                font-weight: bold;
                color: #333;
                margin-bottom: 3px;
                word-wrap: break-word;
            }

            .product-url a {
                font-size: 10px;
                color: #999;
                word-break: break-all;
                text-decoration: none;
            }

            .empty-products {
                text-align: center;
                padding: 30px;
                color: #999;
                font-style: italic;
            }

            /* Column Widths */
            .col-item {
                width: 42%;
            }

            .col-price {
                width: 15%;
            }

            .col-purchase-cost {
                width: 15%;
            }

            .col-qty {
                width: 10%;
            }

            .col-total {
                width: 18%;
            }

            /* Footer Section */
            .invoice-footer {
                width: 100%;
            }

            .footer-row {
                width: 100%;
                display: table;
            }

            .notes-column {
                display: table-cell;
                width: 48%;
                vertical-align: top;
                padding-right: 10px;
            }

            .totals-column {
                display: table-cell;
                width: 48%;
                vertical-align: top;
                padding-left: 10px;
            }

            .notes-box {
                border: 1px dashed #ec1d255f;
                border-radius: 5px;
                padding: 15px;
                background: #fff;
            }

            .notes-header {
                font-size: 11px;
                font-weight: bold;
                text-transform: uppercase;
                color: #666;
                margin-bottom: 8px;
            }

            .notes-content {
                font-size: 12px;
                color: #333;
                line-height: 1.4;
            }

            .totals-box {
                border: 1px solid #ddd;
                border-radius: 5px;
                padding: 15px;
                background: #f9f9f9;
            }

            .total-line {
                width: 100%;
                display: table;
                margin-bottom: 8px;
            }

            .total-line-label {
                display: table-cell;
                width: 50%;
                font-size: 12px;
                color: #666;
            }

            .total-line-amount {
                display: table-cell;
                width: 50%;
                font-size: 12px;
                color: #333;
                text-align: right;
            }

            .total-final {
                border-top: 2px solid #ddd;
                padding-top: 10px;
                margin-top: 10px;
            }

            .total-final .total-line-label,
            .total-final .total-line-amount {
                font-size: 14px;
                font-weight: bold;
                color: #333;
            }

            /* Print Styles */
            @media print {
                body {
                    -webkit-print-color-adjust: exact;
                    color-adjust: exact;
                }
            }

            /* Utility Classes */
            .text-center {
                text-align: center;
            }

            .text-right {
                text-align: right;
            }

            .text-left {
                text-align: left;
            }

            .font-bold {
                font-weight: bold;
            }
        </style>
    </head>

    <body>
        <div class="invoice-wrapper">
            <!-- Header -->
            <div class="invoice-header">
                <div class="header-content">
                    <div class="logo-area">
                        <img src="{{ public_path('assets/images/logos/borderless-logo.png') }}" alt="{{ config('app.name') }}">
                    </div>
                    <div class="invoice-info">
                        <div class="invoice-title">Invoice</div>
                        <div class="tracking-info">Tracking ID</div>
                        <div class="tracking-number">#{{ $order->tracking_number }}</div>
                    </div>
                </div>
            </div>

            <!-- Bill To and Invoice Details -->
            <div class="invoice-details-section">
                <div class="details-row">
                    <div class="bill-to-column">
                        <div class="info-card">
                            <div class="card-header">Billed To</div>
                            <div class="customer-name">{{ $order->recipient_name }}</div>
                            <div class="customer-details">
                                <div>{{ $order->recipient_mobile }}</div>
                                <div>{{ $order->recipient_address }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="invoice-meta-column">
                        <div class="info-card">
                            <div class="card-header">Invoice Details</div>
                            <div class="detail-row">
                                <div class="detail-label">Status:</div>
                                <div class="detail-value">
                                    <span class="status-badge">{{ ucwords(str_replace('_', ' ', $order->status ?? 'order_received')) }}</span>
                                </div>
                            </div>
                            <div class="detail-row">
                                <div class="detail-label">Payment Status:</div>
                                <div class="detail-value">{{ ucfirst($order->payment_status) }}</div>
                            </div>
                            <div class="detail-row">
                                <div class="detail-label">Date:</div>
                                <div class="detail-value">{{ $order->created_at->format('d M Y') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products Table -->
            <table class="products-table">
                <thead>
                    <tr>
                        <th class="col-item">Item</th>
                        <th class="col-price text-center">Price</th>
                        <th class="col-purchase-cost text-center">Purchase Cost</th>
                        <th class="col-qty text-center">Qty</th>
                        <th class="col-total text-right">Subtotal</th>
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
                            <td class="col-item">
                                <div class="product-name">{{ $product->product_name ?? 'Product' }}</div>
                                <div class="product-url"><a href="{{ $product->product_url }}" target="_blank">{{ Str::limit($product->product_url, 45) }}</a></div>
                            </td>
                            <td class="col-price text-center">{{ $price ? number_format($price, 2) : '-' }}</td>
                            <td class="col-purchase-cost text-center">{{ $purchaseCost ? number_format($purchaseCost, 2) : '-' }}</td>
                            <td class="col-qty text-center">{{ $qty }}</td>
                            <td class="col-total text-right">{{ $price ? number_format($subtotal, 2) : '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="empty-products">No products added</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Footer with Notes and Totals -->
            @php
                $shipping = $order->shipping_charge ?? 0;
                $service = $order->service_charge ?? 0;
                $discount = $order->discount ?? 0;
                $calculatedTotal = max(0, $itemsSubtotal + (float) $shipping + (float) $service - (float) $discount);
                $total = $order->total_amount ?? $calculatedTotal;
            @endphp
            @php $due = max(0, (float)($order->total_amount ?? 0) - (float)($order->total_paid_amount ?? 0)); @endphp

            <div class="invoice-footer">
                <div class="footer-row">
                    <div class="notes-column">
                        @if ($order->notes)
                            <div class="notes-box">
                                <div class="notes-header">Notes</div>
                                <div class="notes-content">{{ $order->notes }}</div>
                            </div>
                        @endif
                    </div>
                    <div class="totals-column">
                        <div class="totals-box">
                            <div class="total-line">
                                <div class="total-line-label">Items Subtotal</div>
                                <div class="total-line-amount">{{ number_format($itemsSubtotal, 2) }}</div>
                            </div>
                            <div class="total-line">
                                <div class="total-line-label">Shipping</div>
                                <div class="total-line-amount">{{ number_format((float) $shipping, 2) }}</div>
                            </div>
                            <div class="total-line">
                                <div class="total-line-label">Service Charge</div>
                                <div class="total-line-amount">{{ number_format((float) $service, 2) }}</div>
                            </div>
                            <div class="total-line">
                                <div class="total-line-label">Discount</div>
                                <div class="total-line-amount">-{{ number_format((float) $discount, 2) }}</div>
                            </div>
                            <div class="total-line total-final">
                                <div class="total-line-label">Total</div>
                                <div class="total-line-amount">{{ number_format((float) $total, 2) }} BDT</div>
                            </div>
                            @if ($order->total_amount)
                                <div class="total-line">
                                    <div class="total-line-label">Paid</div>
                                    <div class="total-line-amount">{{ number_format($order->total_paid_amount ?? 0, 2) }} BDT</div>
                                </div>
                                <div class="total-line">
                                    <div class="total-line-label">Due</div>
                                    <div class="total-line-amount">{{ number_format($due, 2) }} BDT</div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>

</html>
