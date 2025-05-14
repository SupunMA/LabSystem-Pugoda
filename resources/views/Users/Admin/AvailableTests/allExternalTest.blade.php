@extends('layouts.adminLayout')

@section('content')
<div class="container-fluid ">
    <a class="btn btn-danger mb-1" href="{{route('admin.addAvailableTest')}}">
        <i class="fa fa-plus" aria-hidden="true"></i>
        <b>Add External Available Test</b>
    </a>

        {{-- <div class="row"> --}}

            {{-- Client Details form --}}
            

            {{-- Client Password form --}}

        {{-- </div>  --}}




</div>
@endsection

@section('header')
All External Available Tests
@endsection
