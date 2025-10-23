<footer class="footer">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                <div class="footer-brand">
                    <h5 class="footer-title">BorderlesShopping</h5>
                    <p class="footer-description">Making Australian shopping accessible to Bangladesh.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                <div class="footer-social text-center">
                    <h6 class="footer-social-title">Follow Us</h6>
                    <div class="social-links">
                        @foreach ($socialMedia as $media)
                            <a href="{{ $media->url }}" class="social-link" aria-label="{{ $media->name }}" target="_blank">
                                <i class="{{ $media->icon }}"></i>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-12">
                <div class="footer-copyright text-center text-lg-end">
                    <p class="copyright-text">BorderlesShopping &copy; {{ now()->year }} | All rights reserved.</p>
                </div>
            </div>
        </div>
        <div class="footer-divider"></div>
        <div class="row">
            <div class="col-12">
                <div class="footer-bottom text-center">
                    <p class="footer-tagline">Connecting Australia to Bangladesh.</p>
                </div>
            </div>
        </div>
    </div>
</footer>
