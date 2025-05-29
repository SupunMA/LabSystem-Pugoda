@extends('layouts.userLayout')
{{-- justify-content-center --}}
@section('content')
<div class="container-fluid">

    {{-- Date and Time --}}
    {{-- @foreach ($loanData as $item)
        @include('Users.User.HomeCalculations.components.timeDate')
    @endforeach --}}

    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 ">
            <div class="box box-primary">
                <div class="box-header">



                    <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                <div class="box-body">



                    <!-- Small boxes (Stat box) -->
                    <div class="row">
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-red">
                                <div class="inner">
                                    <h3>{{$pendingCount}}</h3>
                                    <h4>Pending Results</h4>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-medkit" aria-hidden="true"></i>
                                </div>

                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                            <div class="small-box bg-green">
                                <div class="inner">
                                <h3>{{$reportCount}}</h3>
                                <h4>Completed Reports</h4>
                                </div>
                                <div class="icon">
                                    <i class="fa-solid fa-file-pdf"></i>
                                </div>

                            </div>
                        </div>
                        <!-- ./col -->

                    </div>
                    <!-- /.row -->


                    <br>



                    <div class="box">
                        <div class="box-header">
                          <h3 class="box-title">List of Your Reports</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">

                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Report ID</th>
                                        <th>Test Date</th>
                                        <th>Test Name</th>
                                        <th>Price</th>
                                        <th>Status</th>
                                        <th>Action</th>

                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Report ID</th>
                                        <th>Test Date</th>
                                        <th>Test Name</th>
                                        <th>Price</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <!-- /.box-body -->
                    </div>
                      <!-- /.box -->




                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>

</div>
@endsection

@section('header')
Patient Dashboard
@endsection


@push('specificJs')
@endpush
