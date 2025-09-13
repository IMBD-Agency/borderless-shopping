@extends('layouts.auth')

@section('content')
    <div class="auth-header">
        <div class="auth-logo">
            <img src="{{ asset('assets/images/logos/code-nest-icon-round-48.png') }}" alt="{{ config('app.name') }}">
        </div>
        <h1 class="auth-title">{{ __('Reset Password') }}</h1>
        <p class="auth-subtitle">{{ __('Enter your email to receive reset instructions') }}</p>
    </div>

    <div class="auth-body">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
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

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-paper-plane me-2"></i>{{ __('Send Password Reset Link') }}
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
