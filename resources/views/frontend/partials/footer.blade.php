<footer>
    <div class="container">
        <div class="row g-4 mb-4">
            <div class="col-lg-6 footer-brand">
                <img src="{{ asset('assets/images/logos/logo-light.svg') }}" alt="CodeNest" class="brand-logo mb-2">
                <p>Your digital partner in Geneva for professional and high-performance website creation.</p>
            </div>
            <div class="col-6 col-lg-3">
                <div class="footer-links">
                    <h5>Services</h5>
                    <a href="#services">Website creation</a>
                    <a href="#services">E-commerce</a>
                    <a href="#services">Responsive design</a>
                    <a href="#services">SEO</a>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="footer-links">
                    <h5>Company</h5>
                    <a href="#realisations">Portfolio</a>
                    <a href="#tarifs">Pricing</a>
                    <a href="#contact">Contact</a>
                    <a href="#">About</a>
                </div>
            </div>
        </div>
        <div class="row align-items-center pt-4" style="border-top: 1px solid rgba(255, 255, 255, .06);">
            <div class="col-md-8">
                <div class="d-flex justify-content-md-start justify-content-center mb-2 mb-md-0">{{ config('app.name') }} © {{ now()->year }} | All rights reserved</div>
            </div>
            <div class="col-md-4">
                <div class="social-links d-flex justify-content-md-end justify-content-center gap-2">
                    <a href="#"><i class="fab fa-linkedin"></i></a>
                    <a href="#"><i class="fab fa-github"></i></a>
                    <a href="mailto:info@codenest.ch"><i class="fas fa-envelope"></i></a>
                </div>
            </div>
        </div>
    </div>
</footer>
