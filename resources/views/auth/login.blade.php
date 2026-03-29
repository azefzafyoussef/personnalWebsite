@extends('layouts.auth')

@section('title', 'Login - Youssef.sec')
@section('page-title', 'Welcome Back')
@section('page-subtitle', 'Sign in to your account to continue')

@section('auth-content')
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email -->
        <div class="form-group">
            <label for="email" class="form-label">Email Address</label>
            <input type="email"
                   id="email"
                   name="email"
                   value="{{ old('email') }}"
                   class="form-control @error('email') error @enderror"
                   placeholder="Enter your email"
                   required
                   autofocus>
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
                   placeholder="Enter your password"
                   required>
            @error('password')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="form-remember">
            <label class="remember-me">
                <input type="checkbox" name="remember">
                <span>Remember me</span>
            </label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="forgot-password">
                    Forgot Password?
                </a>
            @endif
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">
            <i class="fas p-2 fa-sign-in-alt"></i>
            Sign In
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

    <!-- Sign Up Link -->
    <div class="auth-links">
        Don't have an account?
        <a href="{{ route('register') }}" class="auth-link">Create one here</a>
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add loading state to form submission
        const form = document.querySelector('form');
        const submitBtn = form.querySelector('button[type="submit"]');

        form.addEventListener('submit', function() {
            submitBtn.classList.add('btn-loading');
            submitBtn.disabled = true;
        });

        // Add input validation styling
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
