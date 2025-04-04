<div class="box">
    <div class="box-header">
      <h3 class="box-title">List of Patients</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">

        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Available Test Name</th>
                    <th>Categories</th>
                    <th>Days</th>
                    <th>Cost</th>
                    <th>Action</th>

                </tr>
            </thead>
            <tbody>

                @foreach ($AvailableTests as $AvailableTest)
                    <tr>
                        <td>{{$AvailableTest->tlid}}</td>
                        <td>{{$AvailableTest->AvailableTestName}}</td>
                        <td><ul>
                        @foreach ($AvailableTestsSubcategory as $Subcategory)
                            @if ($AvailableTest->tlid == $Subcategory->AvailableTestID)

                                <li> {{$Subcategory->SubCategoryName}}</li>

                               <br>
                            @endif
                        @endforeach
                            </ul>
                        </td>
                        <td>{{$AvailableTest->resultDays}} days</td>
                        <td>{{$AvailableTest->AvailableTestCost}}</td>


                        <td>
                            <a class="btn btn-warning" type="button" data-toggle="modal" data-target="#branchEditModal-{{$AvailableTest->tlid}}" >
                                <i class="fa fa-pencil" aria-hidden="true"></i>
                            </a>
                            <a class="btn btn-danger" type="button" data-toggle="modal" data-target="#branchDeleteModal-{{$AvailableTest->tlid}}"  >
                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                            </a>
                        </td>
                    </tr>

                            {{-- update modal and delete modal --}}
                            @include('Users.Admin.AvailableTests.components.updateTest')
                            @include('Users.Admin.AvailableTests.components.deleteTest')
                @endforeach

            </tbody>
            <tfoot>
                <tr>
                    <th>ID</th>
                    <th>Available Test Name</th>
                    <th>Categories</th>
                    <th>Days</th>
                    <th>Cost</th>
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

<script>
    $(document).ready(function() {
        $('#normal_range').inputmask('99-999', {
            placeholder: ' ', // Space as a placeholder for each digit
        });
    });
</script>

@endpush




