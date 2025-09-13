<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>{{ config('app.name') }} – Professional Website Creation in Geneva</title>
        <link rel="icon" href="{{ asset('assets/images/logos/code-nest-icon-round-48.png') }}">
        <meta name="description" content="Modern and performant website creation in Geneva. Responsive design, custom development and maintenance. Your digital partner in Switzerland.">
        <!-- google fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
        <!-- Bootstrap 5 CSS -->
        <link rel="stylesheet" href="{{ asset('vendor/bootstrap-5.3.8/css/bootstrap.min.css') }}">
        <!-- font awesome -->
        <link rel="stylesheet" href="{{ asset('vendor/font-awesome-7.0.0-pro/css/fontawesome.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/font-awesome-7.0.0-pro/css/regular.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/font-awesome-7.0.0-pro/css/solid.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/font-awesome-7.0.0-pro/css/brands.css') }}">
        <!-- select2 -->
        <link rel="stylesheet" href="{{ asset('vendor/select2-4.1.0/select2.min.css') }}">
        <!-- datatables -->
        <link rel="stylesheet" href="{{ asset('vendor/datatables-2.3.3/datatables.min.css') }}">

        <!-- custom css -->
        <link rel="stylesheet" href="{{ asset('assets/frontend/style.css') }}?v={{ time() }}">
        @stack('styles')

    </head>

    <body>
        <!-- Navigation -->
        @include('frontend.partials.navbar')

        <!-- Main content -->
        @yield('content')

        <!-- Footer -->
        @include('frontend.partials.footer')

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
        <script src="{{ asset('assets/frontend/script.js') }}?v={{ time() }}"></script>
        @stack('scripts')
    </body>

</html>
