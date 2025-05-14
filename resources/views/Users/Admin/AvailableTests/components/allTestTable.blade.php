




<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">

                @include('Users.Admin.messages.addMsg')

                <table id="testsTable" class="table table-bordered table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Test Name</th>
                            <th>Specimen</th>
                            <th>Categories</th>
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
                            <th>Price</th>
                            <th>Created Date</th>
                            <th>Actions</th>
                        </tr>
                    </tfoot>
                </table>

            </div>
        </div>
    </div>
</section>

@include('Users.Admin.AvailableTests.components.internalTest.updateTest')
@include('Users.Admin.AvailableTests.components.internalTest.viewTest')
@include('Users.Admin.AvailableTests.components.internalTest.deleteTest')
@include('Users.Admin.AvailableTests.components.internalTest.newTemplate')



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


    // View Template button handler
$(document).on('click', '.viewTemplateBtn', function() {
    const testId = $(this).data('id');
    window.open(`{{ url('/tests') }}/${testId}/report`, '_blank');
});
</script>



@endpush
