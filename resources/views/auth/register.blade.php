@extends('layouts.auth')

@section('title', 'Create Account - NotesHub')
@section('page-title', 'Create Account')
@section('page-subtitle', 'Join thousands of students and educators')

@section('auth-content')
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="form-group">
            <label for="name" class="form-label">Full Name</label>
            <input type="text" 
                   id="name" 
                   name="name" 
                   value="{{ old('name') }}" 
                   class="form-control @error('name') error @enderror" 
                   placeholder="Enter your full name"
                   required 
                   autofocus>
            @error('name')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <!-- Email -->
        <div class="form-group">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" 
                   id="email" 
                   name="email" 
                   value="{{ old('email') }}" 
                   class="form-control @error('email') error @enderror" 
                   placeholder="Enter your email"
                   required>
            @error('email')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <!-- Password -->
        <div class="form-group">
            <label for="password" class="form-label">Password</label>
            <input type="password" 
                   id="password" 
                   name="password" 
                   class="form-control @error('password') error @enderror" 
                   placeholder="Create a password"
                   required>
            @error('password')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="form-group">
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <input type="password" 
                   id="password_confirmation" 
                   name="password_confirmation" 
                   class="form-control" 
                   placeholder="Confirm your password"
                   required>
        </div>

        <!-- Terms Agreement -->
        <div class="form-group">
            <label class="remember-me">
                <input type="checkbox" name="terms" required>
                <span>I agree to the <a href="#" class="auth-link">Terms of Service</a> and <a href="#" class="auth-link">Privacy Policy</a></span>
            </label>
            @error('terms')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-user-plus"></i>
            Create Account
        </button>

        <!-- Divider -->
        <div class="auth-divider">
            <span>Or continue with</span>
        </div>

        <!-- Social Login (Optional) -->
        <button type="button" class="btn btn-google mb-4">
            <i class="fab fa-google"></i>
            Continue with Google
        </button>
    </form>

    <!-- Login Link -->
    <div class="auth-links">
        Already have an account? 
        <a href="{{ route('login') }}" class="auth-link">Sign in here</a>
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        const submitBtn = form.querySelector('button[type="submit"]');
        const password = document.getElementById('password');
        const confirmPassword = document.getElementById('password_confirmation');

        // Form submission loading state
        form.addEventListener('submit', function() {
            submitBtn.classList.add('btn-loading');
            submitBtn.disabled = true;
        });

        // Password confirmation validation
        function validatePassword() {
            if (password.value !== confirmPassword.value) {
                confirmPassword.classList.add('error');
            } else {
                confirmPassword.classList.remove('error');
            }
        }

        password.addEventListener('input', validatePassword);
        confirmPassword.addEventListener('input', validatePassword);

        // Input validation styling
        const inputs = form.querySelectorAll('.form-control');
        inputs.forEach(input => {
            input.addEventListener('input', function() {
                if (this.value.trim() !== '') {
                    this.classList.remove('error');
                }
            });
        });
    });
</script>
@endsection