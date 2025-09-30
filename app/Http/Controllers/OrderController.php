<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest as OrderRequestValidation;
use App\Models\OrderRequest;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\InvoiceMail;

class OrderController extends Controller {
    public function index(Request $request) {
        $query = OrderRequest::with('user')->latest();

        // Filter by order status
        if ($request->filled('order_status')) {
            $query->where('status', $request->order_status);
        }

        // Filter by payment status
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        // Search functionality
        if ($request->filled('search_term') && $request->filled('search_type')) {
            $searchTerm = $request->search_term;
            $searchType = $request->search_type;

            switch ($searchType) {
                case 'name':
                    $query->where('recipient_name', 'like', "%{$searchTerm}%");
                    break;
                case 'email':
                    $query->whereHas('user', function ($q) use ($searchTerm) {
                        $q->where('email', 'like', "%{$searchTerm}%");
                    });
                    break;
                case 'mobile':
                    $query->where('recipient_mobile', 'like', "%{$searchTerm}%");
                    break;
                case 'tracking':
                    $query->where('tracking_number', 'like', "%{$searchTerm}%");
                    break;
            }
        }

        $this->orders = $query->get();

        // Store filter values for form persistence
        $this->filters = [
            'order_status' => $request->order_status,
            'payment_status' => $request->payment_status,
            'search_term' => $request->search_term,
            'search_type' => $request->search_type,
        ];

        return view('backend.orders.index', $this->data);
    }

    public function show($id) {
        $order = OrderRequest::with(['user', 'products'])->findOrFail($id);
        return view('backend.orders.modal.show', compact('order'));
    }

    public function edit($id) {
        $order = OrderRequest::with('user')->findOrFail($id);
        return view('backend.orders.modal.edit', compact('order'));
    }

    public function update(OrderRequestValidation $request, $id) {
        $order = OrderRequest::with('products')->findOrFail($id);

        DB::transaction(function () use ($request, $order) {
            // Update order fields (tracking_number remains unchanged)
            $order->update([
                'recipient_name' => $request->recipient_name,
                'recipient_mobile' => $request->recipient_mobile,
                'recipient_address' => $request->recipient_address,
                'notes' => $request->notes,
                'status' => $request->status,
                'shipping_charge' => $request->shipping_charge,
                'service_charge' => $request->service_charge,
                'discount' => $request->discount,
                'total_amount' => $request->total_amount,
            ]);

            // Sync products: clear and recreate from arrays
            $order->products()->delete();

            $urls = $request->input('product_urls', []);
            $names = $request->input('product_names', []);
            $prices = $request->input('product_prices', []);
            $quantities = $request->input('product_quantities', []);
            $purchases = $request->input('purchase_costs', []);

            $count = count($urls);
            for ($i = 0; $i < $count; $i++) {
                $url = $urls[$i] ?? null;
                if (!$url) continue;
                $order->products()->create([
                    'product_url' => $url,
                    'product_name' => $names[$i] ?? null,
                    'product_price' => isset($prices[$i]) && $prices[$i] !== '' ? (float)$prices[$i] : null,
                    'product_quantity' => isset($quantities[$i]) && $quantities[$i] !== '' ? (int)$quantities[$i] : 1,
                    'purchase_cost' => isset($purchases[$i]) && $purchases[$i] !== '' ? (float)$purchases[$i] : null,
                ]);
            }

            // Recalculate payment status if total amount changed
            $totalAmount = (float) ($order->total_amount ?? 0);
            $paid = (float) $order->payments()->sum('amount');
            $due = max(0.0, $totalAmount - $paid);

            if ($order->total_amount === null || abs($due - $totalAmount) < 1e-6) {
                // No total set or full due remaining
                $order->payment_status = 'pending';
            } elseif ($due > 1e-6) {
                $order->payment_status = 'partially';
            } else {
                $order->payment_status = 'paid';
            }
            $order->save();
        });

        session()->flash('success', 'Order updated successfully!');
        return response()->json([
            'success' => true,
            'message' => 'Order updated successfully!'
        ]);
    }

