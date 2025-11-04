@extends('layouts.frontend')

@section('content')
    <div class="user-profile-page">
        <!-- Profile Header -->
        <div class="profile-header">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <div class="profile-info">
                            <div class="profile-avatar">
                                @if ($user->image && $user->image != 'blank-profile.jpg')
                                    <img src="{{ asset('assets/images/users/' . $user->image) }}" alt="{{ $user->name }}" class="avatar-img">
                                @else
                                    <div class="avatar-placeholder">
                                        <i class="fas fa-user"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="profile-details">
                                <h1 class="profile-name">{{ $user->name }}</h1>
                                <p class="profile-email">{{ $user->email }}</p>
                                <span class="member-since">Member since {{ $user->created_at->format('M Y') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <a href="{{ route('user.dashboard') }}" class="btn btn-outline-light">
                            <i class="fas fa-arrow-left me-2"></i>
                            Back to Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Profile Content -->
        <div class="profile-content">
            <div class="container">
                <div class="row g-4">
                    <!-- Profile Information -->
                    <div class="col-lg-8">
                        <div class="profile-card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-user-edit me-2"></i>
                                    Profile Information
                                </h3>
                            </div>
                            <div class="card-body">
                                @if (session('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <i class="fas fa-check-circle me-2"></i>
                                        {{ session('success') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                    </div>
                                @endif

                                <form action="{{ route('user.profile.update') }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name" class="form-label">Full Name</label>
                                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" autocomplete="off" required>
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="email" class="form-label">Email Address</label>
                                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" autocomplete="off" required>
                                                @error('email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-actions">
                                        <button type="submit" class="btn btn-accent">
                                            <i class="fas fa-save me-2"></i>
                                            Update Profile
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Change Password -->
                        <div class="profile-card mt-4">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-lock me-2"></i>
                                    Change Password
                                </h3>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('user.profile.change-password') }}" method="POST">
                                    @csrf

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="current_password" class="form-label">Current Password</label>
                                                <input type="password" class="form-control @error('current_password') is-invalid @enderror" id="current_password" name="current_password" autocomplete="off" required>
                                                @error('current_password')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="new_password" class="form-label">New Password</label>
                                                <input type="password" class="form-control @error('new_password') is-invalid @enderror" id="new_password" name="new_password" autocomplete="off" required>
                                                @error('new_password')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="new_password_confirmation" class="form-label">Confirm Password</label>
                                                <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" autocomplete="off" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-actions">
                                        <button type="submit" class="btn btn-accent">
                                            <i class="fas fa-key me-2"></i>
                                            Change Password
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Profile Sidebar -->
                    <div class="col-lg-4">
                        <!-- Profile Picture -->
                        <div class="profile-card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-camera me-2"></i>
                                    Profile Picture
                                </h3>
                            </div>
                            <div class="card-body text-center">
                                <!-- Current Profile Picture -->
                                <div class="profile-picture-container pt-4">
                                    <div class="profile-picture-wrapper">
                                        <img id="picture" src="{{ get_user_image($user->image) }}" alt="{{ $user->name }}" class="profile-picture img-fluid rounded-circle">
                                    </div>
                                </div>

                                <!-- Profile Picture Upload -->
                                <div class="profile-upload-section">
                                    <h6 class="text-muted mb-3">Update Profile Picture</h6>
                                    <form action="{{ route('user.profile.update-picture') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')

                                        <div class="mb-3">
                                            <input type="file" class="form-control @error('profile_picture') is-invalid @enderror" id="profile_picture" name="profile_picture" accept=".jpg,.jpeg,.png" autocomplete="off" required>
                                            <small class="text-muted">Supported formats: JPG, JPEG, PNG (Max: 2MB)</small>
                                            @error('profile_picture')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <button type="submit" class="btn btn-accent w-100">
                                            <i class="fas fa-upload me-2"></i>
                                            Update Picture
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="profile-card mt-4">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-bolt me-2"></i>
                                    Quick Actions
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="quick-actions">
                                    <a href="{{ route('user.orders') }}" class="quick-action">
                                        <i class="fas fa-list"></i>
                                        <span>View Orders</span>
                                    </a>
                                    <a href="{{ route('frontend.index') }}#order-form" class="quick-action">
                                        <i class="fas fa-plus"></i>
                                        <span>New Order</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .user-profile-page {
                background: #f8f9fa;
                min-height: 100vh;
                padding-bottom: 2rem;
            }

            .profile-header {
                background: linear-gradient(135deg, var(--accent-color) 0%, var(--accent-hover) 100%);
                color: white;
                padding: 3rem 0;
                margin-bottom: 2rem;
            }

            .profile-info {
                display: flex;
                align-items: center;
                gap: 1.5rem;
            }

            .profile-avatar {
                width: 80px;
                height: 80px;
                border-radius: 50%;
                overflow: hidden;
                border: 4px solid rgba(255, 255, 255, 0.3);
                flex-shrink: 0;
            }

            .avatar-img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            .avatar-placeholder {
                width: 100%;
                height: 100%;
                background: rgba(255, 255, 255, 0.2);
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 2rem;
            }

            .profile-details {
                flex: 1;
            }

            .profile-name {
                font-size: 2rem;
                font-weight: 700;
                margin-bottom: 0.5rem;
            }

            .profile-email {
                font-size: 1.1rem;
                opacity: 0.9;
                margin-bottom: 0.25rem;
            }

            .member-since {
                font-size: 0.9rem;
                opacity: 0.8;
            }

            .profile-content {
                margin-bottom: 2rem;
            }

            .profile-card {
                background: white;
                border-radius: 12px;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                overflow: hidden;
            }

            .card-header {
                background: #f8f9fa;
                padding: 1.5rem;
                border-bottom: 1px solid #e9ecef;
            }

            .card-title {
                margin: 0;
                font-size: 1.25rem;
                font-weight: 600;
                color: var(--dark-color);
            }

            .card-body {
                padding: 1.5rem;
            }

            .form-group {
                margin-bottom: 1.5rem;
            }

            .form-label {
                font-weight: 600;
                color: var(--dark-color);
                margin-bottom: 0.5rem;
                display: block;
            }

            .form-control {
                border: 2px solid #e9ecef;
                border-radius: 8px;
                padding: 12px 16px;
                font-size: 1rem;
                transition: border-color 0.3s ease;
            }

            .form-control:focus {
                border-color: var(--accent-color);
                box-shadow: 0 0 0 0.2rem rgba(236, 29, 37, 0.25);
            }

            .form-actions {
                margin-top: 2rem;
                padding-top: 1rem;
                border-top: 1px solid #e9ecef;
            }

            .stats-list {
                space-y: 1rem;
            }

            .stat-item {
                display: flex;
                align-items: center;
                gap: 1rem;
                padding: 1rem 0;
                border-bottom: 1px solid #f8f9fa;
            }

            .stat-item:last-child {
                border-bottom: none;
            }

            .stat-icon {
                width: 40px;
                height: 40px;
                background: var(--accent-color);
                color: white;
                border-radius: 8px;
                display: flex;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
            }

            .stat-content {
                flex: 1;
                display: flex;
                flex-direction: column;
            }

            .stat-label {
                font-size: 0.9rem;
                color: var(--text-muted);
                margin-bottom: 0.25rem;
            }

            .stat-value {
                font-weight: 600;
                color: var(--dark-color);
            }

            .quick-actions {
                space-y: 0.5rem;
            }

            .quick-action {
                display: flex;
                align-items: center;
                gap: 0.75rem;
                padding: 0.75rem;
                background: #f8f9fa;
                border: 1px solid #e9ecef;
                border-radius: 8px;
                text-decoration: none;
                color: var(--dark-color);
                transition: all 0.3s ease;
                margin-bottom: 0.5rem;
            }

            .quick-action:hover {
                background: var(--accent-color);
                color: white;
                border-color: var(--accent-color);
                transform: translateX(4px);
            }

            .quick-action i {
                width: 20px;
                text-align: center;
            }

            .quick-action span {
                font-weight: 500;
            }

            /* Responsive Design */
            @media (max-width: 768px) {
                .profile-info {
                    flex-direction: column;
                    text-align: center;
                }

                .profile-name {
                    font-size: 1.75rem;
                }

                .profile-header .col-md-4 {
                    text-align: center;
                    margin-top: 1rem;
                }

                .form-actions {
                    text-align: center;
                }

                .stat-item {
                    flex-direction: column;
                    text-align: center;
                    gap: 0.5rem;
                }
            }

            @media (max-width: 576px) {
                .profile-header {
                    padding: 2rem 0;
                }

                .profile-avatar {
                    width: 60px;
                    height: 60px;
                }

                .profile-name {
                    font-size: 1.5rem;
                }

                .card-body {
                    padding: 1rem;
                }
            }

            /* Profile Picture Styles */
            #picture {
                width: 150px;
                height: 150px;
                object-fit: cover;
                border: 4px solid #fff;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            }

            .profile-picture-container {
                position: relative;
            }

            .profile-picture-wrapper {
                position: relative;
                display: inline-block;
            }

            .profile-picture {
                transition: transform 0.3s ease;
            }

            .profile-picture:hover {
                transform: scale(1.05);
            }

            .profile-upload-section {
                padding-top: 1.5rem;
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            // File input change handler for live preview
            document.getElementById('profile_picture').addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    document.getElementById('picture').src = window.URL.createObjectURL(file);
                } else {
                    document.getElementById('picture').src = '{{ get_user_image($user->image) }}';
                }
            });
        </script>
    @endpush
@endsection
