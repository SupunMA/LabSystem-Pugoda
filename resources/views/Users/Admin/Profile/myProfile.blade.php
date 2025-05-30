@extends('layouts.adminLayout')

@section('content')
<div class="container-fluid ">


    {{-- @if(session('message'))
    <div class="alert alert-success">
        {{ session('message') }}
    </div>
    @endif --}}

@if(session('message'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('message') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif


<!-- Alternative: If you prefer to show all errors at once at the top -->
@if ($errors->any())
    <div class="alert alert-danger">
        <h6>Please fix the following errors:</h6>
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
   <h3> Update the Account Details</h3>
    <form action="{{route('admin.updateAdmin')}}" method="post">
        @csrf
        <div class="row">

            {{-- Client Details form --}}
            @include('Users.Admin.Profile.components.myProfileDetails')
        </div>
        <div class="row">

            {{-- Client Password form --}}
            @include('Users.Admin.Profile.components.profilePWD')


        </div>
</form>
        <div class="row">
            @include('Users.Admin.Profile.components.profileDelete')
        </div>


    {{-- End of Row --}}


    {{-- End of Form --}}


</div>
@endsection

@section('header')
My Profile
@endsection
