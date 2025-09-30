@extends('layouts.auth')

@section('content')
    <div class="auth-header">
        <div class="auth-logo">
            <img src="{{ asset('assets/images/logos/borderless-logo-icon.png') }}" alt="{{ config('app.name') }}">
        </div>
        <h1 class="auth-title">{{ __('Confirm Password') }}</h1>
        <p class="auth-subtitle">{{ __('Please confirm your password before continuing') }}</p>
    </div>

    <div class="auth-body">
        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <div class="form-group">
                <label for="password" class="form-label">{{ __('Password') }}</label>
                <div class="password-toggle">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" autofocus placeholder="Enter your password">
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

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-check me-2"></i>{{ __('Confirm Password') }}
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
            <a href="{{ route('login') }}" class="btn-link">
                <i class="fas fa-arrow-left me-1"></i>{{ __('Back to Login') }}
            </a>
        </p>
    </div>
@endsection
