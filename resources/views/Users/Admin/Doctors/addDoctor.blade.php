@extends('layouts.adminLayout')

@section('content')
<div class="container-fluid ">

    {{-- button to go to all clients --}}
    <a class="btn btn-danger mb-1" href="{{route('admin.allDoctor')}}">
        <i class="fa fa-th-list" aria-hidden="true"></i>
        <b>View All Doctors</b>
    </a>
    @if(session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
    <form action="{{route('admin.addingDoctor')}}" method="post">
        @csrf
        <div class="row">

            {{-- Client Details form --}}
            @include('Users.Admin.Doctors.components.newDoctorDetails')

            {{-- Client Password form --}}
            @include('Users.Admin.Doctors.components.doctorPWD')

        </div>
    </form>
    {{-- End of Row --}}


    {{-- End of Form --}}


</div>
@endsection

@section('header')
Register Doctor
@endsection
