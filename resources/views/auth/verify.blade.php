@extends('layouts.auth')

@section('content')
    <div class="auth-header">
        <div class="auth-logo">
            <img src="{{ asset('assets/images/logos/code-nest-icon-round-48.png') }}" alt="{{ config('app.name') }}">
        </div>
        <h1 class="auth-title">{{ __('Verify Your Email') }}</h1>
        <p class="auth-subtitle">{{ __('Please verify your email address to continue') }}</p>
    </div>

    <div class="auth-body">
        @if (session('resent'))
            <div class="alert alert-success" role="alert">
                {{ __('A fresh verification link has been sent to your email address.') }}
            </div>
        @endif

        <div class="text-center mb-4">
            <p class="text-muted">
                {{ __('Before proceeding, please check your email for a verification link.') }}
                {{ __('If you did not receive the email') }},
            </p>
        </div>

        <form method="POST" action="{{ route('verification.resend') }}">
            @csrf
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-envelope me-2"></i>{{ __('Request Another Verification Link') }}
            </button>
        </form>
    </div>

    <div class="auth-footer">
        <p class="auth-footer-text">
            <a href="{{ route('logout') }}" class="btn-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt me-1"></i>{{ __('Logout') }}
            </a>
        </p>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div>
@endsection
