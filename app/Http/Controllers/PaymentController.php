<?php

namespace App\Http\Controllers;

use App\Models\OrderRequest;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Webhook;

class PaymentController extends Controller {
    public function __construct() {
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    /**
     * Create Stripe Checkout session for order payment
     */
    public function createCheckoutSession(Request $request, $slug) {
        try {
            $order = OrderRequest::where('slug', $slug)->firstOrFail();

            // Calculate due amount
            $due = max(0, (float)($order->total_amount ?? 0) - (float)($order->total_paid_amount ?? 0));

            // Validate payment status
            if ($due <= 0) {
                return response()->json([
                    'error' => 'No payment required. Order is already fully paid.'
                ], 400);
            }

            // Check if order has a valid total amount
            if (!$order->total_amount || $order->total_amount <= 0) {
                return response()->json([
                    'error' => 'Order total amount is not set. Please contact support.'
                ], 400);
            }

            // Check for any pending payments for this order
            $pendingPayments = Payment::where('order_request_id', $order->id)
                ->where('payment_status', 'pending')
                ->count();

            if ($pendingPayments > 0) {
                return response()->json([
                    'error' => 'A payment is already in progress for this order. Please wait for it to complete.'
                ], 400);
            }

            // Create Stripe Checkout session without creating payment record yet
            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'bdt',
                        'product_data' => [
                            'name' => "Payment for Order #{$order->tracking_number}",
                            'description' => "Outstanding payment for order tracking number: {$order->tracking_number}",
                        ],
                        'unit_amount' => round($due * 100), // Convert to cents
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => route('payment.success') . '?session_id={CHECKOUT_SESSION_ID}&order_slug=' . $order->slug,
                'cancel_url' => route('payment.cancel') . '?order_slug=' . $order->slug,
                'metadata' => [
                    'order_id' => $order->id,
                    'order_slug' => $order->slug,
                    'tracking_number' => $order->tracking_number,
                    'due_amount' => $due,
                ],
                'customer_email' => $order->user?->email,
            ]);

            return response()->json([
                'checkout_url' => $session->url
            ]);
        } catch (\Exception $e) {
            Log::error('Stripe Checkout Session Creation Failed: ' . $e->getMessage());
            dd($e->getMessage());
            return response()->json([
                'error' => 'Failed to create payment session. Please try again.'
            ], 500);
        }
    }

    /**
     * Handle successful payment
     */
    public function handleSuccess(Request $request) {
        try {
            $sessionId = $request->get('session_id');
            $orderSlug = $request->get('order_slug');

            if (!$sessionId || !$orderSlug) {
                return redirect()->route('frontend.index')
                    ->with('error', 'Invalid payment session.');
            }

            // Get order from slug
            $order = OrderRequest::where('slug', $orderSlug)->firstOrFail();

            // Verify the session with Stripe
            $session = Session::retrieve($sessionId);

            // Validate payment status from Stripe
            if ($session->payment_status === 'paid') {
                // Calculate due amount again to ensure accuracy
                $due = max(0, (float)($order->total_amount ?? 0) - (float)($order->total_paid_amount ?? 0));

                // Only create payment record if there's still a due amount
                if ($due > 0) {
                    // Check if payment record already exists for this session (prevent duplicates)
                    $existingPayment = Payment::where('transaction_id', $session->id)->first();

                    if ($existingPayment) {
                        return redirect()->route('frontend.order-request.invoice', $order->slug)
                            ->with('info', 'Payment has already been processed.');
                    }

                    // Create payment record only now that payment is confirmed
                    $payment = Payment::create([
                        'order_request_id' => $order->id,
                        'amount' => $due,
                        'payment_method' => 'stripe',
                        'payment_status' => 'completed',
                        'transaction_id' => $session->id,
                        'metadata' => [
                            'order_tracking_number' => $order->tracking_number,
                            'customer_name' => $order->recipient_name,
                            'customer_email' => $order->user?->email,
                            'stripe_session_id' => $session->id,
                            'stripe_payment_intent_id' => $session->payment_intent,
                            'completed_at' => now()->toISOString()
                        ]
                    ]);

                    // Update order payment status
                    $this->updateOrderPaymentStatus($order);

                    // Add timeline entry
                    $order->addTimelineEntry(
                        'payment_received',
                        "Payment of {$payment->amount} BDT received via Stripe.",
                        'system',
                        $order->user_id
                    );

                    return redirect()->route('frontend.order-request.invoice', $order->slug)
                        ->with('success', 'Payment completed successfully!');
                } else {
                    return redirect()->route('frontend.order-request.invoice', $order->slug)
                        ->with('info', 'Order is already fully paid.');
                }
            } else {
                // Log failed payment attempt
                Log::warning('Payment failed or incomplete', [
                    'session_id' => $sessionId,
                    'order_id' => $order->id,
                    'stripe_payment_status' => $session->payment_status,
                    'session_status' => $session->status
                ]);
            }

            return redirect()->route('frontend.order-request.invoice', $order->slug)
                ->with('error', 'Payment was not completed. Please try again.');
        } catch (\Exception $e) {
            Log::error('Payment Success Handler Failed: ' . $e->getMessage());
            return redirect()->route('frontend.index')
                ->with('error', 'Payment verification failed. Please contact support.');
        }
    }

    /**
     * Handle cancelled payment
     */
    public function handleCancel(Request $request) {
        $orderSlug = $request->get('order_slug');

        if ($orderSlug) {
            $order = OrderRequest::where('slug', $orderSlug)->first();
            if ($order) {
                return redirect()->route('frontend.order-request.invoice', $order->slug)
                    ->with('error', 'Payment was cancelled. You can try again anytime.');
            }
        }

        return redirect()->route('frontend.index')
            ->with('error', 'Payment was cancelled.');
    }

    /**
     * Handle Stripe webhooks
     */
    public function webhook(Request $request) {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $endpointSecret = config('services.stripe.webhook_secret');

        try {
            $event = Webhook::constructEvent($payload, $sigHeader, $endpointSecret);
        } catch (SignatureVerificationException $e) {
            Log::error('Stripe webhook signature verification failed: ' . $e->getMessage());
            return response('Invalid signature', 400);
        }

        // Handle the event
        switch ($event->type) {
            case 'checkout.session.completed':
                $session = $event->data->object;
                $this->handleCheckoutSessionCompleted($session);
                break;

            case 'payment_intent.succeeded':
                $paymentIntent = $event->data->object;
                $this->handlePaymentIntentSucceeded($paymentIntent);
                break;

            case 'payment_intent.payment_failed':
                $paymentIntent = $event->data->object;
                $this->handlePaymentIntentFailed($paymentIntent);
                break;

            default:
                Log::info('Unhandled Stripe webhook event: ' . $event->type);
        }

        return response('OK', 200);
    }

    /**
     * Handle checkout session completed webhook
     */
    private function handleCheckoutSessionCompleted($session) {
        try {
            $orderId = $session->metadata->order_id ?? null;
            $orderSlug = $session->metadata->order_slug ?? null;

            if ($orderId && $orderSlug) {
                $order = OrderRequest::find($orderId);
                if ($order) {
                    // Calculate due amount
                    $due = max(0, (float)($order->total_amount ?? 0) - (float)($order->total_paid_amount ?? 0));

                    // Only create payment record if there's still a due amount
                    if ($due > 0) {
                        // Check if payment record already exists for this session
                        $existingPayment = Payment::where('transaction_id', $session->id)->first();

                        if (!$existingPayment) {
                            // Create payment record
                            $payment = Payment::create([
                                'order_request_id' => $order->id,
                                'amount' => $due,
                                'payment_method' => 'stripe',
                                'payment_status' => 'completed',
                                'transaction_id' => $session->id,
                                'metadata' => [
                                    'order_tracking_number' => $order->tracking_number,
                                    'customer_name' => $order->recipient_name,
                                    'customer_email' => $order->user?->email,
                                    'stripe_session_id' => $session->id,
                                    'stripe_payment_intent_id' => $session->payment_intent,
                                    'webhook_processed_at' => now()->toISOString()
                                ]
                            ]);

                            // Update order payment status
                            $this->updateOrderPaymentStatus($order);

                            // Add timeline entry
                            $order->addTimelineEntry(
                                'payment_received',
                                "Payment of {$payment->amount} BDT received via Stripe.",
                                'system',
                                $order->user_id
                            );
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            Log::error('Checkout session completed webhook failed: ' . $e->getMessage());
        }
    }

    /**
     * Handle payment intent succeeded webhook
     */
    private function handlePaymentIntentSucceeded($paymentIntent) {
        try {
            // Find payment by payment intent ID
            $payment = Payment::where('metadata->stripe_payment_intent_id', $paymentIntent->id)->first();

            if ($payment && $payment->payment_status === 'completed') {
                // Update metadata to include payment intent success timestamp
                $payment->update([
                    'metadata' => array_merge($payment->metadata ?? [], [
                        'payment_intent_succeeded_at' => now()->toISOString()
                    ])
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Payment intent succeeded webhook failed: ' . $e->getMessage());
        }
    }

    /**
     * Handle payment intent failed webhook
     */
    private function handlePaymentIntentFailed($paymentIntent) {
        try {
            // Find payment by payment intent ID
            $payment = Payment::where('metadata->stripe_payment_intent_id', $paymentIntent->id)->first();

            if ($payment) {
                $payment->update([
                    'payment_status' => 'failed',
                    'metadata' => array_merge($payment->metadata ?? [], [
                        'payment_intent_failed_at' => now()->toISOString(),
                        'failure_reason' => $paymentIntent->last_payment_error->message ?? 'Unknown error'
                    ])
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Payment intent failed webhook failed: ' . $e->getMessage());
        }
    }

    /**
     * Update order payment status based on total payments
     */
    private function updateOrderPaymentStatus($order) {
        try {
            $totalAmount = (float)($order->total_amount ?? 0);
            $totalPaid = (float)$order->payments()->where('payment_status', 'completed')->sum('amount');
            $due = max(0, $totalAmount - $totalPaid);

            // Update payment status based on due amount
            if ($totalAmount <= 0) {
                $order->payment_status = 'pending';
            } elseif ($due <= 0.01) { // Allow for small rounding differences
                $order->payment_status = 'paid';
            } elseif ($totalPaid > 0) {
                $order->payment_status = 'partially';
            } else {
                $order->payment_status = 'pending';
            }

            $order->save();

            Log::info('Order payment status updated', [
                'order_id' => $order->id,
                'tracking_number' => $order->tracking_number,
                'total_amount' => $totalAmount,
                'total_paid' => $totalPaid,
                'due' => $due,
                'payment_status' => $order->payment_status
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to update order payment status: ' . $e->getMessage(), [
                'order_id' => $order->id ?? null
            ]);
        }
    }
}
