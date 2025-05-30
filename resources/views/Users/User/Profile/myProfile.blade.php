@extends('layouts.userLayout')

@section('content')
<div class="container-fluid ">


    {{-- @include('Users.Admin.messages.addMsg') --}}
                        <!-- Success Message -->
                    @if(session('message'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('message') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Error Message -->
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Validation Errors Summary (Optional) -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <h6><i class="fas fa-exclamation-circle me-2"></i>Please fix the following errors:</h6>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

   <h3> Update the Account Details</h3>

        <div class="row">



            {{-- Client Password form --}}
            @include('Users.User.Profile.components.profilePWD')


            @include('Users.User.Profile.components.profileDelete')

        </div>




    {{-- End of Row --}}


    {{-- End of Form --}}


</div>
@endsection

@section('header')
My Profile
@endsection
