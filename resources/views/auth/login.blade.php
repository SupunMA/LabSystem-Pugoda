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

                        {{-- NIC Field --}}
                        <div class="form-group has-feedback">
                            <input type="text" name="nic" class="form-control @error('nic') is-invalid @enderror" placeholder="NIC Number" value="{{ old('nic') }}" required>
                            <span class="glyphicon glyphicon-user form-control-feedback"></span>
                            @error('nic')
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

                        <div class="row">
                            <div class="col-xs-4">
                                <button type="submit" id="loginButton" class="btn btn-primary btn-block btn-flat">Sign In</button>
                            </div>
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
