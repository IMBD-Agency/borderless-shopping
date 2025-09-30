<div class="modal-header" style="background: linear-gradient(135deg, var(--accent) 0%, var(--accent-deep) 100%); color: white; border: none;">
    <h1 class="modal-title fs-6 fw-bold">
        <i class="fas fa-plus-circle me-2"></i>Add Payment for #{{ $order->tracking_number }}
    </h1>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body" style="background-color: var(--bg); padding: 20px;">
    <form id="addPaymentForm">
        @csrf
        <div class="row g-3">
            <div class="col-12">
                <div class="info-item d-flex align-items-center justify-content-between">
                    <span class="fw-semibold" style="color: var(--muted);">Total Amount</span>
                    <span class="fw-bold">{{ number_format($order->total_amount ?? 0, 2) }} BDT</span>
                </div>
            </div>
            <div class="col-12">
                <div class="info-item d-flex align-items-center justify-content-between">
                    <span class="fw-semibold" style="color: var(--muted);">Total Paid</span>
                    <span class="fw-bold">{{ number_format($order->total_paid_amount ?? 0, 2) }} BDT</span>
                </div>
            </div>
            <div class="col-12">
                <div class="info-item d-flex align-items-center justify-content-between">
                    @php $due = max(0, (float)($order->total_amount ?? 0) - (float)($order->total_paid_amount ?? 0)); @endphp
                    <span class="fw-semibold" style="color: var(--muted);">Due</span>
                    <span class="fw-bold">{{ number_format($due, 2) }} BDT</span>
                </div>
            </div>
            <div class="col-12">
                <label class="fw-semibold" style="color: var(--muted);">Amount (BDT)</label>
                <div class="input-group">
                    <input type="number" name="amount" class="form-control" step="0.01" min="0.01" placeholder="0.00" style="border-radius: 8px 0 0 8px;">
                    <span class="input-group-text" style="border-radius: 0 8px 8px 0; background-color: var(--accent); color: white; border: 1px solid var(--accent);">BDT</span>
                </div>
                <small class="text-muted">Do not exceed the due amount.</small>
            </div>
        </div>
    </form>
</div>
<div class="modal-footer" style="background: var(--surface); border: none; padding: 16px 20px;">
    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
        <i class="fas fa-times me-1"></i>Cancel
    </button>
    <button type="button" class="btn" id="savePaymentBtn" style="background: linear-gradient(135deg, var(--accent), var(--accent-deep)); color: white; border: none;">
        <i class="fas fa-save me-1"></i>Save Payment
    </button>
</div>

<script>
    $(document).ready(function() {
        $('#savePaymentBtn').click(function() {
            var form = $('#addPaymentForm');
            var formData = form.serialize();
            var orderId = {{ $order->id }};

            $.ajax({
                url: '{{ route('backend.orders.payments.store', ':id') }}'.replace(':id', orderId),
                type: 'POST',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        location.reload();
                    }
                },
                error: function(xhr) {
                    var message = 'Failed to add payment.';
                    if (xhr.responseJSON && xhr.responseJSON.message) message = xhr.responseJSON.message;
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: message
                    });
                }
            });
        });
    });
</script>
