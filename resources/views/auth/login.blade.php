@extends('layouts.layout')

@section('content')

<style>
    /* Loading animation */
    .loader-container {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(255, 255, 255, 0.8);
        z-index: 9999;
        justify-content: center;
        align-items: center;
    }

    .loader {
        border: 5px solid #f3f3f3;
        border-top: 5px solid #3498db;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        animation: spin 1s linear infinite;
    }

    .loader-text {
        margin-top: 15px;
        font-weight: bold;
        color: #3498db;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Custom login form styling */
    .login-info-text {
        font-size: 12px;
        color: #666;
        margin-top: 5px;
        text-align: left;
    }

    .form-row {
        margin-bottom: 15px;
        width: 100%;
    }

    .checkbox-container {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
    }

    .checkbox-container input[type="checkbox"] {
        margin-right: 8px;
    }

    .btn-signin {
        width: 100%;
        padding: 10px;
        background-color: #007bff;
        border: none;
        color: white;
        font-weight: bold;
        border-radius: 3px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .btn-signin:hover {
        background-color: #0053cf;
    }
</style>

<div class="container">
    <!-- Loading overlay -->
    <div class="loader-container" id="loaderContainer">
        <div class="text-center">
            <div class="loader"></div>
            <div class="loader-text">Please Wait...</div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-9 col-11 text-center">
            <div class="login-box">
                <div class="login-logo">
                    <a href="{{ route('login') }}"><b>Horizon</b> Lab</a>
                </div>
                <div class="login-box-body">
                    <p class="login-box-msg">Log in to Access Your Account.</p>

                    <form id="loginForm" action="{{ route('login') }}" method="post">
                        @csrf

                        {{-- Global session error --}}
                        @if(session('message'))
                            <div class="alert alert-danger">
                                {{ session('message') }}
                            </div>
                        @endif

                        {{-- Identifier Field (NIC or Mobile) --}}
                        <div class="form-group has-feedback">
                            <input type="text" name="identifier" class="form-control @error('identifier') is-invalid @enderror @error('nic') is-invalid @enderror @error('mobile') is-invalid @enderror"
                                   placeholder="NIC or Phone Number" value="{{ old('identifier') ?: old('nic') ?: old('mobile') }}" required>
                            <span class="glyphicon glyphicon-user form-control-feedback"></span>
                            @error('identifier')
                                <span class="text-danger" role="alert">
                                    <small>{{ $message }}</small>
                                </span>
                            @enderror
                            @error('nic')
                                <span class="text-danger" role="alert">
                                    <small>{{ $message }}</small>
                                </span>
                            @enderror
                            @error('mobile')
                                <span class="text-danger" role="alert">
                                    <small>{{ $message }}</small>
                                </span>
                            @enderror
                        </div>

                        {{-- Password Field --}}
                        <div class="form-group has-feedback">
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" required autocomplete="current-password">
                            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                            @error('password')
                                <span class="text-danger" role="alert">
                                    <small>{{ $message }}</small>
                                </span>
                            @enderror
                        </div>

                        {{-- Remember Me Checkbox Row --}}
                        {{-- <div class="form-row">
                            <div class="checkbox-container">
                                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label for="remember">Remember Me</label>
                            </div>
                        </div> --}}

                        {{-- Sign In Button Row --}}
                        <div class="form-row">
                            <button type="submit" id="loginButton" class="btn-signin">Sign In</button>
                        </div>
                    </form>

                    {{-- Optional: Register --}}
                    {{-- <a href="{{ route('register') }}" class="text-center">Register a new membership</a> --}}
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const loginForm = document.getElementById('loginForm');
        const loaderContainer = document.getElementById('loaderContainer');

        loginForm.addEventListener('submit', function(e) {
            // Show loader
            loaderContainer.style.display = 'flex';

            // Allow form submission to continue
            // The loader will be visible until the page redirects
        });
    });
</script>

@endsection
