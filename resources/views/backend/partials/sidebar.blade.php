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
                    <a href="{{ route('backend.settings') }}" class="sidebar-nav-link {{ request()->routeIs('backend.settings*') ? 'active' : '' }}">
                        <i class="fas fa-cog"></i>
                        <span class="sidebar-nav-text">Settings</span>
                    </a>
                </li>
            @endif
        </ul>
    </nav>
</div>
