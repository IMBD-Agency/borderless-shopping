// Auth Forms Enhanced Functionality

document.addEventListener('DOMContentLoaded', function () {
    // Password toggle functionality
    initializePasswordToggles();

    // Password strength checker
    initializePasswordStrength();

    // Form validation enhancement
    initializeFormValidation();

    // Loading states for buttons
    initializeLoadingStates();
});

// Password Toggle Functionality
function initializePasswordToggles() {
    const passwordToggles = document.querySelectorAll('.password-toggle-btn');

    passwordToggles.forEach(toggle => {
        toggle.addEventListener('click', function () {
            const input = this.previousElementSibling;
            const icon = this.querySelector('i');

            if (input.type === 'password') {
                input.type = 'text';
                icon.className = 'fas fa-eye-slash';
            } else {
                input.type = 'password';
                icon.className = 'fas fa-eye';
            }
        });
    });
}

// Password Strength Checker
function initializePasswordStrength() {
    const passwordInputs = document.querySelectorAll('input[type="password"]');

    passwordInputs.forEach(input => {
        // Create password strength indicator if it doesn't exist
        if (!input.nextElementSibling || !input.nextElementSibling.classList.contains('password-strength')) {
            const strengthIndicator = document.createElement('div');
            strengthIndicator.className = 'password-strength';
            strengthIndicator.innerHTML = '<div class="password-strength-bar"></div>';
            input.parentNode.insertBefore(strengthIndicator, input.nextSibling);
        }

        input.addEventListener('input', function () {
            const strength = checkPasswordStrength(this.value);
            updatePasswordStrengthIndicator(this, strength);
        });
    });
}

function checkPasswordStrength(password) {
    let score = 0;

    if (password.length >= 8) score++;
    if (password.match(/[a-z]/)) score++;
    if (password.match(/[A-Z]/)) score++;
    if (password.match(/[0-9]/)) score++;
    if (password.match(/[^a-zA-Z0-9]/)) score++;

    if (score < 2) return 'weak';
    if (score < 4) return 'medium';
    if (score < 5) return 'strong';
    return 'very-strong';
}

function updatePasswordStrengthIndicator(input, strength) {
    const indicator = input.parentNode.querySelector('.password-strength-bar');
    if (!indicator) return;

    // Remove existing classes
    indicator.className = 'password-strength-bar';

    // Add strength class
    indicator.classList.add(`password-strength-${strength}`);
}

// Form Validation Enhancement
function initializeFormValidation() {
    const forms = document.querySelectorAll('form');

    forms.forEach(form => {
        form.addEventListener('submit', function (e) {
            const requiredFields = form.querySelectorAll('[required]');
            let isValid = true;

            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    showFieldError(field, 'This field is required');
                    isValid = false;
                } else {
                    clearFieldError(field);
                }
            });

            if (!isValid) {
                e.preventDefault();
                showFormError('Please fill in all required fields');
            }
        });

        // Real-time validation
        const inputs = form.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            input.addEventListener('blur', function () {
                validateField(this);
            });

            input.addEventListener('input', function () {
                if (this.classList.contains('is-invalid')) {
                    clearFieldError(this);
                }
            });
        });
    });
}

function validateField(field) {
    const value = field.value.trim();

    // Required field validation
    if (field.hasAttribute('required') && !value) {
        showFieldError(field, 'This field is required');
        return false;
    }

    // Email validation
    if (field.type === 'email' && value) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(value)) {
            showFieldError(field, 'Please enter a valid email address');
            return false;
        }
    }

    // Mobile validation
    if (field.name === 'mobile' && value) {
        const mobileRegex = /^\+?[0-9]{1,15}$/;
        if (!mobileRegex.test(value.replace(/\s/g, ''))) {
            showFieldError(field, 'Please enter a valid mobile number');
            return false;
        }
    }

    // Password validation
    if (field.type === 'password' && value) {
        if (value.length < 8) {
            showFieldError(field, 'Password must be at least 8 characters long');
            return false;
        }
    }

    clearFieldError(field);
    return true;
}

function showFieldError(field, message) {
    field.classList.add('is-invalid');

    // Remove existing error message
    const existingError = field.parentNode.querySelector('.invalid-feedback');
    if (existingError) {
        existingError.remove();
    }

    // Add new error message
    const errorDiv = document.createElement('div');
    errorDiv.className = 'invalid-feedback';
    errorDiv.textContent = message;
    field.parentNode.appendChild(errorDiv);
}

function clearFieldError(field) {
    field.classList.remove('is-invalid');

    const errorDiv = field.parentNode.querySelector('.invalid-feedback');
    if (errorDiv) {
        errorDiv.remove();
    }
}

function showFormError(message) {
    // Remove existing form error
    const existingError = document.querySelector('.alert-danger');
    if (existingError) {
        existingError.remove();
    }

    // Add new form error
    const errorDiv = document.createElement('div');
    errorDiv.className = 'alert alert-danger';
    errorDiv.textContent = message;

    const form = document.querySelector('form');
    if (form) {
        form.insertBefore(errorDiv, form.firstChild);

        // Auto-remove after 5 seconds
        setTimeout(() => {
            errorDiv.remove();
        }, 5000);
    }
}

// Loading States for Buttons
function initializeLoadingStates() {
    const forms = document.querySelectorAll('form');

    forms.forEach(form => {
        form.addEventListener('submit', function () {
            const submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.classList.add('loading');
                submitBtn.disabled = true;
            }
        });
    });
}

// Utility Functions
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Enhanced mobile experience
function enhanceMobileExperience() {
    if (window.innerWidth <= 768) {
        // Add touch-friendly styles
        document.body.classList.add('mobile-device');

        // Enhance form inputs for mobile
        const inputs = document.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            input.addEventListener('focus', function () {
                // Scroll to input on mobile
                setTimeout(() => {
                    this.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }, 300);
            });
        });
    }
}

// Initialize mobile enhancements
enhanceMobileExperience();

// Handle window resize
window.addEventListener('resize', debounce(enhanceMobileExperience, 250));

