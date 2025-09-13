<div class="col admin-topbar">
    <div class="d-flex align-items-center justify-content-between h-100">
        <!-- Left: Sidebar Toggle Button -->
        <div class="d-flex align-items-center">
            <button class="btn btn-link sidebar-toggle-btn me-3" id="sidebarToggle" type="button">
                <i class="fas fa-bars"></i>
            </button>
        </div>

        <!-- Center: Mobile Logo (hidden by default, shown on mobile) -->
        <div class="mobile-logo d-none">
            <img src="{{ asset('assets/images/logos/logo-light.svg') }}" alt="{{ config('app.name') }}" class="logo-image">
        </div>

        <!-- Right: User Menu -->
        <div class="d-flex align-items-center">
            <div class="user-menu dropdown">
                <button class="btn btn-link dropdown-toggle d-flex align-items-center text-decoration-none" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img class="user-avatar me-2" src="{{ get_user_image(auth()->user()->image) }}" alt="User Image">
                    <div class="user-info me-2">
                        <div class="user-name">{{ auth()->user()->name }}</div>
                        <div class="user-role">{{ get_user_role(auth()->user()->role) }}</div>
                    </div>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="{{ route('backend.profile') }}"><i class="fas fa-user me-2"></i>Profile</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><button class="dropdown-item text-danger" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt me-2"></i>Logout</button></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<form action="{{ route('logout') }}" method="POST" id="logout-form" style="display: none;">
    @csrf
</form>
