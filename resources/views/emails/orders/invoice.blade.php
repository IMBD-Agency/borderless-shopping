<!DOCTYPE html>
<html>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Invoice</title>
        <style>
            body {
                margin: 0;
                padding: 0;
                background: #f6f6f6;
                font-family: Arial, Helvetica, sans-serif;
            }

            .wrapper {
                width: 100%;
                background: #f6f6f6;
                padding: 24px 0;
            }

            .container {
                width: 100%;
                max-width: 700px;
                margin: 0 auto;
                background: #ffffff;
                border-radius: 8px;
                overflow: hidden;
            }

            .header {
                background: #ec1d25;
                color: #ffffff;
                padding: 20px;
            }

            .header h1 {
                margin: 0;
                font-size: 22px;
                text-align: center;
            }

            .content {
                padding: 20px;
                color: #212529;
            }

            .section {
                margin-top: 16px;
            }

            .section-title {
                font-weight: bold;
                color: #ec1d25;
                margin: 0 0 8px;
            }

            .summary {
                background: #f8f9fa;
                border-radius: 6px;
                padding: 12px;
            }

            .row {
                display: flex;
                justify-content: space-between;
                margin: 6px 0;
                font-size: 14px;
            }

            .row .label {
                color: #6c757d;
            }

            .row .value {
                font-weight: bold;
                color: #212529;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                font-size: 13px;
            }

            th,
            td {
                padding: 10px;
                border-bottom: 1px solid #eee;
                text-align: left;
            }

            thead th {
                background: #f8f9fa;
                color: #212529;
            }

            tfoot td {
                font-weight: bold;
            }

            .cta {
                text-align: center;
                margin-top: 16px;
            }

            .btn {
                display: inline-block;
                padding: 10px 16px;
                background: #ec1d25;
                color: #ffffff !important;
                text-decoration: none;
                border-radius: 6px;
            }

            .muted {
                color: #6c757d;
            }

            @media only screen and (max-width: 600px) {
                .row {
                    flex-direction: column;
                    gap: 4px;
                }

                th,
                td {
                    padding: 8px;
                }
            }
        </style>
    </head>

    <body>
        <div class="wrapper">
            <div class="container">
                <div class="header">
                    <h1>Invoice for Order #{{ $order->tracking_number }}</h1>
                </div>
                <div class="content">
                    <div class="section">
                        <div class="section-title">Order Details</div>
                        <div class="summary">
                            <div class="row"><span class="label">Tracking Number</span><span class="value">{{ $order->tracking_number }}</span></div>
                            <div class="row"><span class="label">Placed On</span><span class="value">{{ $order->created_at->format('M d, Y h:i A') }}</span></div>
                            <div class="row"><span class="label">Customer</span><span class="value">{{ $order->recipient_name }}</span></div>
                            <div class="row"><span class="label">Mobile</span><span class="value">{{ $order->recipient_mobile }}</span></div>
                            <div class="row"><span class="label">Address</span><span class="value">{{ $order->recipient_address }}</span></div>
                            <div class="row"><span class="label">Order Status</span><span class="value">{{ ucwords(str_replace('_', ' ', $order->status)) }}</span></div>
                            <div class="row"><span class="label">Payment Status</span><span class="value">{{ ucfirst($order->payment_status) }}</span></div>
                        </div>
                    </div>

                    <div class="section">
                        <div class="section-title">Products</div>
                        <div class="table-responsive">
                            <table role="presentation" cellspacing="0" cellpadding="0">
                                <thead>
                                    <tr>
                                        <th align="left">Product</th>
                                        <th align="center">Price (BDT)</th>
                                        <th align="center">Purchase Cost (BDT)</th>
                                        <th align="center">Qty</th>
                                        <th align="right">Subtotal (BDT)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $itemsSubtotal = 0; @endphp
                                    @foreach ($order->products as $product)
                                        @php
                                            $price = $product->product_price ?? 0;
                                            $purchase = $product->purchase_cost ?? 0;
                                            $qty = $product->product_quantity ?? 1;
                                            $subtotal = $price * $qty + $purchase;
                                            $itemsSubtotal += $subtotal;
                                        @endphp
                                        <tr>
                                            <td>{{ $product->product_name ?? 'Product' }}</td>
                                            <td align="center">{{ $price ? number_format($price, 2) : '-' }}</td>
                                            <td align="center">{{ $purchase ? number_format($purchase, 2) : '-' }}</td>
                                            <td align="center">{{ $qty }}</td>
                                            <td align="right">{{ number_format($subtotal, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    @php
                        $shipping = $order->shipping_charge ?? 0;
                        $service = $order->service_charge ?? 0;
                        $discount = $order->discount ?? 0;
                        $calculatedTotal = max(0, $itemsSubtotal + (float) $shipping + (float) $service - (float) $discount);
                        $total = $order->total_amount ?? $calculatedTotal;
                        $paid = $order->total_paid_amount ?? 0;
                        $due = max(0, (float) ($total ?? 0) - (float) $paid);
                    @endphp

                    <div class="section">
                        <div class="section-title">Totals</div>
                        <div class="summary">
                            <div class="row"><span class="label">Items Subtotal</span><span class="value">{{ number_format($itemsSubtotal, 2) }} BDT</span></div>
                            <div class="row"><span class="label">Shipping</span><span class="value">{{ number_format((float) $shipping, 2) }} BDT</span></div>
                            <div class="row"><span class="label">Service Charge</span><span class="value">{{ number_format((float) $service, 2) }} BDT</span></div>
                            <div class="row"><span class="label">Discount</span><span class="value">-{{ number_format((float) $discount, 2) }} BDT</span></div>
                            <div class="row"><span class="label">Total</span><span class="value">{{ number_format((float) $total, 2) }} BDT</span></div>
                            <div class="row"><span class="label">Paid</span><span class="value">{{ number_format((float) $paid, 2) }} BDT</span></div>
                            <div class="row"><span class="label">Due</span><span class="value">{{ number_format((float) $due, 2) }} BDT</span></div>
                        </div>
                        <div class="cta">
                            <a class="btn" href="{{ route('frontend.order-request.invoice', $order->slug) }}" target="_blank">View Invoice</a>
                        </div>
                    </div>
                </div>
                <div class="footer" style="text-align:center; color:#6c757d; font-size:12px; padding:16px;">
                    &copy; {{ date('Y') }} {{ config('app.name') }}
                </div>
            </div>
        </div>
    </body>

</html>
