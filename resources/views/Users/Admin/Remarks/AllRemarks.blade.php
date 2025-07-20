@extends('layouts.adminLayout')

@section('content')
<div class="container-fluid ">
      <a class="btn btn-danger mb-1" href="#" data-toggle="modal" data-target="#addRemarkModal">
        <i class="fa fa-plus" aria-hidden="true"></i>
        <b>Add Remark</b>
    </a>

        {{-- <div class="row"> --}}

            {{-- remark table --}}
            @include('Users.Admin.Remarks.components.allRemarksTable')

        {{-- </div>  --}}

</div>
@endsection

@section('header')
All Remarks
@endsection
