@extends('layouts.backend')

@section('content')
    <div class="page-header">
        <h1 class="page-title">Create New User</h1>
        <p class="page-description">Add a new user to the system</p>
    </div>

    <div class="row">
        <!-- Left Column - User Information -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-user-plus me-2"></i>
                        USER INFORMATION
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('backend.users.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="mobile" class="form-label">Mobile <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('mobile') is-invalid @enderror" id="mobile" name="mobile" value="{{ old('mobile') }}" required>
                                @error('mobile')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="role" class="form-label">Role <span class="text-danger">*</span></label>
                                <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
                                    <option value="">Select Role</option>
                                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="client" {{ old('role') == 'client' ? 'selected' : '' }}>Client</option>
                                </select>
                                @error('role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Enter password" required>
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="password_confirmation" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation" placeholder="Confirm password" required>
                                    <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                @error('password_confirmation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="profile_picture" class="form-label">Profile Picture</label>
                                <input type="file" class="form-control @error('profile_picture') is-invalid @enderror" id="profile_picture" name="profile_picture" accept=".jpg,.jpeg,.png">
                                <small class="text-muted">Supported formats: JPG, JPEG, PNG (Max: 2MB)</small>
                                @error('profile_picture')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="text-end">
                            <a href="{{ route('backend.users.index') }}" class="btn btn-secondary me-2">
                                <i class="fas fa-arrow-left me-2"></i>
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>
                                Create User
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Right Column - Preview and Info -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body text-center">
                    <!-- Profile Picture Preview -->
                    <div class="profile-picture-container pt-4">
                        <div class="profile-picture-wrapper">
                            <img id="picture" src="{{ asset('assets/images/users/blank-profile.jpg') }}" alt="Profile Preview" class="profile-picture img-fluid rounded-circle">
                        </div>
                    </div>

                    <!-- Form Preview Info -->
                    <div class="form-preview-info mt-3">
                        <h6 class="text-muted mb-3">Form Preview</h6>
                        <div class="preview-details text-start">
                            <p class="mb-1"><strong>Name:</strong> <span id="preview-name">-</span></p>
                            <p class="mb-1"><strong>Email:</strong> <span id="preview-email">-</span></p>
                            <p class="mb-1"><strong>Mobile:</strong> <span id="preview-mobile">-</span></p>
                            <p class="mb-1"><strong>Role:</strong> <span id="preview-role">-</span></p>
                        </div>
                    </div>

                    <!-- Help Information -->
                    <div class="help-info mt-4">
                        <h6 class="text-muted mb-3">Help & Guidelines</h6>
                        <div class="text-start">
                            <ul class="list-unstyled small">
                                <li class="mb-1"><i class="fas fa-info-circle text-primary me-2"></i>All fields marked with * are required</li>
                                <li class="mb-1"><i class="fas fa-info-circle text-primary me-2"></i>Password must be at least 8 characters</li>
                                <li class="mb-1"><i class="fas fa-info-circle text-primary me-2"></i>Profile picture is optional</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Toggle password visibility
        document.getElementById('togglePassword').addEventListener('click', function() {
            const input = document.getElementById('password');
            const icon = this.querySelector('i');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });

        document.getElementById('toggleConfirmPassword').addEventListener('click', function() {
            const input = document.getElementById('password_confirmation');
            const icon = this.querySelector('i');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });

        // File input change handler for live preview
        document.getElementById('profile_picture').addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                document.getElementById('picture').src = window.URL.createObjectURL(file);
            } else {
                document.getElementById('picture').src = '{{ asset('assets/images/users/blank-profile.jpg') }}';
            }
        });

        // Live form preview
        document.getElementById('name').addEventListener('input', function() {
            document.getElementById('preview-name').textContent = this.value || '-';
        });

        document.getElementById('email').addEventListener('input', function() {
            document.getElementById('preview-email').textContent = this.value || '-';
        });

        document.getElementById('mobile').addEventListener('input', function() {
            document.getElementById('preview-mobile').textContent = this.value || '-';
        });

        document.getElementById('role').addEventListener('change', function() {
            const roleText = this.options[this.selectedIndex].text;
            document.getElementById('preview-role').textContent = roleText !== 'Select Role' ? roleText : '-';
        });
    </script>
@endpush

@push('styles')
    <style>
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

        .form-preview-info {
            padding: 1rem 0;
        }

        .preview-details p {
            font-size: 0.9rem;
            color: #6c757d;
        }

        .help-info {
            border-top: 1px solid var(--bs-border-color);
            padding-top: 1rem;
        }

        .help-info ul li {
            font-size: 0.85rem;
            color: #6c757d;
        }

        .card {
            border: none;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            border-radius: 0.5rem;
        }

        .card-header {
            border-radius: 0.5rem 0.5rem 0 0 !important;
        }

        .text-danger {
            color: #dc3545 !important;
        }
    </style>
@endpush
