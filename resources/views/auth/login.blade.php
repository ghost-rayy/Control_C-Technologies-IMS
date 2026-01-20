@extends('layouts.app')

@section('title', 'Login | Control C-Technology')

@section('content')
<div class="auth-container">

    {{-- LEFT : LOGIN FORM --}}
    <div class="auth-left">
        <div class="auth-form">
            <h2 class="login-title">Login</h2>

            @if($errors->any())
                <div class="alert alert-danger small">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="field">
                    <input type="email"
                           name="email"
                           placeholder="Email"
                           value="{{ old('email') }}"
                           class="form-input"
                           required autofocus>
                </div>

                <div class="field">
                    <input type="password"
                           id="password"
                           name="password"
                           placeholder="Password"
                           class="form-input"
                           required>
                </div>

                <div class="form-footer">
                    <a href="#" class="link-text">Don't have account ? sign up</a>
                    <a href="#" class="link-text">Forgot Password ?</a>
                </div>

                <button type="submit" class="btn-login">
                    LOGIN
                </button>
            </form>

        </div>
    </div>

    {{-- RIGHT : ANIMATED LOGO --}}
    <div class="auth-right">
        <div class="logo-area">
            <div class="laptop">
                <div class="screen">
                    <span id="typed-text"></span>
                </div>
                <div class="base"></div>

                <div class="auth-header">
                    <h2>Inventory & Sales Management System</h2>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
