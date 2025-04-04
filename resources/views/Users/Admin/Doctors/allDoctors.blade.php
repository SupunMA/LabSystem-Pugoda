@extends('layouts.adminLayout')

@section('content')


<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">

                {{-- button to go to add client --}}
                <a class="btn btn-danger mb-1" href="{{route('admin.addDoctor')}}">
                    <i class="fa fa-plus" aria-hidden="true"></i>
                    <b>Add Doctor</b>
                </a>
                @if(session('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
                @endif
                <!-- Import Table -->
               @include('Users.Admin.Doctors.components.allDoctorsTable')
            
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</section>





@endsection

@section('header')
All Doctors
@endsection
