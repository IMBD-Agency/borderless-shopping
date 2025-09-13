<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="dark">

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

        <style>
            :root {
                --bg: #000000;
                --surface: #121212;
                --text: #EAEAEA;
                --muted: #A0A0A0;
                --accent: #3B82F6;
                --accent-deep: #2563EB;
                --accent-soft: #60A5FA;
                --success: #22C55E;
                --warning: #EAB308;
                --error: #EF4444;
                --swiss-red: #ea1d22;
                --ring: 0 0 0 3px rgba(59, 130, 246, .35);
                --radius: 16px;
                --shadow: 0 10px 30px rgba(0, 0, 0, .55);
            }

            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                font-family: 'Inter', sans-serif;
                background-color: var(--bg);
                color: var(--text);
                line-height: 1.6;
                font-size: 14px;
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 20px;
            }

            .auth-container {
                width: 100%;
                max-width: 450px;
                background-color: var(--surface);
                border-radius: var(--radius);
                box-shadow: var(--shadow);
                overflow: hidden;
                border: 1px solid rgba(255, 255, 255, 0.1);
            }

            .auth-header {
                background: linear-gradient(135deg, var(--accent) 0%, var(--accent-deep) 100%);
                padding: 40px 30px;
                text-align: center;
                position: relative;
                overflow: hidden;
            }

            .auth-header::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="20" cy="20" r="0.5" fill="rgba(255,255,255,0.05)"/><circle cx="80" cy="80" r="0.5" fill="rgba(255,255,255,0.05)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
                opacity: 0.3;
            }

            .auth-logo {
                position: relative;
                z-index: 2;
            }

            .auth-logo img {
                height: 48px;
                width: auto;
                margin-bottom: 15px;
            }

            .auth-title {
                color: white;
                font-size: 1.75rem;
                font-weight: 700;
                margin: 0;
                position: relative;
                z-index: 2;
            }

            .auth-subtitle {
                color: rgba(255, 255, 255, 0.8);
                font-size: 0.9rem;
                margin: 8px 0 0 0;
                position: relative;
                z-index: 2;
            }

            .auth-body {
                padding: 40px 30px;
            }

            .form-group {
                margin-bottom: 24px;
            }

            .form-label {
                color: var(--text);
                font-weight: 600;
                margin-bottom: 8px;
                display: block;
                font-size: 0.9rem;
            }

            .form-control {
                background-color: rgba(255, 255, 255, 0.05);
                border: 1px solid rgba(255, 255, 255, 0.1);
                border-radius: var(--radius);
                color: var(--text);
                padding: 12px 16px;
                font-size: 0.9rem;
                transition: all 0.3s ease;
                width: 100%;
            }

            .form-control:focus {
                outline: none;
                border-color: var(--accent);
                box-shadow: var(--ring);
                background-color: rgba(255, 255, 255, 0.08);
            }

            .form-control::placeholder {
                color: var(--muted);
            }

            .form-control.is-invalid {
                border-color: var(--error);
                box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.35);
            }

            .invalid-feedback {
                color: var(--error);
                font-size: 0.8rem;
                margin-top: 6px;
                display: block;
            }

            .btn-primary {
                background: linear-gradient(135deg, var(--accent) 0%, var(--accent-deep) 100%);
                border: none;
                border-radius: var(--radius);
                color: white;
                font-weight: 600;
                padding: 14px 24px;
                font-size: 0.9rem;
                transition: all 0.3s ease;
                width: 100%;
                cursor: pointer;
            }

            .btn-primary:hover {
                background: linear-gradient(135deg, var(--accent-deep) 0%, var(--accent) 100%);
                transform: translateY(-2px);
                box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
            }

            .btn-primary:focus {
                outline: none;
                box-shadow: var(--ring);
            }

            .btn-link {
                color: var(--accent);
                text-decoration: none;
                font-size: 0.85rem;
                transition: color 0.3s ease;
            }

            .btn-link:hover {
                color: var(--accent-soft);
            }

            .auth-footer {
                text-align: center;
                padding: 20px 30px;
                border-top: 1px solid rgba(255, 255, 255, 0.1);
                background-color: rgba(0, 0, 0, 0.2);
            }

            .auth-footer-text {
                color: var(--muted);
                font-size: 0.8rem;
            }

            .form-check {
                display: flex;
                align-items: center;
                margin-bottom: 20px;
            }

            .form-check-input {
                margin-right: 10px;
                accent-color: var(--accent);
            }

            .form-check-label {
                color: var(--text);
                font-size: 0.85rem;
            }

            .password-toggle {
                position: relative;
            }

            .password-toggle .form-control {
                padding-right: 50px;
            }

            .password-toggle-btn {
                position: absolute;
                right: 12px;
                top: 50%;
                transform: translateY(-50%);
                background: none;
                border: none;
                color: var(--muted);
                cursor: pointer;
                padding: 0;
                font-size: 1rem;
            }

            .password-toggle-btn:hover {
                color: var(--text);
            }

            .alert {
                border-radius: var(--radius);
                padding: 12px 16px;
                margin-bottom: 20px;
                border: 1px solid;
            }

            .alert-success {
                background-color: rgba(34, 197, 94, 0.1);
                border-color: var(--success);
                color: var(--success);
            }

            .alert-danger {
                background-color: rgba(239, 68, 68, 0.1);
                border-color: var(--error);
                color: var(--error);
            }

            .alert-warning {
                background-color: rgba(234, 179, 8, 0.1);
                border-color: var(--warning);
                color: var(--warning);
            }

            @media (max-width: 480px) {
                .auth-container {
                    margin: 10px;
                }

                .auth-header,
                .auth-body,
                .auth-footer {
                    padding: 30px 20px;
                }
            }
        </style>
    </head>

    <body>
        <div class="auth-container">
            @yield('content')
        </div>

        <!-- Auth CSS -->
        <link rel="stylesheet" href="{{ asset('assets/auth/style.css') }}?v={{ time() }}">

        <!-- Bootstrap 5 JS -->
        <script src="{{ asset('vendor/bootstrap-5.3.8/js/bootstrap.bundle.min.js') }}"></script>

        <!-- Auth JS -->
        <script src="{{ asset('assets/auth/script.js') }}?v={{ time() }}"></script>
    </body>

</html>
