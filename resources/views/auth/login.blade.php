@extends('layouts.auth')

@section('content')
    <div class="auth-header">
        <div class="auth-logo">
            <img src="{{ asset('assets/images/logos/borderless-logo-icon.png') }}" alt="{{ config('app.name') }}">
        </div>
        <h1 class="auth-title">{{ __('Welcome Back') }}</h1>
        <p class="auth-subtitle">{{ __('Sign in to your account') }}</p>
    </div>

    <div class="auth-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label for="email" class="form-label">{{ __('Email Address') }}</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Enter your email address">
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password" class="form-label">{{ __('Password') }}</label>
                <div class="password-toggle">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Enter your password">
                    <button type="button" class="password-toggle-btn">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label" for="remember">
                    {{ __('Remember Me') }}
                </label>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-sign-in-alt me-2"></i>{{ __('Sign In') }}
            </button>

            @if (Route::has('password.request'))
                <div class="text-center mt-3">
                    <a class="btn-link" href="{{ route('password.request') }}">
                        {{ __('Forgot Your Password?') }}
                    </a>
                </div>
            @endif
        </form>
    </div>

    <div class="auth-footer">
        <p class="auth-footer-text">
            {{ __('Don\'t have an account?') }}
            <a href="{{ route('register') }}" class="btn-link">{{ __('Sign Up') }}</a>
        </p>
    </div>
@endsection
