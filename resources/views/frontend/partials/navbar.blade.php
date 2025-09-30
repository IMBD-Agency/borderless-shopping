<nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top">
    <div class="container">
        <a class="navbar-brand" href="{{ route('frontend.index') }}">
            <img class="brand-logo" src="{{ asset('assets/images/logos/borderless-logo.png') }}" alt="Logo">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('frontend.track-order') }}">Track Order</a>
                </li>
                @auth
                    <!-- User Dropdown for authenticated users -->
                    <li class="nav-item dropdown">
                        <button class="btn btn-link dropdown-toggle d-flex align-items-center text-decoration-none nav-link" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img class="user-avatar me-2" src="{{ get_user_image(auth()->user()->image) }}" alt="User Image">
                            <div class="user-info me-2">
                                <div class="user-name">{{ auth()->user()->name }}</div>
                                <div class="user-role">{{ get_user_role(auth()->user()->role) }}</div>
                            </div>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('user.dashboard') }}"><i class="fas fa-tachometer-alt me-2"></i>My Dashboard</a></li>
                            <li><a class="dropdown-item" href="{{ route('user.profile') }}"><i class="fas fa-user me-2"></i>My Profile</a></li>
                            <li><a class="dropdown-item" href="{{ route('user.orders') }}"><i class="fas fa-shopping-bag me-2"></i>My Orders</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            @if (isSuperAdmin() || isAdmin())
                                <li><a class="dropdown-item" href="{{ route('backend.dashboard') }}"><i class="fas fa-shield-alt me-2"></i>Admin Dashboard</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                            @endif
                            <li><button class="dropdown-item text-danger" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt me-2"></i>Logout</button></li>
                        </ul>
                    </li>
                @else
                    <!-- Login/Register links for guest users -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Register</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<!-- Logout Form (hidden) -->
@auth
    <form action="{{ route('logout') }}" method="POST" id="logout-form" style="display: none;">
        @csrf
    </form>
@endauth
