<div class="modal-header" style="background: linear-gradient(135deg, var(--accent) 0%, var(--accent-deep) 100%); color: white; border: none;">
    <h1 class="modal-title fs-5 fw-bold">
        <i class="fas fa-edit me-2"></i>Edit Order #{{ $order->tracking_number }}
    </h1>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body" style="background-color: var(--bg); padding: 30px;">
    <form id="editOrderForm">
        @csrf
        @method('PUT')
        <div class="row g-4">
            <!-- Order Status Card -->
            <div class="col-12">
                <div class="info-card" style="background: var(--surface); border-radius: 16px; padding: 25px; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
                    <div class="d-flex align-items-center mb-4">
                        <div class="icon-wrapper me-3" style="width: 40px; height: 40px; background: linear-gradient(135deg, var(--accent), var(--accent-soft)); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-flag text-white"></i>
                        </div>
                        <h6 class="mb-0 fw-bold" style="color: var(--text);">Order Status & Tracking</h6>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="info-item d-flex align-items-center gap-2">
                                <label class="fw-semibold" style="color: var(--muted); min-width: 120px;">Status:</label>
                                <select name="status" class="form-select" style="border-radius: 8px;">
                                    <option value="order_received" {{ $order->status == 'order_received' ? 'selected' : '' }}>Order Received</option>
                                    <option value="order_confirmed" {{ $order->status == 'order_confirmed' ? 'selected' : '' }}>Order Confirmed</option>
                                    <option value="order_processed" {{ $order->status == 'order_processed' ? 'selected' : '' }}>Order Processed</option>
                                    <option value="order_shipped" {{ $order->status == 'order_shipped' ? 'selected' : '' }}>Order Shipped</option>
                                    <option value="order_delivered" {{ $order->status == 'order_delivered' ? 'selected' : '' }}>Order Delivered</option>
                                    <option value="order_returned" {{ $order->status == 'order_returned' ? 'selected' : '' }}>Order Returned</option>
                                    <option value="order_cancelled" {{ $order->status == 'order_cancelled' ? 'selected' : '' }}>Order Cancelled</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item d-flex align-items-center gap-2">
                                <label class="fw-semibold" style="color: var(--muted); min-width: 120px;">Tracking #:</label>
                                <input type="text" class="form-control" value="{{ $order->tracking_number }}" style="border-radius: 8px;" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Information Card (Multi-product) -->
            <div class="col-12">
                <div class="info-card" style="background: var(--surface); border-radius: 16px; padding: 25px; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-wrapper me-3" style="width: 40px; height: 40px; background: linear-gradient(135deg, var(--accent), var(--accent-soft)); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-boxes-stacked text-white"></i>
                        </div>
                        <h6 class="mb-0 fw-bold" style="color: var(--text);">Products</h6>
                        <button type="button" class="btn btn-sm ms-auto" style="background: var(--accent); color: #fff; border-radius: 8px;" onclick="addProductRow()">
                            <i class="fas fa-plus me-1"></i> Add Product
                        </button>
                    </div>
                    <div id="productsList">
                        @php $rowIndex = 0; @endphp
                        @if ($order->products && $order->products->count())
                            @foreach ($order->products as $p)
                                <div class="product-group p-3 mb-3" style="background: var(--surface); border: 1px solid var(--border, #eee); border-radius: 12px;">
                                    <div class="d-flex align-items-center mb-2">
                                        <span class="badge bg-secondary me-2" style="min-width: 32px;">#<span class="row-index">{{ ++$rowIndex }}</span></span>
                                        <button type="button" class="btn btn-sm btn-outline-danger ms-auto" onclick="removeProductGroup(this)"><i class="fas fa-trash me-1"></i>Remove</button>
                                    </div>
                                    <div class="row g-3 align-items-end">
                                        <div class="col-12 col-md-8">
                                            <label class="fw-semibold" style="color: var(--muted);"><a class="text-muted" href="{{ $p->product_url }}" target="_blank">Product URL <i class="text-accent fas fa-external-link-alt"></i></a></label>
                                            <input type="url" name="product_urls[]" class="form-control product-url" value="{{ $p->product_url }}" placeholder="https://..." style="border-radius: 10px;">
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <label class="fw-semibold" style="color: var(--muted);">Product Name</label>
                                            <input type="text" name="product_names[]" class="form-control product-name" value="{{ $p->product_name }}" placeholder="Optional name" style="border-radius: 10px;">
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <label class="fw-semibold" style="color: var(--muted);">Price (BDT)</label>
                                            <input type="number" step="0.01" name="product_prices[]" class="form-control text-center product-price" value="{{ $p->product_price }}" placeholder="0.00" style="border-radius: 10px;">
                                        </div>
                                        <div class="col-12 col-md-3">
                                            <label class="fw-semibold" style="color: var(--muted);">Qty</label>
                                            <input type="number" min="1" name="product_quantities[]" class="form-control text-center product-qty" value="{{ $p->product_quantity }}" placeholder="1" style="border-radius: 10px;">
                                        </div>
                                        <div class="col-12 col-md-3">
                                            <label class="fw-semibold" style="color: var(--muted);">Purchase Cost (BDT)</label>
                                            <input type="number" step="0.01" name="purchase_costs[]" class="form-control text-center purchase-cost" value="{{ $p->purchase_cost }}" placeholder="0.00" style="border-radius: 10px;">
                                        </div>
                                        <div class="col-12 col-md-2 text-md-end">
                                            <label class="fw-semibold d-block" style="color: var(--muted);">Subtotal</label>
                                            <div class="h5 mb-0 subtotal-cell">{{ number_format(($p->product_price ?? 0) * ($p->product_quantity ?? 0) + ($p->purchase_cost ?? 0), 2) }}</div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="product-group p-3 mb-3" style="background: var(--surface); border: 1px solid var(--border, #eee); border-radius: 12px;">
                                <div class="d-flex align-items-center mb-2">
                                    <span class="badge bg-secondary me-2" style="min-width: 32px;">#<span class="row-index">1</span></span>
                                    <button type="button" class="btn btn-sm btn-outline-danger ms-auto" onclick="removeProductGroup(this)"><i class="fas fa-trash me-1"></i>Remove</button>
                                </div>
                                <div class="row g-3 align-items-end">
                                    <div class="col-12 col-md-8">
                                        <label class="fw-semibold" style="color: var(--muted);">Product URL</label>
                                        <input type="url" name="product_urls[]" class="form-control product-url" placeholder="https://..." style="border-radius: 10px;">
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <label class="fw-semibold" style="color: var(--muted);">Product Name</label>
                                        <input type="text" name="product_names[]" class="form-control product-name" placeholder="Optional name" style="border-radius: 10px;">
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <label class="fw-semibold" style="color: var(--muted);">Price (BDT)</label>
                                        <input type="number" step="0.01" name="product_prices[]" class="form-control text-center product-price" placeholder="0.00" style="border-radius: 10px;">
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <label class="fw-semibold" style="color: var(--muted);">Qty</label>
                                        <input type="number" min="1" name="product_quantities[]" class="form-control text-center product-qty" value="1" style="border-radius: 10px;">
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <label class="fw-semibold" style="color: var(--muted);">Purchase Cost (BDT)</label>
                                        <input type="number" step="0.01" name="purchase_costs[]" class="form-control text-center purchase-cost" placeholder="0.00" style="border-radius: 10px;">
                                    </div>
                                    <div class="col-12 col-md-2 text-md-end">
                                        <label class="fw-semibold d-block" style="color: var(--muted);">Subtotal</label>
                                        <div class="h5 mb-0 subtotal-cell">0.00</div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="d-flex justify-content-end mt-3">
                        <div class="h6 mb-0">Products Total: <span id="productsTotalCell">0.00</span> BDT</div>
                    </div>
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
                                <label class="fw-semibold" style="color: var(--muted); min-width: 120px;">Name:</label>
                                <input type="text" name="recipient_name" class="form-control" value="{{ $order->recipient_name }}" style="border-radius: 8px;" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item d-flex align-items-center gap-2">
                                <label class="fw-semibold" style="color: var(--muted); min-width: 120px;">Mobile:</label>
                                <input type="text" name="recipient_mobile" class="form-control" value="{{ $order->recipient_mobile }}" style="border-radius: 8px;" required>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="info-item d-flex align-items-start gap-2">
                                <label class="fw-semibold" style="color: var(--muted); min-width: 120px;">Address:</label>
                                <textarea name="recipient_address" class="form-control" rows="3" style="border-radius: 8px;" required>{{ $order->recipient_address }}</textarea>
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
                        <div class="col-12">
                            <div class="info-item d-flex align-items-start gap-2">
                                <label class="fw-semibold" style="color: var(--muted); min-width: 120px;">Notes:</label>
                                <textarea name="notes" class="form-control" rows="3" style="border-radius: 8px;" placeholder="Enter any additional notes">{{ $order->notes }}</textarea>
                            </div>
                        </div>
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
                            <div class="form-group">
                                <label class="fw-semibold" style="color: var(--muted);">Discount</label>
                                <div class="input-group">
                                    <input type="number" name="discount" class="form-control" value="{{ $order->discount }}" step="0.01" style="border-radius: 8px 0 0 8px;" placeholder="0.00">
                                    <span class="input-group-text" style="border-radius: 0 8px 8px 0; background-color: var(--accent); color: white; border: 1px solid var(--accent);">BDT</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="fw-semibold" style="color: var(--muted);">Shipping Charge</label>
                                <div class="input-group">
                                    <input type="number" name="shipping_charge" class="form-control" value="{{ $order->shipping_charge }}" step="0.01" style="border-radius: 8px 0 0 8px;" placeholder="0.00">
                                    <span class="input-group-text" style="border-radius: 0 8px 8px 0; background-color: var(--accent); color: white; border: 1px solid var(--accent);">BDT</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="fw-semibold" style="color: var(--muted);">Service Charge</label>
                                <div class="input-group">
                                    <input type="number" name="service_charge" class="form-control" value="{{ $order->service_charge }}" step="0.01" style="border-radius: 8px 0 0 8px;" placeholder="0.00">
                                    <span class="input-group-text" style="border-radius: 0 8px 8px 0; background-color: var(--accent); color: white; border: 1px solid var(--accent);">BDT</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="total-amount-section" style="background: linear-gradient(135deg, var(--accent-soft), var(--accent)); border-radius: 12px; padding: 20px; margin-top: 15px;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0 fw-bold text-white">Total Amount</h6>
                                    <div class="d-flex align-items-center">
                                        <h4 class="mb-0 fw-bold text-white me-2" id="calculatedTotal">{{ $order->total_amount !== null ? number_format($order->total_amount, 2) : '0.00' }}</h4>
                                        <span class="text-white fw-bold">BDT</span>
                                    </div>
                                </div>
                                <input type="hidden" name="total_amount" id="totalAmountInput" value="{{ $order->total_amount }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<div class="modal-footer" style="background: var(--surface); border: none; padding: 20px 30px;">
    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" style="border-radius: 12px; padding: 10px 20px;">
        <i class="fas fa-times me-2"></i>Cancel
    </button>
    <button type="button" class="btn" id="updateOrderBtn" style="background: linear-gradient(135deg, var(--accent), var(--accent-deep)); color: white; border: none; border-radius: 12px; padding: 10px 20px;">
        <i class="fas fa-save me-2"></i>Update Order
    </button>
