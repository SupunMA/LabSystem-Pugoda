@extends('layouts.layout')

@section('content')
<div class="container">
    <div class="col-12">
        <form method="POST" action="{{ route('registering') }}">
                @csrf
            <div class="row">
                <div class="col-lg-6 col-12 ">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Add Your Details</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                
                        <div class="card-body">
                            @include('Users.Admin.messages.addMsg')
                
                            <div class="form-group">
                                <label >Name</label>
                                <input type="name" name="name" class="form-control" id="name" placeholder="Enter Name">
                            </div>
                {{-- Gender and DOB --}}
                            
                            <div class="row">
                                
                                <div class="col-lg-6 col-12">
                                    <div class="form-group">
                                        <label >Email Address</label>
                                        <input type="email" class="form-control" name="email" placeholder="Email Address">
                                    </div>
                                </div>
                
                
                            </div>
                
                            
                        {{-- Role value --}}
                        <input name="role" type="hidden" value="1">
                    </div>
                        <!-- /.card-body -->
                
                
                
                </div>
            </div>



                                {{-- Start of Second Card --}}

            <div class="col-lg-6 col-12">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Create Password</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->

                    <div class="card-body">

                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Password</label>
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Confirm the Password</label>
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                        </div>


                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <div class="form-group">
                            <small class="form-text text-muted text-right">Please check details again.</small>
                            <button type="submit" class="btn btn-danger btn-lg float-right"><b>&nbsp; Save All&nbsp;</b>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>             
@endsection
