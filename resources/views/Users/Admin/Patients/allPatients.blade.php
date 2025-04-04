@extends('layouts.adminLayout')

@section('content')


<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">

                @if(session('message'))
                    <div class="alert alert-success">
                        {{ session('message') }}
                    </div>
                @endif
                

                {{-- button to go to add client --}}
                <a class="btn btn-danger mb-1" href="{{route('admin.addPatient')}}">
                    <i class="fa fa-plus" aria-hidden="true"></i>
                    <b>Add New Patient</b>
                </a>

                <!-- Import Table -->
               @include('Users.Admin.Patients.components.allPatientTable')
            
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

    </div>
    <!-- /.container-fluid -->
</section>





@endsection

@section('header')
All Patients
@endsection
