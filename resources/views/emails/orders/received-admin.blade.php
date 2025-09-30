<!DOCTYPE html>
<html>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>New Order Received</title>
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
                max-width: 600px;
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
                font-size: 24px;
            }

            .content {
                padding: 24px;
                color: #212529;
            }

            .lead {
                font-size: 16px;
                margin: 0 0 12px;
            }

            .muted {
                color: #6c757d;
            }

            .summary {
                background: #f8f9fa;
                border-radius: 6px;
                padding: 16px;
                margin: 16px 0;
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

            .footer {
                color: #6c757d;
                font-size: 12px;
                text-align: center;
                padding: 16px;
            }

            @media only screen and (max-width: 600px) {
                .row {
                    flex-direction: column;
                    gap: 4px;
                }
            }
        </style>
    </head>

    <body>
        <div class="wrapper">
            <div class="container">
                <div class="header">
                    <h1>New Order Received</h1>
                </div>
                <div class="content">
                    <p class="lead">A new order has been placed.</p>
                    <div class="summary">
                        <div class="row"><span class="label">Tracking Number</span><span class="value">{{ $order->tracking_number }}</span></div>
                        <div class="row"><span class="label">Placed On</span><span class="value">{{ $order->created_at->format('M d, Y h:i A') }}</span></div>
                        <div class="row"><span class="label">Customer</span><span class="value">{{ $order->recipient_name }}</span></div>
                        <div class="row"><span class="label">Mobile</span><span class="value">{{ $order->recipient_mobile }}</span></div>
                        <div class="row"><span class="label">Address</span><span class="value">{{ $order->recipient_address }}</span></div>
                    </div>
                </div>
                <div class="footer">
                    &copy; {{ date('Y') }} {{ config('app.name') }}. Internal notification.
                </div>
            </div>
        </div>
    </body>

</html>
