<div class="box">
  <div class="box-header">
    {{-- <h3 class="box-title">List of Patients</h3> --}}
  </div>
  <!-- /.box-header -->
  <div class="box-body">

        @include('Users.Admin.messages.addMsg')



            <table id="patientsTable" class="table table-bordered table-striped" style="width:100%">

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Date of Birth</th>
                    <th>Gender</th>
                    <th>Mobile</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- Data will be populated here via AJAX -->
            </tbody>
            <tfoot>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Date of Birth</th>
                    <th>Gender</th>
                    <th>Mobile</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Actions</th>
                </tr>
            </tfoot>
        </table>

  </div>
  <!-- /.box-body -->
</div>
<!-- /.box -->

@include('Users.Admin.Patients.components.updatePatient')
@include('Users.Admin.Patients.components.deletePatient')




@push('specificJs')
{{-- toastr msg --}}

<script>
    //show edit and delete model btn
    $(document).on('click', '.editBtn', function() {
    let btn = $(this);

    $('#edit-id').val(btn.data('id'));
    $('#edit-pid').val(btn.data('pid'));
    $('#edit-name').val(btn.data('name'));
    $('#edit-dob').val(btn.data('dob'));
    $('#edit-gender').val(btn.data('gender'));
    $('#edit-mobile').val(btn.data('mobile'));
    $('#edit-email').val(btn.data('email'));
    $('#edit-address').val(btn.data('address'));


    // Show modal
    $('#editPatientModal').modal('show');
    });

    //show delete modal
    $(document).on('click', '.deleteBtn', function () {
        const pid = $(this).data('id'); // patient.userID
        $('#delete_pid').val(pid);
        $('#deletePatientModal').modal('show');
    });


    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    })
</script>



<script>
    let patientsTable;

    $(document).ready(function() {
        $('#patientsTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            scrollX: true,
            autoWidth: false,
            lengthChange: true,
            ajax: '{{ route("admin.allPatient") }}',
            columns: [
                { data: 'id' },
                { data: 'name' },
                { data: 'dob' },
                { data: 'gender' },
                { data: 'mobile' },
                { data: 'email' },
                { data: 'address' },
                { data: 'actions', orderable: false, searchable: false } // actions column
            ],
            order: [[0, 'desc']],  // Default sorting (by ID in descending order)
            dom: 'flBrtip',  // 'l' is for length (dropdown), 'B' is for buttons, 'f' is for search box, 'r' is for processing, 't' is for table, 'i' is for table info, 'p' is for pagination
            buttons: [
                {
                    extend: 'pdf',
                    text: 'PDF',
                    orientation: 'portrait',
                    pageSize: 'A4',
                    exportOptions: {
                        columns: ':not(:last-child)'  // Exclude the last column (actions)
                    }
                },
                {
                    extend: 'csv',
                    text: 'CSV',
                    exportOptions: {
                        columns: ':not(:last-child)'  // Exclude the last column (actions)
                    }
                },
                {
                    extend: 'excel',
                    text: 'Excel',
                    exportOptions: {
                        columns: ':not(:last-child)'  // Exclude the last column (actions)
                    }
                },
                {
                    extend: 'print',
                    text: 'Print',
                    exportOptions: {
                        columns: ':not(:last-child)'  // Exclude the last column (actions)
                    }
                }
            ]
        });
    });

</script>


<script>
    $(window).on('resize', function() {
        $('#patientsTable').DataTable().columns.adjust().draw();
    });


    $('a[data-widget="pushmenu"]').on('click', function() {
        setTimeout(function() {
            $('#patientsTable').DataTable().columns.adjust().draw();
        }, 300); // Delay to ensure sidebar transition finishes
    });


    // $(function () {
    //   $('#patientsTable').DataTable()
    // })
</script>


@endpush
