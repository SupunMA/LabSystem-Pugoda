@extends('layouts.adminLayout')

@section('content')
<div class="container-fluid ">
    <a class="btn btn-primary mb-1" href="{{route('admin.allTest')}}">
        <i class="fa fa-th-list" aria-hidden="true"></i>
        <b>Requested SendOut Tests</b>
    </a>

    {{-- <div class="row"> --}}

        @include('Users.Admin.RequestedTests.components.onSiteReqTestList')

    {{-- </div> --}}



</div>
@endsection

@section('header')
Requested OnSite Tests
@endsection
