@extends('layouts.frontend')

@section('content')
    <!-- Hero Section - Full Screen -->
    <header class="hero-fullscreen">
        <div class="hero-background">
            <div class="hero-particles"></div>
            <div class="hero-gradient"></div>
        </div>
        <div class="hero-content">
            <div class="container">
                <div class="hero-text-wrapper">
                    <span class="pill animate-fade-in-up" data-delay="0.2s">Based in Geneva, Switzerland</span>
                    <div class="subtitle animate-fade-in-up" data-delay="0.4s">Professional Website Creation</div>
                    <h1 class="animate-fade-in-up" data-delay="0.6s">Crafting Digital Excellence for Swiss Businesses</h1>
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <p class="hero-description animate-fade-in-up" data-delay="0.8s">
                                We specialize in creating modern, high-performance websites that elevate your brand.
                                From elegant showcase sites to powerful e-commerce platforms, we deliver digital solutions
                                that drive results and exceed expectations.
                            </p>
                        </div>
                    </div>
                    <div class="hero-buttons animate-fade-in-up" data-delay="1s">
                        <a class="btn-custom btn-primary" href="#realisations">
                            <i class="fas fa-eye"></i>
                            View Our Work
                        </a>
                        <a class="btn-custom btn-outline" href="#services">
                            <i class="fas fa-cogs"></i>
                            Explore Services
                        </a>
                    </div>

                    <!-- Scroll Indicator -->
                    <div class="scroll-indicator animate-fade-in-up" data-delay="1.2s">
                        <div class="scroll-arrow"></div>
                        <span>Scroll to explore</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Floating Feature Cards -->
        <div class="hero-features">
            <div class="container">
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="feature-card animate-fade-in-up" data-delay="1.2s">
                            <div class="feature-icon">
                                <i class="fas fa-palette"></i>
                            </div>
                            <h3>Custom Design</h3>
                            <p>Tailored interfaces that reflect your brand identity and deliver exceptional user experiences.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="feature-card animate-fade-in-up" data-delay="1.4s">
                            <div class="feature-icon">
                                <i class="fas fa-rocket"></i>
                            </div>
                            <h3>Performance First</h3>
                            <p>Lightning-fast websites optimized for speed, SEO, and Google Core Web Vitals compliance.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="feature-card animate-fade-in-up" data-delay="1.6s">
                            <div class="feature-icon">
                                <i class="fas fa-mobile-alt"></i>
                            </div>
                            <h3>Responsive Excellence</h3>
                            <p>Perfect adaptation across all devices ensuring seamless experiences everywhere.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </header>

    <!-- Services Section -->
    <section class="container section services-section" id="services">
        <div class="section-header animate-fade-in-up" data-delay="0.2s">
            <h2>Our Comprehensive Services</h2>
            <p class="intro">Professional website solutions tailored to your business needs</p>
        </div>
        <div class="row g-4">
            <div class="col-md-6 col-lg-4">
                <article class="service-card animate-fade-in-up" data-delay="0.3s">
                    <div class="service-icon">
                        <i class="fas fa-building"></i>
                    </div>
                    <h3>Showcase Websites</h3>
                    <p>Professional corporate websites that present your business with elegance and sophistication.
                        Custom design, optimized content, and fully responsive layouts.</p>
                    <div class="service-features">
                        <span>Custom Design</span>
                        <span>SEO Optimized</span>
                        <span>Responsive</span>
                    </div>
                </article>
            </div>
            <div class="col-md-6 col-lg-4">
                <article class="service-card animate-fade-in-up" data-delay="0.4s">
                    <div class="service-icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <h3>E-commerce Solutions</h3>
                    <p>Secure online stores with integrated payment systems, comprehensive product management,
                        and intuitive shopping experiences that convert visitors into customers.</p>
                    <div class="service-features">
                        <span>Payment Integration</span>
                        <span>Product Management</span>
                        <span>Order Processing</span>
                    </div>
                </article>
            </div>
            <div class="col-md-6 col-lg-4">
                <article class="service-card animate-fade-in-up" data-delay="0.5s">
                    <div class="service-icon">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <h3>Responsive Design</h3>
                    <p>Websites that adapt perfectly to all screen sizes and devices. From desktop computers
                        to mobile phones, we ensure optimal viewing experiences everywhere.</p>
                    <div class="service-features">
                        <span>Mobile First</span>
                        <span>Cross-Platform</span>
                        <span>Touch Optimized</span>
                    </div>
                </article>
            </div>
            <div class="col-md-6 col-lg-4">
                <article class="service-card animate-fade-in-up" data-delay="0.6s">
                    <div class="service-icon">
                        <i class="fas fa-search"></i>
                    </div>
                    <h3>SEO Optimization</h3>
                    <p>Comprehensive search engine optimization to increase your online visibility and attract
                        local customers. We implement proven strategies for better search rankings.</p>
                    <div class="service-features">
                        <span>Keyword Research</span>
                        <span>Technical SEO</span>
                        <span>Local SEO</span>
                    </div>
                </article>
            </div>
            <div class="col-md-6 col-lg-4">
                <article class="service-card animate-fade-in-up" data-delay="0.7s">
                    <div class="service-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3>Maintenance & Support</h3>
                    <p>Ongoing technical support, regular updates, automatic backups, and security monitoring.
                        Available in English and French for your convenience.</p>
                    <div class="service-features">
                        <span>24/7 Monitoring</span>
                        <span>Security Updates</span>
                        <span>Bilingual Support</span>
                    </div>
                </article>
            </div>
            <div class="col-md-6 col-lg-4">
                <article class="service-card animate-fade-in-up" data-delay="0.8s">
                    <div class="service-icon">
                        <i class="fas fa-tachometer-alt"></i>
                    </div>
                    <h3>Performance Optimization</h3>
                    <p>Ultra-fast and optimized websites that provide the best possible user experience.
                        We focus on speed, accessibility, and modern web standards.</p>
                    <div class="service-features">
                        <span>Speed Optimization</span>
                        <span>Core Web Vitals</span>
                        <span>Accessibility</span>
                    </div>
                </article>
            </div>
        </div>
    </section>

    <!-- Portfolio Section -->
    <section class="container section portfolio-section" id="realisations">
        <div class="section-header animate-fade-in-up" data-delay="0.2s">
            <h2>Featured Projects</h2>
            <p class="intro">Discover some of our recent work and success stories</p>
        </div>

        <div class="row g-4">
            <div class="col-lg-4">
                <article class="portfolio-card animate-fade-in-up" data-delay="0.3s" onclick="window.open('https://restaurant-lacroixblanche.ch', '_blank')">
                    <div class="portfolio-image">
                        <div class="portfolio-icon">🍽️</div>
                    </div>
                    <div class="portfolio-content">
                        <h3>Restaurant La Croix Blanche</h3>
                        <p>Elegant showcase website for a traditional Geneva restaurant featuring online menu display,
                            reservation system, and authentic Swiss hospitality presentation.</p>
                        <div class="portfolio-tech">
                            <span>Responsive Design</span>
                            <span>Booking System</span>
                            <span>Menu Management</span>
                        </div>
                        <div class="portfolio-link">
                            <a href="https://restaurant-lacroixblanche.ch" target="_blank" class="btn-custom btn-outline">
                                <i class="fas fa-external-link-alt"></i>
                                Visit Website
                            </a>
                        </div>
                    </div>
                </article>
            </div>
            <div class="col-lg-4">
                <article class="portfolio-card animate-fade-in-up" data-delay="0.4s" onclick="window.open('https://avocat-martin.ch', '_blank')">
                    <div class="portfolio-image">
                        <div class="portfolio-icon">⚖️</div>
                    </div>
                    <div class="portfolio-content">
                        <h3>Martin Law Firm</h3>
                        <p>Professional website for a prestigious law firm with comprehensive service presentation,
                            secure contact forms, and trust-building design elements.</p>
                        <div class="portfolio-tech">
                            <span>Professional Design</span>
                            <span>Secure Forms</span>
                            <span>Trust Elements</span>
                        </div>
                        <div class="portfolio-link">
                            <a href="https://avocat-martin.ch" target="_blank" class="btn-custom btn-outline">
                                <i class="fas fa-external-link-alt"></i>
                                Visit Website
                            </a>
                        </div>
                    </div>
                </article>
            </div>
            <div class="col-lg-4">
                <article class="portfolio-card animate-fade-in-up" data-delay="0.5s" onclick="window.open('https://boutique-mode-geneva.ch', '_blank')">
                    <div class="portfolio-image">
                        <div class="portfolio-icon">👗</div>
                    </div>
                    <div class="portfolio-content">
                        <h3>Geneva Fashion Store</h3>
                        <p>Complete e-commerce platform for a luxury fashion boutique featuring product catalog,
                            shopping cart, secure payments, and inventory management.</p>
                        <div class="portfolio-tech">
                            <span>E-commerce</span>
                            <span>Payment Gateway</span>
                            <span>Inventory System</span>
                        </div>
                        <div class="portfolio-link">
                            <a href="https://boutique-mode-geneva.ch" target="_blank" class="btn-custom btn-outline">
                                <i class="fas fa-external-link-alt"></i>
                                Visit Website
                            </a>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section class="container section pricing-section" id="tarifs">
        <div class="section-header animate-fade-in-up" data-delay="0.2s">
            <h2>Transparent Pricing</h2>
            <p class="intro">Professional website solutions with clear pricing and comprehensive features</p>
        </div>
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="pricing-card animate-fade-in-up" data-delay="0.3s">
                    <div class="pricing-header">
                        <div class="pricing-badge">Starter</div>
                        <h4>Essential Website</h4>
                        <div class="pricing-amount">CHF 690</div>
                        <div class="pricing-note">Perfect for startups and small businesses</div>
                    </div>
                    <ul class="pricing-features">
                        <li><i class="fas fa-check"></i> Custom responsive design (mobile-first)</li>
                        <li><i class="fas fa-check"></i> Up to 5 pages with custom content</li>
                        <li><i class="fas fa-check"></i> SEO optimization & meta tags</li>
                        <li><i class="fas fa-check"></i> Professional contact forms with validation</li>
                        <li><i class="fas fa-check"></i> Google Analytics & Search Console setup</li>
                        <li><i class="fas fa-check"></i> Social media integration & sharing</li>
                        <li><i class="fas fa-check"></i> SSL certificate & security measures</li>
                        <li><i class="fas fa-check"></i> 2 months of maintenance & support</li>
                        <li><i class="fas fa-check"></i> Performance optimization (Core Web Vitals)</li>
                        <li><i class="fas fa-check"></i> Basic content management system</li>
                    </ul>
                    <div class="pricing-action">
                        <a class="btn-custom btn-primary w-100" href="#contact">
                            <i class="fas fa-rocket"></i>
                            Get Started
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="pricing-card pricing-popular animate-fade-in-up" data-delay="0.4s">
                    <div class="popular-badge">Most Popular</div>
                    <div class="pricing-header">
                        <div class="pricing-badge">Professional</div>
                        <h4>Business Website</h4>
                        <div class="pricing-amount">CHF 1,250</div>
                        <div class="pricing-note">Complete digital presence solution</div>
                    </div>
                    <ul class="pricing-features">
                        <li><i class="fas fa-check"></i> Everything from Starter plan</li>
                        <li><i class="fas fa-check"></i> Up to 10 pages + dynamic blog system</li>
                        <li><i class="fas fa-check"></i> Advanced CMS with user management</li>
                        <li><i class="fas fa-check"></i> Comprehensive SEO strategy & implementation</li>
                        <li><i class="fas fa-check"></i> Advanced analytics & conversion tracking</li>
                        <li><i class="fas fa-check"></i> Newsletter integration & email marketing</li>
                        <li><i class="fas fa-check"></i> Multi-language support (EN/FR)</li>
                        <li><i class="fas fa-check"></i> Advanced security features & backups</li>
                        <li><i class="fas fa-check"></i> 6 months of maintenance & priority support</li>
                        <li><i class="fas fa-check"></i> Performance monitoring & optimization</li>
                    </ul>
                    <div class="pricing-action">
                        <a class="btn-custom btn-primary w-100" href="#contact">
                            <i class="fas fa-star"></i>
                            Choose Professional
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="pricing-card animate-fade-in-up" data-delay="0.5s">
                    <div class="pricing-header">
                        <div class="pricing-badge">Enterprise</div>
                        <h4>E-commerce & Web Apps</h4>
                        <div class="pricing-amount">Custom Quote</div>
                        <div class="pricing-note">Scalable solutions for growing businesses</div>
                    </div>
                    <ul class="pricing-features">
                        <li><i class="fas fa-check"></i> Complete e-commerce platform setup</li>
                        <li><i class="fas fa-check"></i> Advanced product catalog & inventory management</li>
                        <li><i class="fas fa-check"></i> Multiple payment gateways (Stripe, PayPal, etc.)</li>
                        <li><i class="fas fa-check"></i> Advanced shopping cart & checkout system</li>
                        <li><i class="fas fa-check"></i> Order management & fulfillment tracking</li>
                        <li><i class="fas fa-check"></i> Customer account management & profiles</li>
                        <li><i class="fas fa-check"></i> Advanced admin dashboard & reporting</li>
                        <li><i class="fas fa-check"></i> Custom integrations & third-party APIs</li>
                        <li><i class="fas fa-check"></i> Advanced security & fraud protection</li>
                        <li><i class="fas fa-check"></i> 12 months of maintenance & 24/7 support</li>
                        <li><i class="fas fa-check"></i> Training sessions & documentation</li>
                        <li><i class="fas fa-check"></i> Performance optimization</li>
                    </ul>
                    <div class="pricing-action">
                        <a class="btn-custom btn-outline w-100" href="#contact">
                            <i class="fas fa-comments"></i>
                            Request Custom Quote
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="container section contact-section" id="contact">
        <div class="section-header animate-fade-in-up" data-delay="0.2s">
            <h2>Ready to Transform Your Digital Presence?</h2>
            <p class="intro">Let's discuss your project and get you a personalized quote within 24 hours</p>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="contact-form animate-fade-in-up" data-delay="0.3s">
                    <div class="input-group">
                        <input type="email" class="form-control form-control-custom" placeholder="Enter your email address" />
                        <button class="btn-custom btn-primary">
                            <i class="fas fa-paper-plane"></i>
                            Get Free Quote
                        </button>
                    </div>
                    <p class="contact-note">
                        <i class="fas fa-clock"></i>
                        Response guaranteed within 24 hours
                    </p>
                </div>
            </div>
        </div>
        <div class="contact-info animate-fade-in-up" data-delay="0.4s">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="contact-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <div>
                            <h4>Location</h4>
                            <p>Geneva, Switzerland</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="contact-item">
                        <i class="fas fa-envelope"></i>
                        <div>
                            <h4>Email</h4>
                            <p>info@codenest.ch</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="contact-item">
                        <i class="fas fa-phone"></i>
                        <div>
                            <h4>Phone</h4>
                            <p>+41 22 XXX XX XX</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        // Intersection Observer for animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const element = entry.target;
                    const delay = element.dataset.delay || 0;

                    setTimeout(() => {
                        element.classList.add('animate-in');
                    }, delay * 1000);

                    observer.unobserve(element);
                }
            });
        }, observerOptions);

        // Observe all animated elements
        document.addEventListener('DOMContentLoaded', () => {
            const animatedElements = document.querySelectorAll('[data-delay]');
            animatedElements.forEach(el => observer.observe(el));
        });

        // Smooth scroll for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
@endpush
