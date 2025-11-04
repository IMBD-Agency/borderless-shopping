@extends('layouts.frontend')

@section('content')
    <div class="track-order-page">
        <div class="tracking-header">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-10 text-center">
                        <h1 class="tracking-title">Privacy Policy</h1>
                        <p class="tracking-subtitle">Please review how we collect, use, and protect your information.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="tracking-form-section">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <div class="terms-content">
                            <!-- Overview -->
                            <div class="terms-section mb-5">
                                <h2 class="terms-section-title">Overview</h2>
                                <p>Welcome to BorderlesShopping. This Privacy Policy describes how we collect, use, and share your personal information when you use our website, request a quote, or place an order to shop from Australian stores and ship to Bangladesh.</p>
                                <p>By using our services, you agree to the practices described in this policy.</p>
                            </div>

                            <!-- Personal Information We Collect -->
                            <div class="terms-section mb-5">
                                <h2 class="terms-section-title">1. Personal Information We Collect</h2>

                                <h3 class="terms-subsection-title">1.1. Device Information</h3>
                                <p>When you visit our site, we may automatically collect certain information about your device, including browser type, IP address, time zone, and how you interact with the site (pages viewed, referring URLs/search terms). We refer to this as <strong>Device Information</strong>.</p>
                                <ul class="terms-nested-list">
                                    <li><strong>Cookies</strong>: small data files with unique identifiers. Learn more or manage cookies at <a href="http://www.allaboutcookies.org" target="_blank" rel="noopener noreferrer">allaboutcookies.org</a>.</li>
                                    <li><strong>Log files</strong>: record actions on the site (IP, browser, ISP, referring/exit pages, timestamps).</li>
                                    <li><strong>Web beacons/tags/pixels</strong>: electronic files used to understand how you browse the site.</li>
                                </ul>

                                <h3 class="terms-subsection-title">1.2. Order Information</h3>
                                <p>When you submit a quote, place an order, or contact us, we may collect information you provide such as name, email, phone, billing and shipping addresses, product links, and order details. For card payments (when available), processing is handled by our secure payment provider; we do not store card numbers.</p>
                            </div>

                            <!-- How We Use Personal Information -->
                            <div class="terms-section mb-5">
                                <h2 class="terms-section-title">2. How We Use Personal Information</h2>
                                <ul class="terms-nested-list">
                                    <li>Fulfil orders and quotes, including processing payments, arranging shipping, and issuing invoices/confirmations.</li>
                                    <li>Communicate with you about your requests and orders.</li>
                                    <li>Screen orders for potential risk or fraud.</li>
                                    <li>Improve and optimize our site and services (analytics, performance, user experience).</li>
                                    <li>Provide information or offers aligned with your preferences.</li>
                                </ul>
                            </div>

                            <!-- Sharing Your Personal Information -->
                            <div class="terms-section mb-5">
                                <h2 class="terms-section-title">3. Sharing Your Personal Information</h2>
                                <p>We may share information with:</p>
                                <ul class="terms-nested-list">
                                    <li><strong>Service providers</strong> (e.g., payment processors, couriers) to operate and deliver our services.</li>
                                    <li><strong>Analytics providers</strong> to understand site usage and improve performance.</li>
                                    <li><strong>Suppliers/partners</strong> involved in sourcing and fulfilment for your order.</li>
                                    <li><strong>Authorities</strong> when required by law, in response to lawful requests, or to protect our rights.</li>
                                </ul>
                            </div>

                            <!-- Behavioural Advertising & Do Not Track -->
                            <div class="terms-section mb-5">
                                <h2 class="terms-section-title">4. Behavioural Advertising & Do Not Track</h2>
                                <p>We may use information to provide relevant communications. You can control ad preferences through platform settings (e.g., Google, Facebook) or opt-out portals such as the Digital Advertising Alliance. We do not alter our data practices in response to browser Do Not Track signals.</p>
                            </div>

                            <!-- Your Rights -->
                            <div class="terms-section mb-5">
                                <h2 class="terms-section-title">5. Your Rights</h2>
                                <p>Depending on your jurisdiction, you may request access, correction, or deletion of your personal information. To exercise these rights, contact us using the details below.</p>
                                <p>Where applicable, your data may be transferred between Australia and Bangladesh for order processing and support.</p>
                            </div>

                            <!-- Data Retention -->
                            <div class="terms-section mb-5">
                                <h2 class="terms-section-title">6. Data Retention</h2>
                                <p>We retain order and account information as required to provide our services and comply with legal, accounting, or reporting obligations, unless you request deletion where applicable.</p>
                            </div>

                            <!-- Changes -->
                            <div class="terms-section mb-5">
                                <h2 class="terms-section-title">7. Changes</h2>
                                <p>We may update this policy to reflect operational, legal, or regulatory changes. Updates will be posted on this page with a revised date.</p>
                            </div>

                            <!-- Contact -->
                            <div class="terms-section">
                                <h2 class="terms-section-title">8. Contact</h2>
                                <p>If you have any questions about this Privacy Policy or your data, please contact us:</p>
                                @if (!empty($contact_details?->email))
                                    <p><strong>Email:</strong> <a href="mailto:{{ $contact_details->email }}">{{ $contact_details->email }}</a></p>
                                @endif
                                @if (!empty($contact_details?->phone))
                                    <p><strong>Phone:</strong> <a href="tel:{{ $contact_details->phone }}">{{ $contact_details->phone }}</a></p>
                                @endif
                                @if (!empty($contact_details?->address))
                                    <p><strong>Address:</strong> {{ $contact_details->address }}</p>
                                @endif

                                <div class="terms-footer mt-4 pt-3 border-top">
                                    <p class="text-muted small mb-0"><strong>Last Updated:</strong> {{ date('F d, Y') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
    <style>
        .terms-content {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            padding: 3rem;
            line-height: 1.8;
            color: #333;
        }
        .terms-section { margin-bottom: 3rem; }
        .terms-section-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 1.5rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid #e9ecef;
        }
        .terms-subsection-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--dark-color);
            margin-top: 1.5rem;
            margin-bottom: 0.75rem;
        }
        .terms-content p { margin-bottom: 1rem; color: #555; }
        .terms-nested-list { margin-left: 1.5rem; margin-bottom: 1rem; padding-left: 1rem; }
        .terms-nested-list li { margin-bottom: 0.5rem; color: #555; }
        .terms-footer { font-size: 0.9rem; }
        @media (max-width: 768px) {
            .terms-content { padding: 2rem 1.5rem; }
            .terms-section-title { font-size: 1.5rem; }
            .terms-subsection-title { font-size: 1.1rem; }
        }
    </style>
    @endpush
@endsection
