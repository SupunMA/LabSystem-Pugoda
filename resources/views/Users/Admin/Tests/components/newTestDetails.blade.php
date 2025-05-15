<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">

                <table id="testsTable" class="table table-bordered table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Patient Name</th>
                            <th>NIC</th>
                            <th>DOB</th>
                            <th>Test Name</th>
                            <th>Date</th>
                            <th>Price</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data will be populated via AJAX -->
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Patient Name</th>
                            <th>NIC</th>
                            <th>DOB</th>
                            <th>Test Name</th>
                            <th>Date</th>
                            <th>Price</th>
                            <th>Actions</th>
                        </tr>
                    </tfoot>
                </table>

            </div>
        </div>
    </div>
</section>


@push('specificJs')
<script>
$(document).ready(function () {
    $('#testsTable').DataTable({
        processing: true, // Show processing indicator
        serverSide: true, // Enable server-side processing
        responsive: true, // Make the table responsive
        scrollX: true, // Enable horizontal scrolling
        autoWidth: false, // Disable automatic column width calculation
        lengthChange: true, // Allow users to change the number of rows displayed
        ajax: {
            url: '{{ route("getAllInternalRequestedTests") }}', // Laravel route for fetching data
            type: 'GET', // HTTP method
            error: function (xhr, error, code) {
                console.error('Error fetching data:', error); // Log errors for debugging
            },
        },
        columns: [
            { data: 'id', name: 'id', title: 'ID' }, // ID column
            { data: 'patient_name', name: 'patient_name', title: 'Patient Name' }, // Patient Name
            { data: 'nic', name: 'nic', title: 'NIC' }, // NIC
            { data: 'dob', name: 'dob', title: 'DOB' }, // Date of Birth
            { data: 'test_name', name: 'test_name', title: 'Test Name' }, // Test Name
            {
                data: 'test_date',
                name: 'test_date',
                title: 'Date',
                render: function (data) {
                    return data ? moment(data).format('MMM D, YYYY') : 'N/A'; // Format date using Moment.js
                }
            }, // Test Date
            {
                data: 'price',
                name: 'price',
                title: 'Price',
                render: $.fn.dataTable.render.number(',', '.', 2, 'Rs. ') // Format price
            }, // Price column
            {
                data: 'actions',
                name: 'actions',
                title: 'Actions',
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    return `
                        <div class="btn-group">
                            <button type="button" class="btn btn-primary btn-sm editBtn" data-id="${row.id}">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button type="button" class="btn btn-danger btn-sm deleteBtn" data-id="${row.id}">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </div>
                    `;
                }
            }, // Actions column
        ],
        order: [[0, 'desc']], // Default sorting by ID in descending order
        dom: 'flBrtip', // Define table control elements
        buttons: [
            {
                extend: 'pdf',
                text: 'PDF',
                orientation: 'portrait',
                pageSize: 'A4',
                exportOptions: {
                    columns: ':not(:last-child)', // Exclude the Actions column
                },
            },
            {
                extend: 'excel',
                text: 'Excel',
                exportOptions: {
                    columns: ':not(:last-child)', // Exclude the Actions column
                },
            },
            {
                extend: 'print',
                text: 'Print',
                exportOptions: {
                    columns: ':not(:last-child)', // Exclude the Actions column
                },
            },
        ],
        language: {
            emptyTable: "No data available in the table", // Custom message for empty table
            processing: "Loading data, please wait...", // Custom processing message
        },
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
