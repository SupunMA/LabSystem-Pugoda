@extends('layouts.adminLayout')

@section('content')
<div class="container-fluid ">
    <a class="btn btn-danger mb-1" href="{{route('admin.allTest')}}">
        <i class="fa fa-th-list" aria-hidden="true"></i>
        <b>View Requested Tests</b>
    </a>
        
    <div class="row">

        @include('Users.Admin.Tests.components.newTestDetails')
        
    </div> 
            


</div>
@endsection

@section('header')
Add New Test
@endsection