</div>

<script>
    function renumberRows() {
        var index = 0;
        $('#productsList .product-group').each(function() {
            $(this).find('.row-index').text(++index);
        });
    }

    function updateRowSubtotal(group) {
        var price = parseFloat($(group).find('.product-price').val()) || 0;
        var purchase = parseFloat($(group).find('.purchase-cost').val()) || 0;
        var qty = parseInt($(group).find('.product-qty').val()) || 0;
        var subtotal = (price * qty) + purchase;
        $(group).find('.subtotal-cell').text(subtotal.toFixed(2));
    }

    function recalcProductsTotal() {
        var total = 0;
        $('#productsList .product-group').each(function() {
            var price = parseFloat($(this).find('.product-price').val()) || 0;
            var purchase = parseFloat($(this).find('.purchase-cost').val()) || 0;
            var qty = parseInt($(this).find('.product-qty').val()) || 0;
            total += (price * qty) + purchase;
        });
        $('#productsTotalCell').text(total.toFixed(2));
        return total;
    }

    function calculateTotal() {
        var productsTotal = recalcProductsTotal();
        var shippingCharge = parseFloat($('input[name="shipping_charge"]').val()) || 0;
        var serviceCharge = parseFloat($('input[name="service_charge"]').val()) || 0;
        var discount = parseFloat($('input[name="discount"]').val()) || 0;

        var total = Math.max(0, productsTotal + shippingCharge + serviceCharge - discount);
        $('#calculatedTotal').text(total.toFixed(2));
        $('#totalAmountInput').val(total.toFixed(2));
    }

    function addProductRow() {
        var group = $(
            '<div class="product-group p-3 mb-3" style="background: var(--surface); border: 1px solid var(--border, #eee); border-radius: 12px;">' +
            '<div class="d-flex align-items-center mb-2">' +
            '<span class="badge bg-secondary me-2" style="min-width: 32px;">#<span class="row-index"></span></span>' +
            '<button type="button" class="btn btn-sm btn-outline-danger ms-auto" onclick="removeProductGroup(this)"><i class="fas fa-trash me-1"></i>Remove</button>' +
            '</div>' +
            '<div class="row g-3 align-items-end">' +
            '<div class="col-12 col-md-8">' +
            '<label class="fw-semibold" style="color: var(--muted);">Product URL</label>' +
            '<input type="url" name="product_urls[]" class="form-control product-url form-control-lg" placeholder="https://..." style="border-radius: 10px;">' +
            '</div>' +
            '<div class="col-12 col-md-4">' +
            '<label class="fw-semibold" style="color: var(--muted);">Product Name</label>' +
            '<input type="text" name="product_names[]" class="form-control product-name form-control-lg" placeholder="Optional name" style="border-radius: 10px;">' +
            '</div>' +
            '<div class="col-12 col-md-4">' +
            '<label class="fw-semibold" style="color: var(--muted);">Price (BDT)</label>' +
            '<input type="number" step="0.01" name="product_prices[]" class="form-control text-center product-price form-control-lg" placeholder="0.00" style="border-radius: 10px;">' +
            '</div>' +
            '<div class="col-12 col-md-3">' +
            '<label class="fw-semibold" style="color: var(--muted);">Qty</label>' +
            '<input type="number" min="1" name="product_quantities[]" class="form-control text-center product-qty form-control-lg" value="1" style="border-radius: 10px;">' +
            '</div>' +
            '<div class="col-12 col-md-3">' +
            '<label class="fw-semibold" style="color: var(--muted);">Purchase Cost (BDT)</label>' +
            '<input type="number" step="0.01" name="purchase_costs[]" class="form-control text-center purchase-cost form-control-lg" placeholder="0.00" style="border-radius: 10px;">' +
            '</div>' +
            '<div class="col-12 col-md-2 text-md-end">' +
            '<label class="fw-semibold d-block" style="color: var(--muted);">Subtotal</label>' +
            '<div class="h5 mb-0 subtotal-cell">0.00</div>' +
            '</div>' +
            '</div>' +
            '</div>'
        );
        $('#productsList').append(group);
        renumberRows();
        calculateTotal();
    }

    function removeProductGroup(btn) {
        $(btn).closest('.product-group').remove();
        if ($('#productsList .product-group').length === 0) addProductRow();
        renumberRows();
        calculateTotal();
    }

    $(document).ready(function() {
        // Bind changes to recalc totals
        $(document).on('input', '.product-price, .purchase-cost, .product-qty, input[name="shipping_charge"], input[name="service_charge"], input[name="discount"]', function() {
            var group = $(this).closest('.product-group');
            if (group.length) updateRowSubtotal(group);
            calculateTotal();
        });

        // Initialize totals
        $('#productsList .product-group').each(function() {
            updateRowSubtotal(this);
        });
        renumberRows();
        calculateTotal();

        $('#updateOrderBtn').click(function() {
            var form = $('#editOrderForm');
            var formData = form.serialize();
            var orderId = {{ $order->id }};

            $.ajax({
                url: '{{ route('backend.orders.update', ':id') }}'.replace(':id', orderId),
                type: 'PUT',
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
                    var errors = xhr.responseJSON && xhr.responseJSON.errors ? xhr.responseJSON.errors : {};
                    var errorMessage = 'Please fix the following errors:\n';
                    var hasErrors = false;

                    for (var field in errors) {
                        hasErrors = true;
                        errorMessage += '- ' + errors[field][0] + '\n';
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        text: hasErrors ? errorMessage : 'Unknown error occurred.'
                    });
                }
            });
        });
    });
</script>
