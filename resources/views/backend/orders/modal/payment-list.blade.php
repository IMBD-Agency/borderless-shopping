<div class="modal-header" style="background: linear-gradient(135deg, var(--accent) 0%, var(--accent-deep) 100%); color: white; border: none;">
    <h1 class="modal-title fs-6 fw-bold">
        <i class="fas fa-list me-2"></i>Payments for #{{ $order->tracking_number }}
    </h1>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body" style="background-color: var(--bg); padding: 20px;">
    <div class="row g-3 mb-3">
        <div class="col-12 col-md-6">
            <div class="info-item d-flex align-items-center justify-content-between">
                <span class="fw-semibold" style="color: var(--muted);">Total Amount</span>
                <span class="fw-bold">{{ number_format($order->total_amount ?? 0, 2) }} BDT</span>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="info-item d-flex align-items-center justify-content-between">
                <span class="fw-semibold" style="color: var(--muted);">Total Paid</span>
                <span class="fw-bold">{{ number_format($order->total_paid_amount ?? 0, 2) }} BDT</span>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="info-item d-flex align-items-center justify-content-between">
                @php $due = max(0, (float)($order->total_amount ?? 0) - (float)($order->total_paid_amount ?? 0)); @endphp
                <span class="fw-semibold" style="color: var(--muted);">Due</span>
                <span class="fw-bold">{{ number_format($due, 2) }} BDT</span>
            </div>
        </div>
    </div>

    @if ($order->payments && $order->payments->count())
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Amount (BDT)</th>
                        <th>Date</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->payments as $index => $payment)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ number_format($payment->amount, 2) }}</td>
                            <td>{{ $payment->created_at->format('M d, Y H:i A') }}</td>
                            <td class="text-end">
                                <button class="btn btn-sm btn-outline-danger delete-payment" data-payment-id="{{ $payment->id }}" data-order-id="{{ $order->id }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="alert alert-light mb-0">No payments recorded for this order.</div>
    @endif
</div>
<div class="modal-footer" style="background: var(--surface); border: none; padding: 16px 20px;">
    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
        <i class="fas fa-times me-1"></i>Close
    </button>
</div>
<script>
    $(document).ready(function() {
        $('.delete-payment').click(function() {
            var paymentId = $(this).data('payment-id');

            Swal.fire({
                title: 'Delete payment?',
                text: 'This action cannot be undone.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Delete',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route('backend.orders.payments.destroy', ':pid') }}'.replace(':pid', paymentId),
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(resp) {
                            window.location.reload();
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Failed to delete payment.'
                            });
                        }
                    });
                }
            });
        });
    });
</script>
