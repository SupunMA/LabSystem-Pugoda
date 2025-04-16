@extends('layouts.adminLayout')

@section('content')
<div class="container-fluid ">

    {{-- button to go to all clients --}}
    <a class="btn btn-danger mb-1" href="{{route('admin.allPatient')}}">
        <i class="fa fa-th-list" aria-hidden="true"></i>
        <b> View All Patients</b>
    </a>
    @if(session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
    <form id="patient-form" method="POST">
        @csrf
        <div class="row">

            {{-- Client Details form --}}
            @include('Users.Admin.Patients.components.newPatientDetails')

            {{-- Client Password form --}}
            @include('Users.Admin.Patients.components.PatientPWD')


        </div>
    </form>
    {{-- End of Row --}}


    {{-- End of Form --}}


</div>
@endsection

@section('header')
Add New Patient
@endsection
