@extends('layouts.layout')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-9 col-11 text-center">
            <div class="login-box">
                <div class="login-logo">
                    <a href="{{ route('login') }}"><b>MediHelp</b> Lab</a>
                </div>
                <div class="login-box-body">
                    <p class="login-box-msg">Sign in to start your session</p>

                    <form action="{{ route('login') }}" method="post">
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
                                <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
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

@endsection
