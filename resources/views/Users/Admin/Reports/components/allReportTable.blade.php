<div class="box">
    <!-- /.box-header -->
    <div class="box-body">

        <table id="reportsTable" class="table table-bordered table-striped" style="width:100%">
            <thead>
                <tr>
                    <th>Patient Name</th>
                    <th>NIC</th>
                    <th>Date of Birth</th>
                    <th>Test Date</th>
                    <th>Test Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- Data will be populated via AJAX -->
            </tbody>
            <tfoot>
                <tr>
                    <th>Patient Name</th>
                    <th>NIC</th>
                    <th>Date of Birth</th>
                    <th>Test Date</th>
                    <th>Test Name</th>
                    <th>Actions</th>
                </tr>
            </tfoot>
        </table>

    </div>
    <!-- /.box-body -->
</div>
  <!-- /.box -->


  @push('specificJs')
  <script>
      $(document).ready(function() {
    $('#reportsTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        scrollX: true,
        autoWidth: false,
        lengthChange: true,
        ajax: '{{ route("reports.data") }}',
        columns: [
            {
                data: 'patient_name',
                name: 'patient_name',
                orderable: true
            },
            {
                data: 'nic',
                name: 'nic',
                defaultContent: 'N/A',
                orderable: true
            },
            {
                data: 'dob_formatted',
                name: 'dob_formatted',
                orderable: true
            },
            {
                data: 'test_date_formatted',
                name: 'test_date_formatted',
                orderable: true
            },
            {
                data: 'test_name',
                name: 'test_name',
                orderable: true
            },
            {
                data: 'actions',
                name: 'actions',
                orderable: false,
                searchable: false
            }
        ],
        order: [[3, 'desc']],
        dom: 'flBrtip',
        buttons: [
            {
                extend: 'pdf',
                text: 'PDF',
                orientation: 'portrait',
                pageSize: 'A4',
                exportOptions: {
                    columns: ':not(:last-child)'
                }
            },
            {
                extend: 'csv',
                text: 'CSV',
                exportOptions: {
                    columns: ':not(:last-child)'
                }
            },
            {
                extend: 'excel',
                text: 'Excel',
                exportOptions: {
                    columns: ':not(:last-child)'
                }
            },
            {
                extend: 'print',
                text: 'Print',
                exportOptions: {
                    columns: ':not(:last-child)'
                }
            }
        ]
    });

    // Adjust table on window resize
    $(window).on('resize', function() {
        $('#reportsTable').DataTable().columns.adjust().draw();
    });

    // Adjust table when sidebar is toggled
    $('a[data-widget="pushmenu"]').on('click', function() {
        setTimeout(function() {
            $('#reportsTable').DataTable().columns.adjust().draw();
        }, 300);
    });

    // Initialize toastr
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "timeOut": "8000"
    };

    // Display success message if present in session
    @if(session('success'))
        toastr.success('{{ session('success') }}');
    @endif

    // Display error message if present in session
    @if(session('error'))
        toastr.error('{{ session('error') }}');
    @endif
});
  </script>
  @endpush
