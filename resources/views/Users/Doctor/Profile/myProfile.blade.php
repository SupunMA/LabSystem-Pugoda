@extends('layouts.doctorLayout')

@section('content')
<div class="container-fluid ">


    @include('Users.Admin.messages.addMsg')

   <h3> Update the Account Details</h3>

        <div class="row">



            {{-- Client Password form --}}
            @include('Users.Doctor.Profile.components.profilePWD')


            @include('Users.Doctor.Profile.components.profileDelete')

        </div>




    {{-- End of Row --}}


    {{-- End of Form --}}


</div>
@endsection

@section('header')
My Profile
@endsection
