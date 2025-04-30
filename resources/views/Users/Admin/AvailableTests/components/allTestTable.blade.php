




<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">List of Test Templates</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        @include('Users.Admin.messages.addMsg')

                        <table id="testsTable" class="table table-bordered table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Test Name</th>
                                    <th>Specimen</th>
                                    <th>Categories</th>
                                    <th>Cost</th>
                                    <th>Price</th>
                                    <th>Created Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data will be populated via AJAX -->
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Test Name</th>
                                    <th>Specimen</th>
                                    <th>Categories</th>
                                    <th>Cost</th>
                                    <th>Price</th>
                                    <th>Created Date</th>
                                    <th>Actions</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@include('Users.Admin.AvailableTests.components.updateTest')
@include('Users.Admin.AvailableTests.components.viewTest')
@include('Users.Admin.AvailableTests.components.deleteTest')



@push('specificJs')
<script>
    $(document).ready(function() {
        $('#testsTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            scrollX: true,
            autoWidth: false,
            lengthChange: true,
            ajax: '{{ route("admin.allTests") }}',
            columns: [
                { data: 'id' },
                { data: 'name' },
                { data: 'specimen' },
                { data: 'categories_count' },
                { data: 'cost' },
                { data: 'price' },
                { data: 'created_at' },
                { data: 'actions', orderable: false, searchable: false }
            ],
            order: [[0, 'desc']],
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
    });

    // Adjust table on window resize
    $(window).on('resize', function() {
        $('#testsTable').DataTable().columns.adjust().draw();
    });

    // Adjust table when sidebar is toggled
    $('a[data-widget="pushmenu"]').on('click', function() {
        setTimeout(function() {
            $('#testsTable').DataTable().columns.adjust().draw();
        }, 300);
    });

    // Initialize toastr
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "timeOut": "8000"
    };
</script>
@endpush
