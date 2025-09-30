<!DOCTYPE html>
<html lang="fr">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - Authentication</title>

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

        <!-- Auth CSS -->
        <link rel="stylesheet" href="{{ asset('assets/auth/style.css') }}?v={{ time() }}">

    </head>

    <body>
        <div class="auth-container">
            @yield('content')
        </div>

        <!-- Bootstrap 5 JS -->
        <script src="{{ asset('vendor/bootstrap-5.3.8/js/bootstrap.bundle.min.js') }}"></script>

        <!-- Auth JS -->
        <script src="{{ asset('assets/auth/script.js') }}?v={{ time() }}"></script>
    </body>

</html>
