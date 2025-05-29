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
                                    <h4>Pending Reports</h4>
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

                            <table id="reportsTable" class="table table-bordered table-striped">
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
                                    @if(isset($reportsData) && count($reportsData) > 0)
                                        @foreach($reportsData as $report)
                                        <tr>
                                            <td><strong>{{ $report['formatted_report_id'] }}</strong></td>
                                            <td>{{ $report['test_date'] }}</td>
                                            <td>{{ $report['test_name'] }}</td>
                                            <td>Rs. {{ $report['price'] }}</td>
                                            <td>
                                                @if($report['status'] == 'Completed')
                                                    <span class="badge bg-success">
                                                        <i class="fa fa-check"></i> {{ $report['status'] }}
                                                    </span>
                                                @else
                                                    <span class="badge bg-warning">
                                                        <i class="fa fa-clock-o"></i> {{ $report['status'] }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($report['action'] == 'Download' && $report['file_path'])
                                                    <a href="{{ route('patient.view.report', $report['report_id']) }}"
                                                    class="btn btn-info btn-sm"
                                                    target="_blank"
                                                    title="View Report in New Tab">
                                                        <i class="fa fa-eye"></i> View PDF
                                                    </a>
                                                    <a href="{{ route('patient.download.report', $report['report_id']) }}"
                                                    class="btn btn-primary btn-sm"
                                                    title="Download Report">
                                                        <i class="fa fa-download"></i> Download PDF
                                                    </a>
                                                @elseif($report['action'] == 'Download')
                                                    <button class="btn btn-info btn-sm"
                                                            onclick="viewResults({{ $report['report_id'] }})"
                                                            title="View Test Results">
                                                        <i class="fa fa-eye"></i> View Results
                                                    </button>
                                                @else
                                                    <span class="text-muted">
                                                        <i class="fa fa-hourglass-half"></i> {{ $report['action'] }}
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6" class="text-center">No reports found</td>
                                        </tr>
                                    @endif
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
<script>
$(function () {
    $('#reportsTable').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
        "order": [[0, 'desc']], // Default sort by Report ID descending
        "dom": '<"row"<"col-sm-6"f><"col-sm-6"l>>rt<"row"<"col-sm-5"i><"col-sm-7"p>><"clear">', // Custom DOM layout
        "columnDefs": [
            {
                "type": "string",
                "targets": 0 // Ensure proper sorting of formatted report IDs
            }
        ],
        "language": {
            "search": "_INPUT_",
            "searchPlaceholder": "Search reports..."
        }
    });
});
</script>
@endpush
