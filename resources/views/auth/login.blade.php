@extends('layouts.guest')

@section('title', 'Login | Control C-Technology')

@section('content')
<style>
:root {
    --primary-green: #22c55e;
    --primary-green-hover: #16a34a;
    --text-navy: #1e293b;
    --text-muted: #64748b;
    --bg-light: #f8fafc;
    --border-color: #e2e8f0;
}

body {
    background-color: var(--bg-light);
    font-family: 'Inter', sans-serif;
}

.login-container {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
}

.login-card {
    width: 100%;
    max-width: 440px;
    background: #ffffff;
    border-radius: 24px;
    padding: 40px;
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
}

.shield-icon-box {
    /* width: 164px;
    height: 164px; */
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 24px;
    color: white;
    font-size: 28px;
}

.login-header {
    text-align: center;
    margin-bottom: 32px;
}

.login-header h2 {
    font-size: 1.25rem;
    font-weight: 800;
    color: var(--text-navy);
    margin-bottom: 12px;
}

.login-header h3 {
    font-size: 1rem;
    font-weight: 700;
    color: var(--text-navy);
    margin-bottom: 4px;
}

.login-header p {
    font-size: 0.85rem;
    color: var(--text-muted);
    margin-bottom: 0;
}

.form-label {
    font-size: 13px;
    font-weight: 600;
    color: var(--text-navy);
    margin-bottom: 8px;
}

.input-icon-group {
    position: relative;
    margin-bottom: 20px;
}

.input-icon-group i {
    position: absolute;
    left: 16px;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    font-size: 16px;
}

.input-icon-group .form-control {
    padding-left: 44px;
    padding-top: 12px;
    padding-bottom: 12px;
    border-radius: 12px;
    border: 1px solid var(--border-color);
    font-size: 14px;
    transition: all 0.2s;
}

.input-icon-group .form-control:focus {
    border-color: var(--primary-green);
    box-shadow: 0 0 0 4px rgba(34, 197, 94, 0.1);
}

.password-toggle {
    position: absolute;
    right: 16px;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    cursor: pointer;
    font-size: 16px;
}

.form-options {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 24px;
    font-size: 13px;
}

.forgot-link {
    color: var(--primary-green);
    text-decoration: none;
    font-weight: 600;
}

.forgot-link:hover {
    color: var(--primary-green-hover);
}

.btn-signin {
    width: 100%;
    background-color: var(--primary-green);
    border: none;
    padding: 12px;
    border-radius: 12px;
    color: white;
    font-weight: 700;
    font-size: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    transition: all 0.2s;
}

.btn-signin:hover {
    background-color: var(--primary-green-hover);
    transform: translateY(-1px);
}

.divider {
    text-align: center;
    position: relative;
    margin: 24px 0;
}

.divider::before {
    content: '';
    position: absolute;
    left: 0;
    top: 50%;
    width: 100%;
    height: 1px;
    background-color: var(--border-color);
    z-index: 1;
}

.divider span {
    position: relative;
    z-index: 2;
    background-color: #fff;
    padding: 0 12px;
    font-size: 12px;
    color: var(--text-muted);
}

.btn-social {
    width: 100%;
    background: #fff;
    border: 1px solid var(--border-color);
    padding: 10px;
    border-radius: 12px;
    font-size: 14px;
    font-weight: 600;
    color: #475569;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    margin-bottom: 12px;
    transition: background 0.2s;
}

.btn-social:hover {
    background-color: #f8fafc;
}

.create-account {
    text-align: center;
    margin-top: 24px;
    font-size: 13px;
    color: var(--text-muted);
}

.create-account a {
    color: var(--primary-green);
    text-decoration: none;
    font-weight: 700;
}

.login-footer {
    text-align: center;
    margin-top: 32px;
    font-size: 11px;
    color: var(--text-muted);
}

.alert-modern {
    background-color: #fef2f2;
    border: 1px solid #fee2e2;
    color: #991b1b;
    border-radius: 12px;
    padding: 12px;
    font-size: 13px;
    margin-bottom: 20px;
}
</style>

<div class="login-container">
    <div class="login-card">
        <div class="shield-icon-box">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" width="180" height="64">
        </div>

        <div class="login-header">
            <!-- <h2>Control C-Technology</h2> -->
            <h3>Welcome back</h3>
            <p>Sign in to continue to your account</p>
        </div>

        @if($errors->any())
            <div class="alert-modern">
                <i class="bi bi-exclamation-circle-fill me-2"></i> {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <div class="input-icon-group">
                    <i class="bi bi-envelope"></i>
                    <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email" value="{{ old('email') }}" required autofocus>
                </div>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <div class="input-icon-group">
                    <i class="bi bi-lock"></i>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password" required>
                    <i class="bi bi-eye password-toggle"></i>
                </div>
            </div>

            <div class="form-options">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label text-muted" for="remember">
                        Remember me
                    </label>
                </div>
                <a href="#" class="forgot-link">Forgot password?</a>
            </div>

            <button type="submit" class="btn-signin">
                <i class="bi bi-box-arrow-in-right"></i> Sign in
            </button>
        </form>

        <!-- <div class="divider">
            <span>or</span>
        </div>

        <button type="button" class="btn-social">
            <img src="https://www.gstatic.com/images/branding/product/1x/gsa_512dp.png" width="18" alt="Google"> Continue with Google
        </button>

        <button type="button" class="btn-social">
            <svg width="18" height="18" viewBox="0 0 23 23" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0 0H11V11H0V0Z" fill="#F25022"/><path d="M12 0H23V11H12V0Z" fill="#7FBA00"/><path d="M0 12H11V23H0V12Z" fill="#00A4EF"/><path d="M12 12H23V23H12V12Z" fill="#FFB900"/></svg>
            Continue with Microsoft
        </button>

        <div class="create-account">
            Don't have an account? <a href="#">Create account</a>
        </div> -->

        <div class="login-footer">
            &copy; {{ date('Y') }} Control C-Technology. All rights reserved.
        </div>
    </div>
</div>
@endsection
