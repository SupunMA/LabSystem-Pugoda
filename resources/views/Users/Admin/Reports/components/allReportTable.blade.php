<div class="box">
    <div class="box-header">
      <h3 class="box-title">List of Reports</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">

        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Report ID</th>
                    <th>Patient Name</th>
                    <th>Test Name</th>
                    <th>Result</th>

                    <th>Action</th>

                </tr>
            </thead>
            <tbody>

                @foreach ($allReportData->unique('rid') as $data)
                        <tr>
                            <td>{{$data->rid}} </td>
                            <td>{{$data->name}}</td>
                            <td>{{$data->AvailableTestName}}</td>
                            <td>
                                @php
                                    $resultArray = explode(',', $data->result);
                                @endphp

                                    {{-- @foreach ($allReportData->unique('AvailableTestID') as $data2)
                                        {{1}}
                                    @endforeach --}}

                                @foreach ($allReportData->unique('sub_id') as $data2)
                                    @if ($data->AvailableTestID == $data2->AvailableTestID)
                                        {{$data2->SubCategoryName}} :-
                                        @foreach($resultArray as $result)
                                            {{$result}} ({{$data2->Units}}) -
                                            @if ($result < $data2->SubCategoryRangeMin || $result > $data2->SubCategoryRangeMax)
                                            <b>Abnormal</b>
                                            @else
                                            <b>Normal</b>
                                            @endif
                                            <br>
                                            @php
                                                array_shift($resultArray);
                                            @endphp
                                        @break
                                        @endforeach
                                    @endif
                                @endforeach

                            </td>




                            <td>
                                {{-- <a class="btn btn-warning" type="button" data-toggle="modal" data-target="#branchEditModal-{{$data->rid}}" >
                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                </a> --}}
                                <a class="btn btn-danger" type="button" data-toggle="modal" data-target="#branchDeleteModal-{{$data->rid}}"  >
                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                </a>

                                <a class="btn btn-success" type="button" href="report/view/{{$data->rid}}" target="_blank">
                                    <i class="fa fa-cloud-download" aria-hidden="true"></i> Download
                                </a>
                            </td>
                        </tr>

                                {{-- update modal and delete modal --}}
                                {{-- @include('Users.Admin.Reports.components.updateReport') --}}
                                @include('Users.Admin.Reports.components.deleteReport')
                                {{-- @include('Users.Admin.Reports.components.invoice-print')  --}}
                @endforeach

            </tbody>
            <tfoot>
                <tr>
                    <th>Report ID</th>
                    <th>Patient Name</th>
                    <th>Test Name</th>
                    <th>Result</th>

                    <th>Action</th>
                </tr>
            </tfoot>
        </table>
    </div>
    <!-- /.box-body -->
</div>
  <!-- /.box -->


@push('specificJs')
{{-- toastr msg --}}

<script>
    $(function () {
    $('#example1').DataTable()
    })
</script>



@endpush
