<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>{{ config('app.name') }} - Admin Panel</title>
        <link rel="icon" href="{{ asset('assets/images/logos/code-nest-icon-round-48.png') }}">

        <!-- Google Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
        <!-- Bootstrap 5 CSS -->
        <link rel="stylesheet" href="{{ asset('vendor/bootstrap-5.3.8/css/bootstrap.min.css') }}">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{ asset('vendor/font-awesome-7.0.0-pro/css/fontawesome.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/font-awesome-7.0.0-pro/css/regular.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/font-awesome-7.0.0-pro/css/solid.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/font-awesome-7.0.0-pro/css/brands.css') }}">
        <!-- select2 -->
        <link rel="stylesheet" href="{{ asset('vendor/select2-4.1.0/select2.min.css') }}">
        <!-- datatables -->
        <link rel="stylesheet" href="{{ asset('vendor/datatables-2.3.3/datatables.min.css') }}">
        <!-- Admin CSS -->
        <link rel="stylesheet" href="{{ asset('assets/backend/style.css') }}?v={{ time() }}">

        @stack('styles')
    </head>

    <body>
        <!-- Admin Container -->
        <div class="admin-container">
            <div class="row g-0">
                <!-- Logo Section -->
                <div class="col-auto admin-logo">
                    <div class="logo-content d-flex align-items-center justify-content-center h-100">
                        <img src="{{ asset('assets/images/logos/code-nest-icon-round-48.png') }}" alt="{{ config('app.name') }}" class="logo-image me-2">
                        <h1 class="logo-text mb-0">{{ config('app.name') }}</h1>
                    </div>
                </div>

                <!-- Top Bar -->
                @include('backend.partials.topbar')
            </div>

            <div class="row g-0">
                <!-- Sidebar -->
                @include('backend.partials.sidebar')

                <!-- Main Content -->
                <div class="col admin-main">
                    @yield('content')
                </div>
            </div>
        </div>

        <!-- Mobile Menu Toggle (Hidden on desktop) -->
        <button class="mobile-menu-toggle" style="display: none;">
            <i class="fas fa-bars"></i>
        </button>

        <!-- Overlay for mobile -->
        <div class="admin-overlay"></div>

        <!-- jquery -->
        <script src="{{ asset('vendor/jquery-3.7.1/jquery-3.7.1.min.js') }}"></script>
        <!-- Bootstrap 5 JS -->
        <script src="{{ asset('vendor/bootstrap-5.3.8/js/bootstrap.bundle.min.js') }}"></script>
        <!-- select2 -->
        <script src="{{ asset('vendor/select2-4.1.0/select2.min.js') }}"></script>
        <!-- sweetalert2 -->
        <script src="{{ asset('vendor/sweetalert2-11.22.5/sweetalert2@11.js') }}"></script>
        <!-- datatables -->
        <script src="{{ asset('vendor/datatables-2.3.3/datatables.min.js') }}"></script>
        <!-- custom js -->
        <script src="{{ asset('assets/backend/script.js') }}?v={{ time() }}"></script>

        <script>
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })

            @if (session('success'))
                Toast.fire({
                    icon: 'success',
                    title: '{{ session('success') }}'
                })
            @endif

            @if (session('error'))
                Toast.fire({
                    icon: 'error',
                    title: '{{ session('error') }}'
                })
            @endif

            @if (session('warning'))
                Toast.fire({
                    icon: 'warning',
                    title: '{{ session('warning') }}'
                })
            @endif

            function delete_warning(url) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = url;
                    }
                });
            }

            function warning(url) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, do it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = url;
                    }
                });
            }

            $(document).ready(function() {

                new DataTable('.datatable', {
                    "pageLength": 25
                });

                new DataTable('.datatable-no-ordering', {
                    "pageLength": 25,
                    "ordering": false
                });

                new DataTable('.datatable-scroll', {
                    scrollX: true
                });
            });
        </script>
        @stack('scripts')
    </body>

</html>
