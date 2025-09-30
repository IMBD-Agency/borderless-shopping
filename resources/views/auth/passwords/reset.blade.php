@extends('layouts.auth')

@section('content')
    <div class="auth-header">
        <div class="auth-logo">
            <img src="{{ asset('assets/images/logos/borderless-logo-icon.png') }}" alt="{{ config('app.name') }}">
        </div>
        <h1 class="auth-title">{{ __('Reset Password') }}</h1>
        <p class="auth-subtitle">{{ __('Enter your new password') }}</p>
    </div>

    <div class="auth-body">
        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            <div class="form-group">
                <label for="email" class="form-label">{{ __('Email Address') }}</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus placeholder="Enter your email address">
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password" class="form-label">{{ __('New Password') }}</label>
                <div class="password-toggle">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Enter your new password">
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

            <div class="form-group">
                <label for="password-confirm" class="form-label">{{ __('Confirm New Password') }}</label>
                <div class="password-toggle">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm your new password">
                    <button type="button" class="password-toggle-btn">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-key me-2"></i>{{ __('Reset Password') }}
            </button>
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
