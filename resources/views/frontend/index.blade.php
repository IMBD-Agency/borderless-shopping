@extends('layouts.frontend')

@section('content')
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center flex-column-reverse flex-md-row">
                <div class="col-lg-6 reveal reveal-left mt-4 mt-md-0">
                    <div class="hero-badge mb-3">
                        <span class="badge bg-accent-subtle text-accent px-3 py-2 rounded-pill">
                            <i class="fa-solid fa-star me-1"></i>
                            Trusted by 1,200+ customers
                        </span>
                    </div>
                    <h1 class="hero-title">Shop from Australian stores and ship to Bangladesh</h1>
                    <p class="hero-subtitle">Just send us a link, we'll take care of the rest. Get your favorite Australian products delivered right to your doorstep in Bangladesh with our secure and reliable service.</p>
                    <div class="hero-actions">
                        <a href="#order-form" class="btn btn-accent btn-lg">
                            <i class="fa-solid fa-rocket-launch me-2"></i>
                            Submit Order Request
                        </a>
                        <a href="#how-it-works" class="btn btn-outline-dark btn-lg">
                            <i class="fa-solid fa-play me-2"></i>
                            Watch How It Works
                        </a>
                    </div>
                    <div class="hero-stats d-none d-md-block mt-4">
                        <div class="row text-center">
                            <div class="col-4">
                                <div class="stat-number">2,500+</div>
                                <div class="stat-label">Orders Delivered</div>
                            </div>
                            <div class="col-4">
                                <div class="stat-number">99.5%</div>
                                <div class="stat-label">Success Rate</div>
                            </div>
                            <div class="col-4">
                                <div class="stat-number">15+</div>
                                <div class="stat-label">Cities Covered</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 reveal reveal-right">
                    <div class="hero-image-container">
                        <div class="video-container">
                            <div class="video-thumbnail" data-bs-toggle="modal" data-bs-target="#videoModal">
                                <img src="{{ asset('assets/images/borderless-video-thumbnail.jpg') }}" alt="How BorderlesShopping Works" class="img-fluid">
                                <div class="play-button">
                                    <i class="fa-solid fa-play"></i>
                                </div>
                                <div class="video-overlay">
                                    <h4>Watch How It Works</h4>
                                    <p>See how easy it is to shop from Australia</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Video Modal -->
    <div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content video-modal">
                <div class="modal-header video-modal__header">
                    <h5 class="modal-title" id="videoModalLabel">How BorderlesShopping Works</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="video-modal__frame">
                        <iframe src="https://www.youtube.com/embed/{{ $contact_details->youtube_tutorial }}" title="BorderlesShopping Tutorial" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Form -->
    <section id="order-form" class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="order-form reveal reveal-up">
                        <h3 class="mb-4 text-center">Submit Product Request</h3>
                        <p class="text-muted text-center mb-4">Enter the product link and details below to get started.</p>

                        <!-- Order Success Alert -->
                        <div id="orderSuccessAlert" class="alert bg-white shadow-sm rounded-3 border-0 p-0 mb-4 reveal reveal-up" role="alert">
                            <div class="p-3 p-md-4">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="d-flex align-items-start">
                                        <span class="badge bg-success-subtle text-success rounded-circle p-3 me-3 flex-shrink-0">
                                            <i class="fa-regular fa-circle-check"></i>
                                        </span>
                                        <div>
                                            <h5 class="mb-1">Order request submitted</h5>
                                            <p class="text-muted mb-2">We received your request. Our team will review and send a quote shortly.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 small">
                                    <div class="col-md-12">
                                        <div class="p-3 rounded border bg-light">
                                            <div class="text-muted">Product URL</div>
                                            <div class="fw-semibold text-break" id="successProductUrl"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="p-3 rounded border bg-light">
                                            <div class="text-muted">Recipient</div>
                                            <div class="fw-semibold" id="successRecipientName"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="p-3 rounded border bg-light">
                                            <div class="text-muted">Quantity</div>
                                            <div class="fw-semibold" id="successQuantity"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="p-3 rounded border bg-light">
                                            <div class="text-muted">Tracking Number</div>
                                            <div class="fw-semibold" id="successTrackingNumber"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="authForm" class="bg-white shadow-sm rounded-3 border-0 p-0 mb-4 reveal reveal-up">
                            <div class="p-3 p-md-4">
                                <p class="text-muted mb-3">Create an account or login to complete your order.</p>
                                <ul class="nav nav-tabs auth-tabs" id="authModalTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="modal-login-tab" data-bs-toggle="tab" data-bs-target="#modal-login-pane" type="button" role="tab" aria-controls="modal-login-pane" aria-selected="true">Login</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="modal-register-tab" data-bs-toggle="tab" data-bs-target="#modal-register-pane" type="button" role="tab" aria-controls="modal-register-pane" aria-selected="false">Register</button>
                                    </li>
                                </ul>
                                <div class="tab-content p-3 auth-tabs-pane" id="authModalTabContent">
                                    <div class="tab-pane fade show active" id="modal-login-pane" role="tabpanel" aria-labelledby="modal-login-tab" tabindex="0">
                                        <form id="loginForm" method="POST">
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="modalLoginEmail" class="form-label">Email</label>
                                                    <input id="modalLoginEmail" type="email" name="email" class="form-control" autocomplete="off" required>
                                                    <div class="text-danger error-text" id="loginEmail-error"></div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="modalLoginPassword" class="form-label">Password</label>
                                                    <input id="modalLoginPassword" type="password" name="password" class="form-control" autocomplete="off" required>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-accent w-100">
                                                <span class="btn-text">Login</span>
                                            </button>
                                        </form>
                                    </div>

                                    <div class="tab-pane fade" id="modal-register-pane" role="tabpanel" aria-labelledby="modal-register-tab" tabindex="0">
                                        <form id="registerForm" method="POST">
                                            <div class="row">
                                                <div class="col-md-12 mb-3">
                                                    <label for="modalRegName" class="form-label">Name</label>
                                                    <input id="modalRegName" type="text" name="name" class="form-control" autocomplete="off" required>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="modalRegEmail" class="form-label">Email</label>
                                                    <input id="modalRegEmail" type="email" name="email" class="form-control" autocomplete="off" required>
                                                    <div class="text-danger error-text" id="registerEmail-error"></div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="modalRegPassword" class="form-label">Password</label>
                                                    <input id="modalRegPassword" type="password" name="password" class="form-control" autocomplete="off" required>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-accent w-100">
                                                <span class="btn-text">Create Account</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="pendingOrderAlert" class="alert alert-warning shadow-sm rounded-3 border-0 p-0 mb-4 reveal reveal-up">
                            <div class="p-3 p-md-4">
                                <p class="text-muted mb-0"><i class="fa-regular fa-circle-exclamation"></i> You have a pending order. Please complete your order so we can process it.</p>
                            </div>
                        </div>

                        <!-- Multistep Form -->
                        <form id="orderForm">
                            <!-- Step Indicators -->
                            <div class="step-indicators mb-4">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="step-indicator active" data-step="1">
                                            <div class="step-number">1</div>
                                            <div class="step-title">Product Details</div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="step-indicator" data-step="2">
                                            <div class="step-number">2</div>
                                            <div class="step-title">Recipient Details</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Step 1: Product Details -->
                            <div class="step-content" id="step1">
                                <h5 class="mb-4">Add Product URLs and Quantities</h5>

                                <!-- Product URLs Container -->
                                <div id="productUrlsContainer">
                                    <div class="product-url-item mb-3">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <label class="form-label">Product URL <span class="text-danger">*</span></label>
                                                <input type="url" name="product_urls[]" class="form-control product-url-input" placeholder="https://www.amazon.com.au/product-link" autocomplete="off" required>
                                                <div class="text-danger error-text product-url-error"></div>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Quantity <span class="text-danger">*</span></label>
                                                <input type="number" name="product_quantities[]" class="form-control quantity-input" value="1" min="1" autocomplete="off" required>
                                                <div class="text-danger error-text quantity-error"></div>
                                            </div>
                                            <div class="col-md-1 d-flex align-items-end">
                                                <button type="button" class="btn btn-outline-danger btn-sm remove-url-btn" style="display: none;">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Add More URL Button -->
                                <div class="text-center mb-4">
                                    <button type="button" class="btn btn-outline" id="addMoreUrlBtn">
                                        <i class="fa-solid fa-plus"></i> Add Another Product
                                    </button>
                                </div>
                            </div>

                            <!-- Step 2: Recipient Details -->
                            <div class="step-content" id="step2" style="display: none;">
                                <h5 class="mb-4">Recipient Information</h5>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">Recipient Name <span class="text-danger">*</span></label>
                                        <input type="text" name="recipient_name" class="form-control" id="name" autocomplete="off" required>
                                        <div class="text-danger error-text" id="recipient_name-error"></div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="phone" class="form-label">Recipient Mobile Number <span class="text-danger">*</span></label>
                                        <input type="tel" name="recipient_mobile" class="form-control" id="phone" placeholder="+880..." autocomplete="off" required>
                                        <div class="text-danger error-text" id="recipient_mobile-error"></div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="district" class="form-label">District <span class="text-danger">*</span></label>
                                        <select name="district" class="form-control select2" id="district" autocomplete="off" required>
                                            <option value="">Select District</option>
                                            @foreach ($districts as $district)
                                                <option value="{{ $district->id }}">{{ $district->name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="text-danger error-text" id="district-error"></div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="area" class="form-label">Area <span class="text-danger">*</span></label>
                                        <select name="area" class="form-control select2" id="sub_city" autocomplete="off" required>
                                            <option value="">Select Area</option>
                                        </select>
                                        <div class="text-danger error-text" id="area-error"></div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="address" class="form-label">Recipient Address <span class="text-danger">*</span></label>
                                    <textarea name="recipient_address" class="form-control" id="address" rows="3" placeholder="Enter complete address including house number, road, area" autocomplete="off" required></textarea>
                                    <div class="text-danger error-text" id="recipient_address-error"></div>
                                </div>

                                <div class="mb-4">
                                    <label for="notes" class="form-label">Additional Notes (Optional)</label>
                                    <textarea name="notes" class="form-control" id="notes" rows="2" placeholder="Any special instructions or requirements" autocomplete="off"></textarea>
                                    <div class="text-danger error-text" id="notes-error"></div>
                                </div>
                            </div>

                            <!-- Navigation Buttons -->
                            <div class="step-navigation">
                                <div class="d-flex justify-content-between">
                                    <button type="button" class="btn btn-outline-secondary" id="prevStepBtn" style="display: none;">
                                        <i class="fa-solid fa-arrow-left"></i> Previous
                                    </button>
                                    <div class="ms-auto">
                                        <button type="button" class="btn btn-accent" id="nextStepBtn">
                                            Next <i class="fa-solid fa-arrow-right"></i>
                                        </button>
                                        <button type="submit" class="btn btn-accent btn-lg" id="submitBtn" style="display: none;">
                                            <span class="btn-text">
                                                <i class="fa-regular fa-paper-plane"></i>
                                                Submit Order
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Shop From Australia -->
    <section class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">Shop From Australia</h2>
                <p class="lead text-muted">Shop from Australia with ease and convenience. We offer a wide range of products from Australia to Bangladesh.</p>
            </div>

            <!-- Brand Logos Section -->
            <div class="brand-logos-section">
                <div class="brand-logos-grid">
                    <!-- Australian E-commerce Websites -->
                    <a href="https://www.apple.com/au/" target="_blank" rel="noopener noreferrer" class="brand-logo-card reveal" style="transition-delay: 50ms">
                        <img src="{{ asset('assets/images/brands/apple.png') }}" alt="Apple Australia" class="brand-logo-img">
                    </a>
                    <a href="https://www.woolworths.com.au/" target="_blank" rel="noopener noreferrer" class="brand-logo-card reveal" style="transition-delay: 100ms">
                        <img src="{{ asset('assets/images/brands/woolworths.png') }}" alt="Woolworths" class="brand-logo-img">
                    </a>
                    <a href="https://www.amazon.com.au/" target="_blank" rel="noopener noreferrer" class="brand-logo-card reveal" style="transition-delay: 150ms">
                        <img src="{{ asset('assets/images/brands/amazon.png') }}" alt="Amazon Australia" class="brand-logo-img">
                    </a>
                    <a href="https://www.coles.com.au/" target="_blank" rel="noopener noreferrer" class="brand-logo-card reveal" style="transition-delay: 200ms">
                        <img src="{{ asset('assets/images/brands/coles.png') }}" alt="Coles" class="brand-logo-img">
                    </a>
                    <a href="https://www.ebay.com.au/" target="_blank" rel="noopener noreferrer" class="brand-logo-card reveal" style="transition-delay: 250ms">
                        <img src="{{ asset('assets/images/brands/ebay.png') }}" alt="eBay Australia" class="brand-logo-img">
                    </a>
                    <a href="https://www.chemistwarehouse.com.au/" target="_blank" rel="noopener noreferrer" class="brand-logo-card reveal" style="transition-delay: 300ms">
                        <img src="{{ asset('assets/images/brands/chemist-warehouse.png') }}" alt="Chemist Warehouse" class="brand-logo-img">
                    </a>
                    <a href="https://www.harveynorman.com.au/" target="_blank" rel="noopener noreferrer" class="brand-logo-card reveal" style="transition-delay: 350ms">
                        <img src="{{ asset('assets/images/brands/harveynorman.png') }}" alt="Harvey Norman" class="brand-logo-img">
                    </a>
                    <a href="https://www.jbhifi.com.au/" target="_blank" rel="noopener noreferrer" class="brand-logo-card reveal" style="transition-delay: 400ms">
                        <img src="{{ asset('assets/images/brands/jb-hifi.png') }}" alt="JB Hi-Fi" class="brand-logo-img">
                    </a>
                    <a href="https://www.myer.com.au/" target="_blank" rel="noopener noreferrer" class="brand-logo-card reveal" style="transition-delay: 450ms">
                        <img src="{{ asset('assets/images/brands/myer.png') }}" alt="Myer" class="brand-logo-img">
                    </a>
                    <a href="https://www.davidjones.com/" target="_blank" rel="noopener noreferrer" class="brand-logo-card reveal" style="transition-delay: 500ms">
                        <img src="{{ asset('assets/images/brands/david-jones.png') }}" alt="David Jones" class="brand-logo-img">
                    </a>
                    <a href="https://au.shein.com/" target="_blank" rel="noopener noreferrer" class="brand-logo-card reveal" style="transition-delay: 550ms">
                        <img src="{{ asset('assets/images/brands/shein.png') }}" alt="SHEIN Australia" class="brand-logo-img">
                    </a>
                    <a href="https://www.sephora.com.au/" target="_blank" rel="noopener noreferrer" class="brand-logo-card reveal" style="transition-delay: 600ms">
                        <img src="{{ asset('assets/images/brands/sephora.png') }}" alt="Sephora Australia" class="brand-logo-img">
                    </a>
                    <a href="https://www.mecca.com/en-au/" target="_blank" rel="noopener noreferrer" class="brand-logo-card reveal" style="transition-delay: 650ms">
                        <img src="{{ asset('assets/images/brands/mecca.png') }}" alt="Mecca" class="brand-logo-img">
                    </a>
                    <a href="https://www.priceline.com.au/" target="_blank" rel="noopener noreferrer" class="brand-logo-card reveal" style="transition-delay: 700ms">
                        <img src="{{ asset('assets/images/brands/PricelinePharmacy.png') }}" alt="Priceline" class="brand-logo-img">
                    </a>
                    <a href="https://www.fossil.com/en-au/" target="_blank" rel="noopener noreferrer" class="brand-logo-card reveal" style="transition-delay: 750ms">
                        <img src="{{ asset('assets/images/brands/fossil.png') }}" alt="Fossil Australia" class="brand-logo-img">
                    </a>
                    <a href="https://www.templeandwebster.com.au/" target="_blank" rel="noopener noreferrer" class="brand-logo-card reveal" style="transition-delay: 800ms">
                        <img src="{{ asset('assets/images/brands/temple-webster.png') }}" alt="Temple & Webster" class="brand-logo-img">
                    </a>
                    <a href="https://www.adorebeauty.com.au/" target="_blank" rel="noopener noreferrer" class="brand-logo-card reveal" style="transition-delay: 850ms">
                        <img src="{{ asset('assets/images/brands/adore-beauty.png') }}" alt="Adore Beauty" class="brand-logo-img">
                    </a>
                    <a href="https://www.babybunting.com.au/" target="_blank" rel="noopener noreferrer" class="brand-logo-card reveal" style="transition-delay: 900ms">
                        <img src="{{ asset('assets/images/brands/baby-bunting.png') }}" alt="Baby Bunting" class="brand-logo-img">
                    </a>
                    <a href="https://www.shavershop.com.au/" target="_blank" rel="noopener noreferrer" class="brand-logo-card reveal" style="transition-delay: 950ms">
                        <img src="{{ asset('assets/images/brands/shavershop.png') }}" alt="Shaver Shop" class="brand-logo-img">
                    </a>
                    <a href="https://www.michaelhill.com.au/" target="_blank" rel="noopener noreferrer" class="brand-logo-card reveal" style="transition-delay: 1000ms">
                        <img src="{{ asset('assets/images/brands/michaelhill.png') }}" alt="Michael Hill" class="brand-logo-img">
                    </a>
                </div>

                <div class="text-center mt-5">
                    <p class="brand-note">
                        <i class="fa-solid fa-info-circle me-2"></i>
                        Don't see your favorite Australian store? No worries! We can help you shop from any Australian website.
                    </p>
                    <a href="#order-form" class="btn btn-accent btn-lg mt-3">
                        <i class="fa-solid fa-link me-2"></i>
                        Submit Product Link
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section id="how-it-works" class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">How It Works</h2>
                <p class="lead text-muted">Simple steps to get your favorite Australian products delivered to Bangladesh</p>
            </div>

            <!-- Process Steps -->
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4 reveal">
                    <div class="process-card">
                        <div class="process-icon">
                            <i class="fa-solid fa-link"></i>
                        </div>
                        <div class="process-number">01</div>
                        <div class="process-arrow d-none d-lg-block">
                            <i class="fas fa-arrow-right"></i>
                        </div>
                        <h4>Submit Product Link</h4>
                        <p class="text-muted">Share the product URL from any Australian online store along with quantity and your shipping preferences.</p>
                        <div class="process-features">
                            <span class="feature-tag">Any Australian Store</span>
                            <span class="feature-tag">Multiple Products</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4 reveal" style="transition-delay: 120ms">
                    <div class="process-card">
                        <div class="process-icon">
                            <i class="fa-solid fa-calculator"></i>
                        </div>
                        <div class="process-number">02</div>
                        <div class="process-arrow d-none d-lg-block">
                            <i class="fas fa-arrow-right"></i>
                        </div>
                        <h4>Get Instant Quote</h4>
                        <p class="text-muted">Receive a detailed quote with product price, shipping costs, and our dynamic service fee based on product type and quantity.</p>
                        <div class="process-features">
                            <span class="feature-tag">Dynamic Pricing</span>
                            <span class="feature-tag">No Hidden Fees</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4 reveal" style="transition-delay: 240ms">
                    <div class="process-card">
                        <div class="process-icon">
                            <i class="fa-solid fa-truck-fast"></i>
                        </div>
                        <div class="process-number">03</div>
                        <h4>We Handle Everything</h4>
                        <p class="text-muted">We purchase, pack, and ship your products directly to your address in Bangladesh with full tracking.</p>
                        <div class="process-features">
                            <span class="feature-tag">Full Tracking</span>
                            <span class="feature-tag">Secure Delivery</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features -->
    <section class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">Why Choose BorderlesShopping?</h2>
                <p class="lead text-muted">Experience the best in cross-border shopping with our premium features</p>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4 reveal">
                    <div class="feature-card text-center h-100">
                        <div class="feature-icon">
                            <i class="fa-solid fa-shield-check"></i>
                        </div>
                        <h4>Secure & Reliable</h4>
                        <p class="text-muted">Your orders are handled with complete security and reliability. We ensure safe delivery of your products with full insurance coverage.</p>
                        <div class="feature-highlight">
                            <span class="highlight-text">100% Secure</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4 reveal" style="transition-delay: 50ms">
                    <div class="feature-card text-center h-100">
                        <div class="feature-icon">
                            <i class="fa-solid fa-bolt"></i>
                        </div>
                        <h4>Lightning Fast</h4>
                        <p class="text-muted">Quick quote generation and order processing. Get your products delivered in the shortest possible time with our optimized workflow.</p>
                        <div class="feature-highlight">
                            <span class="highlight-text">Same Day Processing</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4 reveal" style="transition-delay: 100ms">
                    <div class="feature-card text-center h-100">
                        <div class="feature-icon">
                            <i class="fa-solid fa-headset"></i>
                        </div>
                        <h4>24/7 Support</h4>
                        <p class="text-muted">Our dedicated customer support team is available round the clock to assist you with any queries or concerns via multiple channels.</p>
                        <div class="feature-highlight">
                            <span class="highlight-text">Always Available</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-6 mb-4 reveal">
                    <div class="mini-feature-card text-center">
                        <div class="mini-feature-icon">
                            <i class="fa-solid fa-dollar-sign"></i>
                        </div>
                        <h6>Transparent Pricing</h6>
                        <small class="text-muted">No hidden fees</small>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4 reveal" style="transition-delay: 50ms">
                    <div class="mini-feature-card text-center">
                        <div class="mini-feature-icon">
                            <i class="fa-solid fa-map-marker-alt"></i>
                        </div>
                        <h6>Nationwide Delivery</h6>
                        <small class="text-muted">All over Bangladesh</small>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4 reveal" style="transition-delay: 100ms">
                    <div class="mini-feature-card text-center">
                        <div class="mini-feature-icon">
                            <i class="fa-solid fa-box"></i>
                        </div>
                        <h6>Careful Packaging</h6>
                        <small class="text-muted">Protective wrapping</small>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4 reveal" style="transition-delay: 150ms">
                    <div class="mini-feature-card text-center">
                        <div class="mini-feature-icon">
                            <i class="fa-solid fa-chart-line"></i>
                        </div>
                        <h6>Real-time Tracking</h6>
                        <small class="text-muted">Track your order</small>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats -->
    <section class="stats-section">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-6 mb-4 reveal">
                    <div class="stat-item">
                        <div class="stat-icon">
                            <i class="fa-solid fa-box"></i>
                        </div>
                        <span class="stat-number" data-count="2500">0</span>
                        <div class="stat-label">Orders Delivered</div>
                        <div class="stat-sublabel">and counting...</div>
                    </div>
                </div>
                <div class="col-md-3 col-6 mb-4 reveal" style="transition-delay: 120ms">
                    <div class="stat-item">
                        <div class="stat-icon">
                            <i class="fa-solid fa-users"></i>
                        </div>
                        <span class="stat-number" data-count="1200">0</span>
                        <div class="stat-label">Happy Customers</div>
                        <div class="stat-sublabel">and growing</div>
                    </div>
                </div>
                <div class="col-md-3 col-6 mb-4 reveal" style="transition-delay: 240ms">
                    <div class="stat-item">
                        <div class="stat-icon">
                            <i class="fa-solid fa-map-marker-alt"></i>
                        </div>
                        <span class="stat-number" data-count="15">0</span>
                        <div class="stat-label">Cities Covered</div>
                        <div class="stat-sublabel">across Bangladesh</div>
                    </div>
                </div>
                <div class="col-md-3 col-6 mb-4 reveal" style="transition-delay: 360ms">
                    <div class="stat-item">
                        <div class="stat-icon">
                            <i class="fa-solid fa-chart-line"></i>
                        </div>
                        <span class="stat-number" data-count="99.5">0</span>
                        <div class="stat-label">Success Rate</div>
                        <div class="stat-sublabel">guaranteed delivery</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">What Our Customers Say</h2>
                <p class="lead text-muted">Real experiences from satisfied customers across Bangladesh</p>
            </div>
            <div class="row">
                @forelse ($reviews as $review)
                    <div class="col-lg-4 col-md-6 mb-4 reveal" style="transition-delay: {{ $loop->iteration * 50 }}ms">
                        <div class="testimonial-card">
                            <div class="testimonial-content">
                                <div class="stars mb-3">
                                    @php
                                        $rating = (int) $review->rating;
                                        $rating = max(0, min(5, $rating));
                                    @endphp
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $rating)
                                            <i class="fa-solid fa-star text-warning" aria-hidden="true"></i>
                                        @else
                                            <i class="fa-regular fa-star text-warning" aria-hidden="true"></i>
                                        @endif
                                    @endfor
                                </div>
                                <p class="testimonial-text">"{{ $review->comment }}"</p>
                            </div>
                            <div class="testimonial-author">
                                <div class="author-avatar">
                                    <img src="{{ asset('assets/images/reviews/' . $review->image) }}" alt="Customer" class="rounded-circle">
                                </div>
                                <div class="author-info">
                                    <h6 class="author-name">{{ $review->name }}</h6>
                                    <small class="author-location">{{ $review->location }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                @endforelse

            </div>
        </div>
    </section>

    <!-- Pricing -->
    <section id="pricing" class="py-5 bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="pricing-card reveal reveal-up" style="transition-delay: 50ms">
                        <div class="pricing-header text-center mb-4">
                            <div class="pricing-badge mb-3">
                                <span class="badge bg-success-subtle text-success px-4 py-2 rounded-pill">
                                    <i class="fa-solid fa-check me-2"></i>
                                    Best Value
                                </span>
                            </div>
                            <h3 class="pricing-title">Transparent <span class="text-accent">Dynamic Pricing</span></h3>
                            <p class="pricing-description">Our service fee varies based on product type, quantity, and complexity. We provide detailed quotes with no hidden charges.</p>
                        </div>

                        <div class="pricing-breakdown">
                            <div class="row g-4">
                                <div class="col-lg-4 col-md-6">
                                    <div class="pricing-item">
                                        <div class="pricing-item-icon">
                                            <i class="fa-solid fa-tag"></i>
                                        </div>
                                        <h5 class="pricing-item-title">Product Price</h5>
                                        <p class="pricing-item-desc">As shown on the Australian store</p>
                                        <div class="pricing-item-highlight">No markup</div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="pricing-item featured">
                                        <div class="pricing-item-icon">
                                            <i class="fa-solid fa-calculator"></i>
                                        </div>
                                        <h5 class="pricing-item-title">Service Fee</h5>
                                        <p class="pricing-item-desc">Based on product type & quantity</p>
                                        <div class="pricing-item-highlight">Dynamic pricing</div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="pricing-item">
                                        <div class="pricing-item-icon">
                                            <i class="fa-solid fa-truck"></i>
                                        </div>
                                        <h5 class="pricing-item-title">Shipping Cost</h5>
                                        <p class="pricing-item-desc">Australia to Bangladesh</p>
                                        <div class="pricing-item-highlight">Actual cost</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="pricing-guarantee">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <h6 class="guarantee-title">
                                        <i class="fa-solid fa-shield-check text-success"></i>
                                        Our Pricing Guarantee
                                    </h6>
                                    <p class="guarantee-text">We provide detailed quotes upfront with no hidden fees. What you see is what you pay.</p>
                                </div>
                                <div class="col-md-4 text-center">
                                    <div class="guarantee-badge">
                                        <i class="fa-solid fa-lock"></i>
                                        <span>100% Transparent</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact -->
    <section id="contact" class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">Get In Touch</h2>
                <p class="lead text-muted">Have questions? We're here to help you with your shopping needs.</p>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-md-4 mb-4 reveal">
                            <div class="contact-card text-center">
                                <div class="contact-icon">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <h5>Email Support</h5>
                                <p class="text-muted">Get help via email</p>
                                <a href="mailto:{{ $contact_details->email }}" class="contact-link">{{ $contact_details->email }}</a>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4 reveal" style="transition-delay: 120ms">
                            <div class="contact-card text-center">
                                <div class="contact-icon">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <h5>Phone Support</h5>
                                <p class="text-muted">Call us directly</p>
                                <a href="tel:{{ $contact_details->phone }}" class="contact-link">{{ $contact_details->phone }}</a>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4 reveal" style="transition-delay: 240ms">
                            <div class="contact-card text-center">
                                <div class="contact-icon">
                                    <i class="fab fa-whatsapp"></i>
                                </div>
                                <h5>WhatsApp</h5>
                                <p class="text-muted">Quick chat support</p>
                                <a href="https://wa.me/{{ str_replace('+', '', $contact_details->whatsapp) }}" class="contact-link">{{ $contact_details->whatsapp }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Loader Overlay -->
    <div id="loaderOverlay" class="loader-overlay">
        <div class="loader-container">
            <div class="loader-spinner"></div>
            <div class="loader-text">Processing your request...</div>
            <div class="loader-subtext">Please wait while we submit your order</div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            var orderData = JSON.parse(localStorage.getItem('orderData'));
            let isLoggedIn = {{ auth()->check() ? 'true' : 'false' }};
            let currentStep = 1;
            const totalSteps = 2;

            //get sub cities with loader
            $('#district').change(function() {
                let districtId = $(this).val();
                let url = "{{ route('frontend.get-sub-cities') }}";

                if (!districtId) {
                    $('#sub_city').prop('disabled', false).html('<option value="">Select Area</option>').trigger('change');
                    return;
                }

                // Show page loader and set select loading state
                showLoader('Loading areas...', 'Fetching areas for selected district');
                $('#sub_city').prop('disabled', true).html('<option value="" selected>Loading...</option>').trigger('change');

                $.ajax({
                    url: url,
                    type: 'GET',
                    data: {
                        district_id: districtId
                    },
                    success: function(response) {
                        $('#sub_city').prop('disabled', false).html(response.html).trigger('change');
                    },
                    error: function() {
                        $('#sub_city').prop('disabled', false).html('<option value="">Could not load areas</option>').trigger('change');
                    },
                    complete: function() {
                        hideLoader();
                    }
                });
            });

            // Loader helper functions
            function showLoader(message = 'Processing your request...', subtext = 'Please wait while we submit your order') {
                $('.loader-text').text(message);
                $('.loader-subtext').text(subtext);
                $('#loaderOverlay').addClass('show');
            }

            function hideLoader() {
                $('#loaderOverlay').removeClass('show');
            }

            // Button loading state helper functions
            function setButtonLoading(button, loading = true) {
                if (loading) {
                    button.addClass('btn-loading');
                    button.append('<div class="btn-spinner"></div>');
                } else {
                    button.removeClass('btn-loading');
                    button.find('.btn-spinner').remove();
                }
            }

            // Multistep form functions
            function showStep(step) {
                $('.step-content').hide();
                $(`#step${step}`).show();
                currentStep = step;

                // Update step indicators
                $('.step-indicator').removeClass('active completed');
                for (let i = 1; i <= step; i++) {
                    if (i < step) {
                        $(`.step-indicator[data-step="${i}"]`).addClass('completed');
                    } else {
                        $(`.step-indicator[data-step="${i}"]`).addClass('active');
                    }
                }

                // Update navigation buttons
                if (step === 1) {
                    $('#prevStepBtn').hide();
                    $('#nextStepBtn').show();
                    $('#submitBtn').hide();
                } else if (step === totalSteps) {
                    $('#prevStepBtn').show();
                    $('#nextStepBtn').hide();
                    $('#submitBtn').show();
                } else {
                    $('#prevStepBtn').show();
                    $('#nextStepBtn').show();
                    $('#submitBtn').hide();
                }
            }

            function validateStep1() {
                let isValid = true;
                $('.product-url-error, .quantity-error').text('');
                $('.product-url-input, .quantity-input').removeClass('is-invalid is-valid');

                $('.product-url-item').each(function(index) {
                    let urlInput = $(this).find('.product-url-input');
                    let quantityInput = $(this).find('.quantity-input');
                    let url = urlInput.val().trim();
                    let quantity = quantityInput.val();

                    // Validate URL
                    if (!url) {
                        $(this).find('.product-url-error').text('Product URL is required');
                        urlInput.addClass('is-invalid');
                        isValid = false;
                    } else if (!isValidUrl(url)) {
                        $(this).find('.product-url-error').text('Please enter a valid URL');
                        urlInput.addClass('is-invalid');
                        isValid = false;
                    } else {
                        urlInput.addClass('is-valid');
                    }

                    // Validate Quantity
                    if (!quantity || quantity < 1) {
                        $(this).find('.quantity-error').text('Quantity must be at least 1');
                        quantityInput.addClass('is-invalid');
                        isValid = false;
                    } else {
                        quantityInput.addClass('is-valid');
                    }
                });

                return isValid;
            }

            function validateStep2() {
                let isValid = true;
                $('.error-text').text('');
                $('.form-control').removeClass('is-invalid is-valid');

                // Validate Recipient Name
                let recipientName = ($('#name').val() || '').trim();
                if (!recipientName) {
                    $('#recipient_name-error').text('Recipient name is required');
                    $('#name').addClass('is-invalid');
                    isValid = false;
                } else if (recipientName.length < 2) {
                    $('#recipient_name-error').text('Recipient name must be at least 2 characters');
                    $('#name').addClass('is-invalid');
                    isValid = false;
                } else {
                    $('#name').addClass('is-valid');
                }

                // Validate Mobile Number
                let mobile = ($('#phone').val() || '').trim();
                if (!mobile) {
                    $('#recipient_mobile-error').text('Mobile number is required');
                    $('#phone').addClass('is-invalid');
                    isValid = false;
                } else if (!validateBangladeshiMobile(mobile)) {
                    $('#recipient_mobile-error').text('Please enter a valid Bangladeshi mobile number (e.g., +8801********* or 01*********)');
                    $('#phone').addClass('is-invalid');
                    isValid = false;
                } else {
                    $('#phone').addClass('is-valid');
                }


                // Validate Area
                if ($('#area').length) {
                    let area = ($('#area').val() || '').trim();
                    if (!area) {
                        $('#area-error').text('Area is required');
                        $('#area').addClass('is-invalid');
                        isValid = false;
                    } else {
                        $('#area').addClass('is-valid');
                    }
                }

                // Validate District
                let district = $('#district').val();
                if (!district) {
                    $('#district-error').text('District is required');
                    $('#district').addClass('is-invalid');
                    isValid = false;
                } else {
                    $('#district').addClass('is-valid');
                }

                // Validate Address
                let address = ($('#address').val() || '').trim();
                if (!address) {
                    $('#recipient_address-error').text('Recipient address is required');
                    $('#address').addClass('is-invalid');
                    isValid = false;
                } else if (address.length < 10) {
                    $('#recipient_address-error').text('Please provide a complete address (at least 10 characters)');
                    $('#address').addClass('is-invalid');
                    isValid = false;
                } else {
                    $('#address').addClass('is-valid');
                }

                return isValid;
            }

            // Add more URL functionality
            $('#addMoreUrlBtn').click(function() {
                let newUrlItem = `
                    <div class="product-url-item mb-3">
                        <div class="row">
                            <div class="col-md-8">
                                <label class="form-label">Product URL <span class="text-danger">*</span></label>
                                            <input type="url" name="product_urls[]" class="form-control product-url-input" placeholder="https://www.amazon.com.au/product-link" autocomplete="off" required>
                                <div class="text-danger error-text product-url-error"></div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Quantity <span class="text-danger">*</span></label>
                                <input type="number" name="product_quantities[]" class="form-control quantity-input" value="1" min="1" autocomplete="off" required>
                                <div class="text-danger error-text quantity-error"></div>
                            </div>
                            <div class="col-md-1 d-flex align-items-end">
                                <button type="button" class="btn btn-outline-danger btn-sm remove-url-btn">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                `;
                $('#productUrlsContainer').append(newUrlItem);

                // Show remove buttons if more than one item
                if ($('.product-url-item').length > 1) {
                    $('.remove-url-btn').show();
                }
            });

            // Remove URL functionality
            $(document).on('click', '.remove-url-btn', function() {
                $(this).closest('.product-url-item').remove();

                // Hide remove buttons if only one item left
                if ($('.product-url-item').length <= 1) {
                    $('.remove-url-btn').hide();
                }
            });

            // Step navigation
            $('#nextStepBtn').click(function() {
                if (currentStep === 1 && validateStep1()) {
                    showStep(2);
                }
            });

            $('#prevStepBtn').click(function() {
                if (currentStep > 1) {
                    showStep(currentStep - 1);
                }
            });

            // Bangladeshi mobile number validation function
            function validateBangladeshiMobile(mobile) {
                // Remove all spaces and special characters except + and digits
                let cleanMobile = mobile.replace(/[^\d+]/g, '');

                // Check for valid Bangladeshi mobile number patterns
                // Pattern 1: +8801********* (11 digits after +880)
                // Pattern 2: 01********* (11 digits starting with 01)
                let pattern1 = /^\+8801[0-9]{9}$/; // +880 followed by 1 and 9 more digits
                let pattern2 = /^01[0-9]{9}$/; // 01 followed by 9 more digits

                return pattern1.test(cleanMobile) || pattern2.test(cleanMobile);
            }

            // Mobile number input handler - restricts to numeric and + sign, validates, and auto-formats
            $('#phone').on('input', function() {
                let value = $(this).val();
                // Remove any character that is not a digit or +
                let cleanValue = value.replace(/[^\d+]/g, '');

                // Update the input value with cleaned value
                if (value !== cleanValue) {
                    $(this).val(cleanValue);
                }

                // Auto-format: if user starts typing without +880, add it
                if (cleanValue.length > 0 && !cleanValue.startsWith('+880') && !cleanValue.startsWith('01')) {
                    if (cleanValue.startsWith('1') && cleanValue.length <= 10) {
                        $(this).val('+880' + cleanValue);
                        cleanValue = '+880' + cleanValue;
                    } else if (cleanValue.length <= 11 && !cleanValue.startsWith('+')) {
                        $(this).val(cleanValue);
                    }
                }

                let mobile = cleanValue;
                let errorDiv = $('#recipient_mobile-error');

                if (mobile.length > 0) {
                    if (validateBangladeshiMobile(mobile)) {
                        $(this).removeClass('is-invalid').addClass('is-valid');
                        errorDiv.text('');
                    } else {
                        $(this).removeClass('is-valid').addClass('is-invalid');
                        errorDiv.text('Please enter a valid Bangladeshi mobile number (e.g., +8801********* or 01*********)');
                    }
                } else {
                    $(this).removeClass('is-valid is-invalid');
                    errorDiv.text('');
                }
            });


            // Real-time validation for other fields
            $('#productUrl').on('blur', function() {
                let url = $(this).val().trim();
                if (url && !isValidUrl(url)) {
                    $(this).addClass('is-invalid');
                    $('#product_url-error').text('Please enter a valid URL');
                } else if (url) {
                    $(this).removeClass('is-invalid').addClass('is-valid');
                    $('#product_url-error').text('');
                }
            });


            // Helper functions
            function isValidUrl(string) {
                try {
                    new URL(string);
                    return true;
                } catch (_) {
                    return false;
                }
            }

            function isValidEmail(email) {
                let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return emailRegex.test(email);
            }

            function showSuccessAlert(response) {
                localStorage.removeItem('orderData');
                // Redirect to thank you page with tracking number
                window.location.href = "{{ route('frontend.thank-you', '') }}/" + response.order_request.tracking_number;
            }

            // Initialize form
            showStep(1);

            if (orderData) {
                // Load order data if available
                if (orderData.product_urls && orderData.product_urls.length > 0) {

                    // Add URL items from stored data
                    orderData.product_urls.forEach((url, index) => {
                        if (index === 0) {
                            // First item already exists, just update it
                            $('.product-url-input').first().val(url);
                            $('.quantity-input').first().val(orderData.product_quantities[index] || 1);
                        } else {
                            // Add new items
                            let newUrlItem = `
                                <div class="product-url-item mb-3">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <label class="form-label">Product URL <span class="text-danger">*</span></label>
                                            <input type="url" name="product_urls[]" class="form-control product-url-input" placeholder="https://www.amazon.com.au/product-link" value="${url}" autocomplete="off" required>
                                            <div class="text-danger error-text product-url-error"></div>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Quantity <span class="text-danger">*</span></label>
                                            <input type="number" name="product_quantities[]" class="form-control quantity-input" value="${orderData.product_quantities[index] || 1}" min="1" autocomplete="off" required>
                                            <div class="text-danger error-text quantity-error"></div>
                                        </div>
                                        <div class="col-md-1 d-flex align-items-end">
                                            <button type="button" class="btn btn-outline-danger btn-sm remove-url-btn">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            `;
                            $('#productUrlsContainer').append(newUrlItem);
                        }
                    });

                    // Show remove buttons if more than one item
                    if ($('.product-url-item').length > 1) {
                        $('.remove-url-btn').show();
                    }
                }

                $('#name').val(orderData.recipient_name || '');
                $('#phone').val(orderData.recipient_mobile || '');
                $('#area').val(orderData.area || '');
                $('#district').val(orderData.district || '');
                $('#district').trigger('change');
                $('#address').val(orderData.recipient_address || '');
                $('#notes').val(orderData.notes || '');
                $.ajax({
                    url: "{{ route('frontend.get-sub-cities') }}",
                    type: 'GET',
                    data: {
                        district_id: orderData.district
                    },
                    success: function(response) {
                        $('#sub_city').html(response.html);
                        $('#sub_city').val(orderData.area || '');
                        $('#sub_city').trigger('change');
                    }
                });
                $('#pendingOrderAlert').show();
            } else {
                $('#pendingOrderAlert').hide();
            }

            //login form submission
            $('#loginForm').submit(function(e) {
                e.preventDefault();
                $('.error-text').text('');
                var orderData = JSON.parse(localStorage.getItem('orderData'));
                let submitButton = $(this).find('button[type="submit"]');
                setButtonLoading(submitButton, true);
                showLoader('Logging you in...', 'Please wait while we authenticate your account');

                let formData = new FormData(this);
                // append arrays
                (orderData.product_urls || []).forEach((u) => formData.append('product_urls[]', u));
                (orderData.product_quantities || []).forEach((q) => formData.append('product_quantities[]', q));
                formData.append('recipient_name', orderData.recipient_name);
                formData.append('recipient_mobile', orderData.recipient_mobile);
                formData.append('recipient_address', orderData.recipient_address);
                formData.append('notes', orderData.notes);
                formData.append('district', orderData.district);
                formData.append('area', orderData.area);
                formData.append('is_logged_in', false);
                formData.append('action', 'login');
                let url = "{{ route('frontend.order-request') }}";
                $.get("{{ route('frontend.get-csrf-token') }}", function(response) {
                    formData.append('_token', response.csrf_token);
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            hideLoader();
                            setButtonLoading(submitButton, false);
                            showSuccessAlert(response);
                        },
                        error: function(xhr, status, error) {
                            hideLoader();
                            setButtonLoading(submitButton, false);
                            if (xhr.status === 401) {
                                $('#loginEmail-error').text(xhr.responseJSON.error);
                            } else {
                                console.log(xhr.responseText);
                            }
                        }
                    });
                });
            });

            //register form submission
            $('#registerForm').submit(function(e) {
                e.preventDefault();
                $('.error-text').text('');
                var orderData = JSON.parse(localStorage.getItem('orderData'));
                let submitButton = $(this).find('button[type="submit"]');
                setButtonLoading(submitButton, true);
                showLoader('Creating your account...', 'Please wait while we set up your account and process your order');

                let formData = new FormData(this);
                // append arrays
                (orderData.product_urls || []).forEach((u) => formData.append('product_urls[]', u));
                (orderData.product_quantities || []).forEach((q) => formData.append('product_quantities[]', q));
                formData.append('recipient_name', orderData.recipient_name);
                formData.append('recipient_mobile', orderData.recipient_mobile);
                formData.append('recipient_address', orderData.recipient_address);
                formData.append('notes', orderData.notes);
                formData.append('district', orderData.district);
                formData.append('area', orderData.area);
                formData.append('is_logged_in', false);
                formData.append('action', 'register');
                let url = "{{ route('frontend.order-request') }}";
                $.get("{{ route('frontend.get-csrf-token') }}", function(response) {
                    formData.append('_token', response.csrf_token);
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            hideLoader();
                            setButtonLoading(submitButton, false);
                            showSuccessAlert(response);
                        },
                        error: function(xhr, status, error) {
                            hideLoader();
                            setButtonLoading(submitButton, false);
                            if (xhr.status === 422) {
                                let error = xhr.responseJSON.error;
                                $('#registerEmail-error').text(error);
                            } else {
                                console.log(xhr.responseText);
                            }
                        }
                    });
                });
            });

            // Form submission
            $('#orderForm').submit(function(e) {
                e.preventDefault();

                // Validate current step before submission
                if (currentStep === 1 && !validateStep1()) {
                    return;
                }
                if (currentStep === 2 && !validateStep2()) {
                    return;
                }

                // If not on final step, go to next step
                if (currentStep < totalSteps) {
                    showStep(currentStep + 1);
                    return;
                }

                // Final submission
                let formData = new FormData(this);
                // Serialize FormData to object with array support for keys ending with []
                let data = {};
                formData.forEach((value, key) => {
                    if (key.endsWith('[]')) {
                        let baseKey = key.slice(0, -2);
                        if (!Array.isArray(data[baseKey])) {
                            data[baseKey] = [];
                        }
                        data[baseKey].push(value);
                    } else {
                        if (data[key] === undefined) {
                            data[key] = value;
                        } else {
                            // Convert to array if multiple values under same key
                            if (!Array.isArray(data[key])) {
                                data[key] = [data[key]];
                            }
                            data[key].push(value);
                        }
                    }
                });

                $('.form-control').removeClass('is-valid is-invalid');
                $('.error-text').text('');

                if (isLoggedIn) {
                    let submitButton = $(this).find('button[type="submit"]');
                    setButtonLoading(submitButton, true);
                    showLoader('Submitting your order...', 'Please wait while we process your order request');
                    formData.append('is_logged_in', isLoggedIn);
                    let url = "{{ route('frontend.order-request') }}";
                    $.get("{{ route('frontend.get-csrf-token') }}", function(response) {
                        formData.append('_token', response.csrf_token);
                        $.ajax({
                            url: url,
                            type: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(response) {
                                hideLoader();
                                setButtonLoading(submitButton, false);
                                showSuccessAlert(response);
                            },
                            error: function(xhr, status, error) {
                                hideLoader();
                                setButtonLoading(submitButton, false);
                                if (xhr.status === 422) {
                                    let errors = xhr.responseJSON.errors;
                                    $('.error-text').text('');
                                    $.each(errors, function(field, messages) {
                                        $(`#${field}-error`).text(messages[0]);
                                        $(`#${field}`).addClass('is-invalid');
                                    });
                                } else {
                                    console.log("Something went wrong:", xhr.responseText);
                                }
                            }
                        });
                    });
                } else {
                    localStorage.setItem('orderData', JSON.stringify(data));
                    $('#authForm').show();
                    $('#orderForm').hide();
                    $('#pendingOrderAlert').hide();
                    $('html, body').animate({
                        scrollTop: $('#authForm').offset().top - 100
                    }, 500);
                }
            });

            // Hide alert initially
            $('#orderSuccessAlert').hide();
            $('#authForm').hide();
        });
    </script>
@endpush
