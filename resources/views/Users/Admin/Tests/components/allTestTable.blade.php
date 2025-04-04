<div class="box">
    <div class="box-header">
      <h3 class="box-title">List of Tests</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">

        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Test ID</th>
                    <th>Patient Name</th>
                    <th>Selected Test</th>
                    <th>Date</th>
                    <th>Cost</th>
                    <th>Doctor</th>
                    <th>Action</th>

                </tr>
            </thead>
            <tbody>

                @foreach ($allTestData as $TestData)
                    <tr>
                        <td>{{$TestData->tid}}</td>
                        <td>{{$TestData->name}}</td>
                        <td>{{$TestData->AvailableTestName}}</td>
                        <td>{{$TestData->date}}</td>
                        <td>{{$TestData->AvailableTestCost}}</td>
                        <td>{{$TestData->doctorName}}</td>


                        <td>
                            <a class="btn btn-warning" type="button" data-toggle="modal" data-target="#branchEditModal-{{$TestData->tid}}" >
                                <i class="fa fa-pencil" aria-hidden="true"></i>
                            </a>
                            <a class="btn btn-danger" type="button" data-toggle="modal" data-target="#branchDeleteModal-{{$TestData->tid}}"  >
                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                            </a>

                            <a class="btn btn-success" type="button" href="test/view/{{$TestData->tid}}" target="_blank">
                                <i class="fa fa-cloud-download" aria-hidden="true"></i> Download
                            </a>
                        </td>
                    </tr>

                            {{-- update modal and delete modal --}}
                            @include('Users.Admin.Tests.components.updateTest')
                            @include('Users.Admin.Tests.components.deleteTest')
                @endforeach

            </tbody>
            <tfoot>
                <tr>
                    <th>Test ID</th>
                    <th>Patient Name</th>
                    <th>Selected Test</th>
                    <th>Date</th>
                    <th>Cost</th>
                    <th>Doctor</th>
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
