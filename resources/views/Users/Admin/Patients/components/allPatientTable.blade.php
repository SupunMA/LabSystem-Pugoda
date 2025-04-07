<div class="box">
  <div class="box-header">
    <h3 class="box-title">List of Patients</h3>
  </div>
  <!-- /.box-header -->
  <div class="box-body">

        @include('Users.Admin.messages.addMsg')



        <table id="patientsTable" class="table table-bordered table-striped">
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

@push('specificJs')
{{-- toastr msg --}}




<script>
    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    })
  </script>


<script>
    $(document).ready(function() {
        $('#patientsTable').DataTable({
            processing: true,
            serverSide: true,
            "responsive": true,
            "lengthChange": true,
            "autoWidth": true,
            ajax: '{{ route("admin.allPatient") }}',
            columns: [
                { data: 'id' },
                { data: 'name' },
                { data: 'dob' },
                { data: 'gender' },
                { data: 'mobile' },
                { data: 'email' },
                { data: 'address' },
                { data: 'actions', orderable: false, searchable: false }
            ]
        });
    });
</script>

{{-- <script>

    $(function () {
      $('#patientsTable').DataTable()
    })
</script> --}}



@endpush
