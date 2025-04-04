@extends('layouts.adminLayout')

@section('content')
<div class="container-fluid ">
    <a class="btn btn-danger mb-1" href="{{route('admin.addAvailableTest')}}">
        <i class="fa fa-plus" aria-hidden="true"></i>
        <b>Add Available Test</b>
    </a>
        @include('Users.Admin.messages.deleteMsg')
        {{-- <div class="row"> --}}

            {{-- Client Details form --}}
            @include('Users.Admin.AvailableTests.components.allTestTable')
           
            {{-- Client Password form --}}

        {{-- </div>  --}}
            
            
            

</div>
@endsection

@section('header')
All Available Tests
@endsection