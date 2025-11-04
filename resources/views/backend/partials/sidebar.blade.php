<div class="col-auto admin-sidebar">
    <nav class="sidebar-nav">
        <!-- Dashboard Section -->
        <div class="sidebar-section">Main</div>

        <ul class="list-unstyled mb-0">
            <li class="sidebar-nav-item">
                <a href="{{ route('backend.dashboard') }}" class="sidebar-nav-link {{ request()->routeIs('backend.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt"></i>
                    <span class="sidebar-nav-text">Dashboard</span>
                </a>
            </li>

            <li class="sidebar-nav-item">
                <a href="{{ route('backend.profile') }}" class="sidebar-nav-link {{ request()->routeIs('backend.profile*') ? 'active' : '' }}">
                    <i class="fas fa-user-circle"></i>
                    <span class="sidebar-nav-text">My Profile</span>
                </a>
            </li>

            @if (isSuperAdmin() || isAdmin())
                <!-- Management Section -->
                <div class="sidebar-section">Management</div>

                <li class="sidebar-nav-item">
                    <a href="{{ route('backend.orders.index') }}" class="sidebar-nav-link {{ request()->routeIs('backend.orders*') ? 'active' : '' }}">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="sidebar-nav-text">Orders</span>
                    </a>
                </li>

                <li class="sidebar-nav-item">
                    <a href="{{ route('backend.users.index') }}" class="sidebar-nav-link {{ request()->routeIs('backend.users*') ? 'active' : '' }}">
                        <i class="fas fa-users"></i>
                        <span class="sidebar-nav-text">Users</span>
                    </a>
                </li>

                <li class="sidebar-nav-item">
                    <a href="{{ route('backend.reviews.index') }}" class="sidebar-nav-link {{ request()->routeIs('backend.reviews*') ? 'active' : '' }}">
                        <i class="fas fa-star"></i>
                        <span class="sidebar-nav-text">Reviews</span>
                    </a>
                </li>

                <li class="sidebar-nav-item">
                    <a href="{{ route('backend.faqs.index') }}" class="sidebar-nav-link {{ request()->routeIs('backend.faqs*') ? 'active' : '' }}">
                        <i class="fas fa-question-circle"></i>
                        <span class="sidebar-nav-text">FAQs</span>
                    </a>
                </li>

                <li class="sidebar-nav-item">
                    <a href="{{ route('backend.faq.categories.index') }}" class="sidebar-nav-link {{ request()->routeIs('backend.faq.categories*') ? 'active' : '' }}">
                        <i class="fas fa-folder"></i>
                        <span class="sidebar-nav-text">FAQ Categories</span>
                    </a>
                </li>

                <li class="sidebar-nav-item">
                    <a href="{{ route('backend.settings') }}" class="sidebar-nav-link {{ request()->routeIs('backend.settings*') ? 'active' : '' }}">
                        <i class="fas fa-cog"></i>
                        <span class="sidebar-nav-text">Settings</span>
                    </a>
                </li>
            @endif
        </ul>
    </nav>
</div>
