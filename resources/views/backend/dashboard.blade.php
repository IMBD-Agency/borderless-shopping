@extends('layouts.backend')

@section('content')
    <div class="page-header">
        <h1 class="page-title">Dashboard</h1>
        <p class="page-description">Welcome to your admin dashboard</p>
    </div>

    <!-- Test Section for Mobile Sidebar -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="dashboard-card">
                <div class="card-header">
                    <h5 class="card-title">Mobile Sidebar Test</h5>
                </div>
                <div class="card-body">
                    <p>Current window width: <span id="windowWidth"></span></p>
                    <p>Sidebar classes: <span id="sidebarClasses"></span></p>
                    <p>Overlay classes: <span id="overlayClasses"></span></p>
                    <button class="btn btn-primary" onclick="testSidebar()">Test Sidebar Toggle</button>
                    <button class="btn btn-secondary" onclick="checkElements()">Check Elements</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Dashboard Cards -->
    <div class="dashboard-grid">
        <div class="dashboard-card">
            <div class="card-header">
                <h5 class="card-title">Total Users</h5>
                <div class="card-icon primary">
                    <i class="fas fa-users"></i>
                </div>
            </div>
            <div class="card-value">1,234</div>
            <div class="card-change positive">
                <i class="fas fa-arrow-up"></i>
                <span>12% from last month</span>
            </div>
        </div>

        <div class="dashboard-card">
            <div class="card-header">
                <h5 class="card-title">Revenue</h5>
                <div class="card-icon success">
                    <i class="fas fa-dollar-sign"></i>
                </div>
            </div>
            <div class="card-value">$45,678</div>
            <div class="card-change positive">
                <i class="fas fa-arrow-up"></i>
                <span>8% from last month</span>
            </div>
        </div>

        <div class="dashboard-card">
            <div class="card-header">
                <h5 class="card-title">Orders</h5>
                <div class="card-icon warning">
                    <i class="fas fa-shopping-cart"></i>
                </div>
            </div>
            <div class="card-value">567</div>
            <div class="card-change negative">
                <i class="fas fa-arrow-down"></i>
                <span>3% from last month</span>
            </div>
        </div>

        <div class="dashboard-card">
            <div class="card-header">
                <h5 class="card-title">Active Sessions</h5>
                <div class="card-icon error">
                    <i class="fas fa-chart-line"></i>
                </div>
            </div>
            <div class="card-value">89</div>
            <div class="card-change positive">
                <i class="fas fa-arrow-up"></i>
                <span>15% from last month</span>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function testSidebar() {
            console.log('Testing sidebar toggle...');
            console.log('Window width:', $(window).width());
            console.log('Sidebar element:', $('.admin-sidebar'));
            console.log('Overlay element:', $('.admin-overlay'));
            console.log('Toggle button:', $('.sidebar-toggle-btn, #sidebarToggle'));

            if ($(window).width() <= 768) {
                console.log('Mobile mode - toggling sidebar');
                $('.admin-sidebar').toggleClass('show');
                $('.admin-overlay').toggleClass('show');
                $('.sidebar-toggle-btn, #sidebarToggle').toggleClass('active');
            } else {
                console.log('Desktop mode - collapsing sidebar');
                $('.admin-sidebar').toggleClass('collapsed');
                $('.admin-logo').toggleClass('collapsed');
            }
        }

        function checkElements() {
            $('#windowWidth').text($(window).width());
            $('#sidebarClasses').text($('.admin-sidebar').attr('class') || 'No classes');
            $('#overlayClasses').text($('.admin-overlay').attr('class') || 'No classes');
        }

        // Update on window resize
        $(window).on('resize', function() {
            checkElements();
        });

        // Initial check
        $(document).ready(function() {
            checkElements();
        });
    </script>
@endpush
