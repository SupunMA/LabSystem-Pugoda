@extends('layouts.layout')

@section('content')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-9 col-11 text-center ">
            <div class="login-box">
                <div class="login-logo">
                  <a href="{{ route('login') }}"><b>MediHelp</b> Lab</a>
                </div>
                <!-- /.login-logo -->
                <div class="login-box-body">
                  <p class="login-box-msg">Sign in to start your session</p>
              
                  <form action="{{ route('login') }}" method="post">
                    @csrf
                    {{-- Message --}}
                    @if (\Session::has('message')) 
                        <ul class="alert alert-danger" role="alert">
                            <li>{!! \Session::get('message') !!}</li>
                        </ul>
                    @endif
                    <div class="form-group has-feedback">
                      <input type="email" class="form-control" placeholder="Email" name="email">
                      <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                      <input type="password" class="form-control" placeholder="Password" name="password" required autocomplete="current-password">
                      <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <div class="row">
                      
                      <div class="col-xs-4">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
                      </div>
                      <!-- /.col -->
                    </div>
                  </form>
              
                 
              
            
                  {{-- <a href="{{ route('register2') }}" class="text-center">Register a new membership</a> --}}
              
                </div>
                <!-- /.login-box-body -->
              </div>
              <!-- /.login-box -->
        </div>
    </div>
</div>



@endsection




