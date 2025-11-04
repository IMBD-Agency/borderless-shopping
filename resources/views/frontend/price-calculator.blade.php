@extends('layouts.frontend')

@section('content')
    <div class="track-order-page">
        <div class="tracking-header">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-10 text-center">
                        <h1 class="tracking-title">Price Calculator</h1>
                        <p class="tracking-subtitle">Calculate the price of your order.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="tracking-form-section">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="price-calculator-card">
                            <div class="card-header">
                                <h3 class="card-title">Price Calculator</h3>
                            </div>
                            <div class="card-body">
                                <form id="priceCalculatorForm">
                                    @csrf
                                    <div class="section-intro mb-3">
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="badge bg-accent-subtle text-accent rounded-pill px-3 py-2"><i class="fa-solid fa-box"></i> Products</span>
                                            <small class="text-muted">Add one or more products to estimate cost</small>
                                        </div>
                                    </div>

                                    <div id="productUrlsContainer" class="product-items">
                                        <div class="product-url-item mb-3">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label class="form-label">Select Category <span class="text-danger">*</span></label>
                                                    <select name="category_id[]" class="form-control select2" id="category-select" autocomplete="off">
                                                        <option value="">Select Category</option>
                                                        @foreach ($price_list as $item)
                                                            <option value="{{ $item['item'] }}">{{ $item['item'] }}</option>
                                                        @endforeach
                                                    </select>
                                                    <div class="text-danger error-text category-error"></div>
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="form-label">Price (AUD) <span class="text-danger">*</span></label>
                                                    <input type="number" step="0.01" name="product_prices[]" class="form-control product-price-input" value="0.00" min="0.00" autocomplete="off" required>
                                                    <div class="text-danger error-text product-price-error"></div>
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="form-label">Quantity <span class="text-danger">*</span></label>
                                                    <input type="number" name="product_quantities[]" class="form-control product-quantity-input" value="1" min="1" autocomplete="off" required>
                                                    <div class="text-danger error-text product-quantity-error"></div>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label">Weight</label>
                                                    <div class="input-group">
                                                        <input type="number" step="0.01" name="product_weights[]" class="form-control product-weight-input" value="0.00" min="0.00" autocomplete="off">
                                                        <span class="input-group-text">
                                                            <select name="product_weight_units[]" class="form-select product-weight-unit-input" autocomplete="off">
                                                                <option value="g">g</option>
                                                                <option value="kg" selected>kg</option>
                                                            </select>
                                                        </span>
                                                    </div>
                                                    <div class="text-danger error-text product-weight-error"></div>
                                                </div>
                                                <div class="col-md-1 d-flex align-items-end">
                                                    <button type="button" class="btn btn-outline-danger btn-sm remove-url-btn" style="display: none;">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-center mt-2 small text-muted">
                                                <span>Item Shipping Charge:&nbsp;<strong class="line-total-value">AUD 0.00</strong></span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Add More URL Button -->
                                    <div class="text-center mb-4">
                                        <button type="button" class="btn btn-outline add-product-btn" id="addMoreUrlBtn">
                                            <i class="fa-solid fa-plus"></i> Add Another Product
                                        </button>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label">Delivery Location</label>
                                            <select name="delivery_location" class="form-select select2" id="delivery-location-select" autocomplete="off">
                                                <option value="">Select Delivery Location</option>
                                                <option value="inside_dhaka">Inside Dhaka</option>
                                                <option value="outside_dhaka">Outside Dhaka</option>
                                            </select>
                                            <div class="text-danger error-text delivery-location-error"></div>
                                        </div>
                                    </div>

                                    <div class="mt-3">
                                        <button type="submit" class="btn btn-accent btn-lg" id="calculateBtn">
                                            <span class="btn-text"><i class="fa-solid fa-calculator me-2"></i>Calculate Price</span>
                                        </button>
                                    </div>
                                </form>

                                <!-- Live Summary (moved after form) -->
                                <div class="row g-3 my-3" id="estimateSummary" style="display: none;">
                                    <div class="col-lg-6">
                                        <div class="summary-card">
                                            <div class="summary-header">
                                                <i class="fa-solid fa-calculator"></i>
                                                <span>Estimate Summary</span>
                                            </div>
                                            <div class="summary-body">
                                                <div class="summary-row">
                                                    <span class="label">Items</span>
                                                    <span class="value" id="sumItems">1</span>
                                                </div>
                                                <div class="summary-row">
                                                    <span class="label">Total Product Cost</span>
                                                    <span class="value" id="sumProductCost">AUD 0.00</span>
                                                </div>
                                                <div class="summary-row">
                                                    <span class="label">Total Weight</span>
                                                    <span class="value" id="sumWeight">0.00 KG</span>
                                                </div>
                                                <div class="summary-row">
                                                    <span class="label">Shipping Charge (AU to BD)</span>
                                                    <span class="value" id="sumCategoryCharge">AUD 0.00</span>
                                                </div>
                                                <div class="summary-row">
                                                    <span class="label">Subtotal</span>
                                                    <span class="value" id="sumGrandTotal">AUD 0.00</span>
                                                </div>
                                                <div class="summary-row">
                                                    <span class="label">Delivery Charge (BD)</span>
                                                    <span class="value" id="sumDelivery">BDT 0.00</span>
                                                </div>
                                                <hr>
                                                <div class="summary-row">
                                                    <span class="label">Overall Total</span>
                                                    <span class="value" id="sumOverall">BDT 0.00</span>
                                                </div>
                                            </div>
                                            <div class="summary-footer">
                                                <small class="text-muted d-block">This is an estimate based on your inputs. Final price may vary.</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Service Fee Section -->
        <section class="py-5 service-fee-section">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-5 mb-4 mb-lg-0 reveal reveal-left">
                        <h2 class="section-title text-start mb-4">What Does Our Service Fee Cover?</h2>
                        <p class="lead text-muted">The service fee covers all the work we do behind the scenes to make your shopping experience hassle-free. Once you place your order with us, you can count on us to take care of the rest!</p>
                    </div>
                    <div class="col-lg-7 reveal reveal-right">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="service-fee-item">
                                    <div class="service-fee-badge">1</div>
                                    <div class="service-fee-content">
                                        <h5 class="service-fee-title">We Shop</h5>
                                        <p class="service-fee-desc">We find the best Australian online store to purchase your item from.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="service-fee-item">
                                    <div class="service-fee-badge">2</div>
                                    <div class="service-fee-content">
                                        <h5 class="service-fee-title">We Purchase</h5>
                                        <p class="service-fee-desc">We buy your item and take care of any store issues that may arise.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="service-fee-item">
                                    <div class="service-fee-badge">3</div>
                                    <div class="service-fee-content">
                                        <h5 class="service-fee-title">We Inspect</h5>
                                        <p class="service-fee-desc">We inspect and check your items to ensure your order is correct.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="service-fee-item">
                                    <div class="service-fee-badge">4</div>
                                    <div class="service-fee-content">
                                        <h5 class="service-fee-title">We Repack</h5>
                                        <p class="service-fee-desc">We consolidate and repackage your items to ensure they get to you safely.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="service-fee-item">
                                    <div class="service-fee-badge">5</div>
                                    <div class="service-fee-content">
                                        <h5 class="service-fee-title">We Prepare</h5>
                                        <p class="service-fee-desc">We prepare all necessary shipping and customs documentation.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="service-fee-item">
                                    <div class="service-fee-badge">6</div>
                                    <div class="service-fee-content">
                                        <h5 class="service-fee-title">We Ship</h5>
                                        <p class="service-fee-desc">We ship the goods to your international address quickly and reliably using FedEx and UPS.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('styles')
    <style>
        .price-calculator-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            border: none;
            margin-bottom: 2rem;
        }

        .product-items .product-url-item {
            background: #f9fafb;
            border: 1px solid #eef0f3;
            border-radius: 12px;
            padding: 14px 12px;
        }

        .product-items .product-url-item+.product-url-item {
            margin-top: 12px;
        }

        .add-product-btn {
            border-style: dashed;
            border-width: 2px;
            border-color: #ced4da;
            background: #ffffff;
        }

        .add-product-btn:hover {
            background: #f7f7f7;
            color: var(--accent-color);
        }

        .summary-card {
            background: #ffffff;
            border: 1px solid #eef0f3;
            border-radius: 14px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.04);
        }

        .summary-header {
            padding: 12px 16px;
            border-bottom: 1px solid #eef0f3;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .summary-body {
            padding: 12px 16px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
        }

        .summary-row .label {
            color: #6c757d;
        }

        .summary-row .value {
            font-weight: 600;
        }

        .summary-footer {
            padding: 0 16px 12px;
        }

        .section-intro .badge {
            font-weight: 600;
        }

        /* Service Fee Section */
        .service-fee-section {
            background: linear-gradient(180deg, rgba(236, 29, 37, 0.04) 0%, rgba(236, 29, 37, 0.02) 100%);
        }

        .service-fee-item {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            padding: 1.25rem 1.25rem;
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.06);
            transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
            border: 1px solid rgba(0, 0, 0, 0.05);
            height: 100%;
        }

        .service-fee-item:hover {
            transform: translateY(-6px);
            box-shadow: 0 16px 40px rgba(0, 0, 0, 0.12);
            border-color: rgba(236, 29, 37, 0.25);
        }

        .service-fee-badge {
            width: 56px;
            height: 56px;
            min-width: 56px;
            background: linear-gradient(135deg, var(--accent-color), #ff6b6f);
            color: #ffffff;
            border-radius: 999px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 1.1rem;
            box-shadow: 0 10px 20px rgba(236, 29, 37, 0.25), inset 0 0 0 2px rgba(255, 255, 255, 0.15);
            flex-shrink: 0;
        }

        .service-fee-content {
            flex: 1;
        }

        .service-fee-title {
            font-size: 1.075rem;
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 0.35rem;
            letter-spacing: 0.2px;
        }

        .service-fee-desc {
            font-size: 0.95rem;
            color: var(--text-muted);
            margin-bottom: 0;
            line-height: 1.65;
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            // Pricing map from backend
            const categoryPricing = (function() {
                const list = @json($price_list);
                const map = {};
                (list || []).forEach(function(it) {
                    map[it.item] = {
                        price: Number(it.price) || 0,
                        unit: (it.unit || '').toLowerCase()
                    };
                });
                return map;
            })();

            // AUD rate from backend
            const audRate = Number(@json($aud_rate)) || 0;

            function toggleRemoveButtons() {
                if ($('.product-url-item').length > 1) {
                    $('.remove-url-btn').show();
                } else {
                    $('.remove-url-btn').hide();
                }
            }

            function toNumber(val) {
                const n = parseFloat(val);
                return isNaN(n) ? 0 : n;
            }

            function computeTotals() {
                let items = $('.product-url-item').length;
                let totalCost = 0;
                let totalWeightKg = 0;
                let totalCategoryCharge = 0;
                let deliveryChargeBdt = 0;

                $('.product-url-item').each(function() {
                    const price = toNumber($(this).find('.product-price-input').val());
                    const qty = Math.max(0, toNumber($(this).find('.product-quantity-input').val()));
                    const weight = toNumber($(this).find('.product-weight-input').val());
                    const unit = ($(this).find('.product-weight-unit-input').val() || 'kg').toLowerCase();
                    const category = ($(this).find('select[name="category_id[]"]').val() || '').trim();

                    totalCost += price * qty;

                    let weightKg = weight;
                    if (unit === 'g') {
                        weightKg = weight / 1000;
                    }
                    totalWeightKg += weightKg * qty;

                    // Category charge per line
                    let lineCatCharge = 0;
                    if (category && categoryPricing[category]) {
                        const cfg = categoryPricing[category];
                        if (cfg.unit === 'kg') {
                            lineCatCharge = (cfg.price * weightKg * qty);
                        } else {
                            lineCatCharge = (cfg.price * qty);
                        }
                        totalCategoryCharge += lineCatCharge;
                    }

                    // Update line total UI (category charge per item)
                    $(this).find('.line-total-value').text(`AUD ${lineCatCharge.toFixed(2)}`);
                });

                $('#sumItems').text(items);
                $('#sumProductCost').text(totalCost.toFixed(2));
                $('#sumWeight').text(`${totalWeightKg.toFixed(2)} KG`);
                $('#sumCategoryCharge').text(totalCategoryCharge.toFixed(2));
                const subTotal = totalCost + totalCategoryCharge;

                // Delivery charge based on selection
                const deliveryVal = ($('#delivery-location-select').val() || '').toLowerCase();
                if (deliveryVal === 'inside_dhaka') deliveryChargeBdt = 70;
                else if (deliveryVal === 'outside_dhaka') deliveryChargeBdt = 150;

                const overallBdt = (subTotal * audRate) + deliveryChargeBdt;

                $('#sumGrandTotal').text(`AUD ${subTotal.toFixed(2)}`);
                $('#sumDelivery').text(`BDT ${deliveryChargeBdt.toFixed(2)}`);
                $('#sumOverall').text(`BDT ${overallBdt.toFixed(2)}`);
                $('#sumProductCost').text(`AUD ${totalCost.toFixed(2)}`);
                $('#sumCategoryCharge').text(`AUD ${totalCategoryCharge.toFixed(2)}`);
            }

            // Validation function
            function validateForm() {
                let isValid = true;
                $('.error-text').text('');
                $('.product-url-item').each(function() {
                    const $item = $(this);
                    const category = ($item.find('select[name="category_id[]"]').val() || '').trim();
                    const price = toNumber($item.find('.product-price-input').val());
                    const quantity = toNumber($item.find('.product-quantity-input').val());
                    const weight = toNumber($item.find('.product-weight-input').val());

                    // Validate category (mandatory for all)
                    if (!category) {
                        $item.find('.category-error').text('Category is required');
                        isValid = false;
                    }

                    // Validate price (mandatory for all)
                    if (!price || price <= 0) {
                        $item.find('.product-price-error').text('Price is required and must be greater than 0');
                        isValid = false;
                    }

                    // Validate quantity (mandatory for all)
                    if (!quantity || quantity < 1) {
                        $item.find('.product-quantity-error').text('Quantity is required and must be at least 1');
                        isValid = false;
                    }

                    // Validate weight (mandatory only if category has unit "kg")
                    if (category && categoryPricing[category]) {
                        const cfg = categoryPricing[category];
                        if (cfg.unit === 'kg') {
                            if (!weight || weight <= 0) {
                                $item.find('.product-weight-error').text('Weight is required for this category');
                                isValid = false;
                            }
                        }
                    }
                });

                return isValid;
            }

            // Initialize initial state
            toggleRemoveButtons();
            computeTotals();
            $('#estimateSummary').hide();

            // Handle category change - update weight requirement
            $(document).on('change', 'select[name="category_id[]"]', function() {
                const $item = $(this).closest('.product-url-item');
                const category = $(this).val() || '';
                const $weightInput = $item.find('.product-weight-input');
                const $weightUnit = $item.find('.product-weight-unit-input');
                const $weightError = $item.find('.product-weight-error');

                // Clear previous error
                $weightError.text('');

                // Check if category requires weight
                if (category && categoryPricing[category]) {
                    const cfg = categoryPricing[category];
                    if (cfg.unit === 'kg') {
                        $weightInput.prop('required', true);
                        $weightUnit.prop('required', true);
                        // Validate if weight is already entered
                        const weight = toNumber($weightInput.val());
                        if (!weight || weight <= 0) {
                            $weightError.text('Weight is required for this category');
                        }
                    } else {
                        $weightInput.prop('required', false);
                        $weightUnit.prop('required', false);
                        $weightError.text('');
                    }
                } else {
                    $weightInput.prop('required', false);
                    $weightUnit.prop('required', false);
                }

                computeTotals();
            });

            // recompute on input changes
            $(document).on('input change', '.product-price-input, .product-quantity-input, .product-weight-input, .product-weight-unit-input, #delivery-location-select', function() {
                // Clear error for this field when user starts typing
                $(this).closest('.product-url-item').find('.error-text').text('');
                computeTotals();
            });

            // Show summary on calculate
            $('#priceCalculatorForm').on('submit', function(e) {
                e.preventDefault();

                // Validate form before showing summary
                if (!validateForm()) {
                    $('html, body').animate({
                        scrollTop: $('.product-url-item').first().offset().top - 100
                    }, 300);
                    return false;
                }

                computeTotals();
                $('#estimateSummary').slideDown(200);
                $('html, body').animate({
                    scrollTop: $('#estimateSummary').offset().top - 100
                }, 300);
            });

            // Add new product row
            $('#addMoreUrlBtn').on('click', function() {
                const newItemHtml = `
                    <div class="product-url-item mb-3">
                        <div class="row">
                            <div class="col-md-4">
                                <label class="form-label">Select Category <span class="text-danger">*</span></label>
                                <select name="category_id[]" class="form-control select2" autocomplete="off">
                                    <option value="">Select Category</option>
                                    @foreach ($price_list as $item)
                                        <option value="{{ $item['item'] }}">{{ $item['item'] }}</option>
                                    @endforeach
                                </select>
                                <div class="text-danger error-text category-error"></div>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Price (AUD) <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" name="product_prices[]" class="form-control product-price-input" value="0.00" min="0.00" autocomplete="off" required>
                                <div class="text-danger error-text product-price-error"></div>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Quantity <span class="text-danger">*</span></label>
                                <input type="number" name="product_quantities[]" class="form-control product-quantity-input" value="1" min="1" autocomplete="off" required>
                                <div class="text-danger error-text product-quantity-error"></div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Weight</label>
                                <div class="input-group">
                                    <input type="number" step="0.01" name="product_weights[]" class="form-control product-weight-input" value="0.00" min="0.00" autocomplete="off">
                            <span class="input-group-text">
                                        <select name="product_weight_units[]" class="form-select product-weight-unit-input" autocomplete="off">
                                            <option value="g">g</option>
                                            <option value="kg" selected>kg</option>
                                        </select>
                                    </span>
                                </div>
                                <div class="text-danger error-text product-weight-error"></div>
                            </div>
                            <div class="col-md-1 d-flex align-items-end">
                                <button type="button" class="btn btn-outline-danger btn-sm remove-url-btn">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center mt-2 small text-muted">
                            <span>Item Shipping Charge:&nbsp;<strong class=\"line-total-value\">AUD 0.00</strong></span>
                        </div>
                    </div>`;

                const $newItem = $(newItemHtml);
                $('#productUrlsContainer').append($newItem);

                // Initialize select2 for newly added select
                if ($.fn.select2) {
                    $newItem.find('.select2').select2({
                        width: '100%'
                    });
                }

                toggleRemoveButtons();
                computeTotals();
            });

            // Remove product row
            $(document).on('click', '.remove-url-btn', function() {
                $(this).closest('.product-url-item').remove();
                toggleRemoveButtons();
                computeTotals();
            });
        });
    </script>
@endpush
