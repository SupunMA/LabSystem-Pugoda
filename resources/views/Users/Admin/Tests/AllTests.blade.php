@extends('layouts.adminLayout')

@section('content')
<div class="container-fluid ">
    <a class="btn btn-primary mb-1" href="{{route('admin.addTest')}}">
        <i class="fa fa-th-list" aria-hidden="true"></i>
        <b>Requested OnSite Tests</b>
    </a>
        {{-- <div class="row"> --}}

            {{-- Client Details form --}}
            @include('Users.Admin.Tests.components.allTestTable')

            {{-- Client Password form --}}

        {{-- </div>  --}}




</div>
@endsection

@section('header')
Requested SendOut Tests
@endsection