    public function updateStatus(Request $request, $id) {
        $order = OrderRequest::findOrFail($id);

        $request->validate([
            'status' => 'required|in:order_received,order_confirmed,order_processed,order_shipped,order_delivered,order_returned,order_cancelled'
        ]);

        $oldStatus = $order->status;
        $newStatus = $request->status;

        $order->update([
            'status' => $newStatus
        ]);

        // Add timeline entry for status change
        $descriptions = [
            'order_received' => 'Your order has been received and is being processed.',
            'order_confirmed' => 'Your order has been confirmed and is ready for processing.',
            'order_processed' => 'Your order is being prepared for shipping.',
            'order_shipped' => 'Your order has been shipped and is on its way.',
            'order_delivered' => 'Your order has been successfully delivered.',
            'order_returned' => 'Your order has been returned.',
            'order_cancelled' => 'Your order has been cancelled.'
        ];

        $order->addTimelineEntry(
            $newStatus,
            $descriptions[$newStatus] ?? 'Order status updated',
            'admin',
            auth()->id()
        );

        return response()->json([
            'success' => true,
            'message' => 'Order status updated successfully!'
        ]);
    }

    public function createPayment($id) {
        $order = OrderRequest::with('payments')->findOrFail($id);
        if ($order->total_amount === null) {
            return response('<div class="p-4">Total amount not set for this order.</div>', 400);
        }
        return view('backend.orders.modal.payment-create', compact('order'));
    }

    public function storePayment(Request $request, $id) {
        $order = OrderRequest::with('payments')->findOrFail($id);
        if ($order->total_amount === null) {
            return response()->json(['success' => false, 'message' => 'Total amount not set.'], 422);
        }

        $validated = $request->validate([
            'amount' => 'required|numeric|min:0.01'
        ]);

        DB::transaction(function () use ($order, $validated) {
            $totalAmount = (float) ($order->total_amount ?? 0);
            $alreadyPaid = (float) $order->payments()->sum('amount');
            $currentDue = max(0.0, $totalAmount - $alreadyPaid);

            $incoming = (float) $validated['amount'];
            if ($incoming > $currentDue + 1e-6) {
                abort(response()->json([
                    'success' => false,
                    'message' => 'Payment amount cannot be greater than the due amount.'
                ], 422));
            }

            Payment::create([
                'order_request_id' => $order->id,
                'amount' => $incoming,
            ]);

            // Recompute after insert
            $newPaid = (float) $order->payments()->sum('amount');
            $newDue = max(0.0, $totalAmount - $newPaid);

            if (abs($newDue - $totalAmount) < 1e-6) {
                // No payment yet, full due
                $order->payment_status = 'pending';
            } elseif ($newDue > 1e-6) {
                // Some due remains after payments
                $order->payment_status = 'partially';
            } else {
                // No due left
                $order->payment_status = 'paid';
            }
            $order->save();
        });

        return response()->json(['success' => true, 'message' => 'Payment added successfully.']);
    }

    public function listPayments($id) {
        $order = OrderRequest::with('payments')->findOrFail($id);
        return view('backend.orders.modal.payment-list', compact('order'));
    }

    public function destroyPayment($paymentId) {
        $payment = Payment::findOrFail($paymentId);
        $order = OrderRequest::findOrFail($payment->order_request_id);

        DB::transaction(function () use ($payment, $order) {
            $payment->delete();

            $totalAmount = (float) ($order->total_amount ?? 0);
            $newPaid = (float) $order->payments()->sum('amount');
            $newDue = max(0.0, $totalAmount - $newPaid);

            if (abs($newDue - $totalAmount) < 1e-6) {
                $order->payment_status = 'pending';
            } elseif ($newDue > 1e-6) {
                $order->payment_status = 'partially';
            } else {
                $order->payment_status = 'paid';
            }
            $order->save();
        });

        return response()->json(['success' => true]);
    }

    public function sendInvoice(Request $request, $id) {
        $order = OrderRequest::with(['user', 'products'])->findOrFail($id);
        $request->validate(['email' => 'nullable|email']);
        $recipientEmail = $request->input('email') ?: ($order->user?->email);
        if (!$recipientEmail) {
            return response()->json(['success' => false, 'message' => 'No recipient email found for this order.'], 422);
        }
        Mail::to($recipientEmail)->send(new InvoiceMail($order));
        return response()->json(['success' => true, 'message' => 'Invoice sent successfully.']);
    }
}
