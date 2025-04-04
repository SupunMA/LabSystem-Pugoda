@extends('layouts.adminLayout')

@section('content')
<div class="container-fluid ">
    <a class="btn btn-danger mb-1" href="{{route('admin.addTest')}}">
        <i class="fa fa-plus" aria-hidden="true"></i>
        <b>Add Test</b>
    </a>
        @include('Users.Admin.messages.deleteMsg')
        {{-- <div class="row"> --}}

            {{-- Client Details form --}}
            @include('Users.Admin.Tests.components.allTestTable')
            
            {{-- Client Password form --}}

        {{-- </div>  --}}
            
            
            

</div>
@endsection

@section('header')
All Requested Tests
@endsection

