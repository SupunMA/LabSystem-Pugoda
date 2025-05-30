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
                        <div class="col-lg-4 col-md-6 col-sm-6 col-6">
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
                        <div class="col-lg-4 col-md-6 col-sm-6 col-6">
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
                                        <th>Action</th>
                                        <th>Status</th>
                                        {{-- <th>Price</th> --}}

                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($reportsData) && count($reportsData) > 0)
                                        @foreach($reportsData as $report)
                                        <tr>
                                            <td><strong>{{ $report['formatted_report_id'] }}</strong></td>
                                            <td>{{ $report['test_date'] }}</td>
                                            <td>{{ $report['test_name'] }}</td>
                                            <td>
                                                @if($report['action'] == 'Download' && $report['file_path'])
                                                    <a href="{{ route('patient.view.report', $report['report_id']) }}" class="btn btn-warning btn-sm" target="_blank" title="View Report in New Tab">
                                                            <i class="fa fa-eye"></i> View
                                                    </a>
                                                    <a href="{{ route('patient.download.report', $report['report_id']) }}"
                                                       class="btn btn-primary btn-sm download-btn"
                                                       title="Download Report"
                                                       data-report-id="{{ $report['report_id'] }}">
                                                        <span class="btn-text">
                                                            <i class="fa fa-download"></i> Download PDF
                                                        </span>
                                                        <span class="btn-loading" style="display: none;">
                                                            <i class="fa fa-spinner fa-spin"></i> Downloading...
                                                        </span>
                                                    </a>
                                                @elseif($report['action'] == 'Download')
                                                    <a href="{{ route('patientReportsOnSite.download', $report['report_id']) }}"
                                                       class="btn btn-primary btn-sm download-btn"
                                                       title="Download Report"
                                                       data-report-id="{{ $report['report_id'] }}">
                                                        <span class="btn-text">
                                                            <i class="fa fa-download"></i> Download PDF
                                                        </span>
                                                        <span class="btn-loading" style="display: none;">
                                                            <i class="fa fa-spinner fa-spin"></i> Downloading...
                                                        </span>
                                                    </a>
                                                @else
                                                <span class="text-muted">
                                                    <i class="fa fa-hourglass-half"></i> {{ $report['action'] }}
                                                </span>
                                                @endif
                                            </td>
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
                                            {{-- <td>Rs. {{ $report['price'] }}</td> --}}
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
                                        <th>Action</th>
                                        <th>Status</th>
                                        {{-- <th>Price</th> --}}
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
Patient Dashboard - HorizonLab.lk
@endsection

@push('specificCss')
<style>
/* Download button loading animation styles */
.download-btn {
    position: relative;
    transition: all 0.3s ease;
}

.download-btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

.btn-text, .btn-loading {
    transition: opacity 0.3s ease;
}

.download-btn.loading {
    pointer-events: none;
}

.download-btn.loading .btn-text {
    opacity: 0;
}

.download-btn.loading .btn-loading {
    opacity: 1;
}

/* Spinner animation */
@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.fa-spin {
    animation: spin 1s linear infinite;
}

/* Pulse effect for better visual feedback */
.download-btn.loading {
    animation: pulse 1.5s ease-in-out infinite;
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}
</style>
@endpush

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

    // Download button animation handler
    $('.download-btn').on('click', function(e) {
        const $btn = $(this);
        const $btnText = $btn.find('.btn-text');
        const $btnLoading = $btn.find('.btn-loading');

        // Show loading state
        $btn.addClass('loading');
        $btn.prop('disabled', true);
        $btnText.hide();
        $btnLoading.show();

        // Create a hidden iframe for download
        const downloadUrl = $btn.attr('href');
        const iframe = $('<iframe>').hide().appendTo('body');

        // Handle download completion
        iframe.on('load', function() {
            // Reset button state after a short delay
            setTimeout(function() {
                $btn.removeClass('loading');
                $btn.prop('disabled', false);
                $btnText.show();
                $btnLoading.hide();
                iframe.remove();
            }, 2000); // 2 seconds delay to show completion
        });

        // Start download
        iframe.attr('src', downloadUrl);

        // Fallback: Reset button after 5 seconds if no load event
        setTimeout(function() {
            if ($btn.hasClass('loading')) {
                $btn.removeClass('loading');
                $btn.prop('disabled', false);
                $btnText.show();
                $btnLoading.hide();
                iframe.remove();
            }
        }, 5000);

        // Prevent default link behavior
        e.preventDefault();
        return false;
    });
});
</script>
@endpush
