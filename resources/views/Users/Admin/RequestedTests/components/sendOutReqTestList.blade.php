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
<!-- Loading Spinner -->
<div id="loadingSpinner" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 1050; justify-content: center; align-items: center;">
    <div class="spinner-border text-light" role="status">
        <span class="sr-only">Loading...</span>
    </div>
</div>
<!-- Modal for Uploading Report -->
<div class="modal fade" id="uploadReportModal" tabindex="-1" role="dialog" aria-labelledby="uploadReportModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content shadow-lg border-0">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="uploadReportModalLabel">
                    <i class="fas fa-file-upload"></i> Upload Report for <span id="patientName" class="fw-bold"></span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="uploadReportForm" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-4">
                        <label for="reportFile" class="form-label fw-bold">Select a PDF File</label>
                        <input type="file" class="form-control" id="reportFile" name="reportFile" accept="application/pdf" required>
                        <small class="text-muted">Only PDF files are allowed. Max size: 2MB.</small>
                    </div>
                    <input type="hidden" id="testId" name="testId">
                </form>
                <!-- Spinner inside the modal body -->
                <div id="modalSpinner" style="display: none; text-align: center; margin-top: 20px;">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-between">
                <!-- Button to open the selected PDF in a new tab -->
                <button type="button" class="btn btn-outline-info" id="viewPdfBtn" style="display: none;" disabled>
                    <i class="fas fa-eye"></i> View PDF
                </button>
                <div>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Close
                    </button>
                    <button type="button" class="btn btn-primary" id="uploadReportBtn">
                        <i class="fas fa-upload"></i> Upload
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteTestModal" tabindex="-1" role="dialog" aria-labelledby="deleteTestModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteTestModalLabel">
                    <i class="fas fa-trash"></i> Confirm Delete
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete the requested test for <span id="deletePatientName" class="fw-bold"></span>?</p>
                <input type="hidden" id="deleteTestId">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i> Cancel
                </button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">
                    <i class="fas fa-trash"></i> Delete
                </button>
            </div>
        </div>
    </div>
</div>
@push('specificJs')
<script>
$(document).ready(function () {
    let selectedFileUrl = null; // Store the selected file's URL for viewing

    // Initialize DataTable
    $('#testsTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        scrollX: true,
        autoWidth: false,
        lengthChange: true,
        ajax: {
            url: '{{ route("getAllExternalRequestedTests") }}',
            type: 'GET',
            error: function (xhr, error, code) {
                console.error('Error fetching data:', error);
            },
        },
        columns: [
            { data: 'id', name: 'id', title: 'ID' },
            { data: 'patient_name', name: 'patient_name', title: 'Patient Name' },
            { data: 'nic', name: 'nic', title: 'NIC',defaultContent: 'N/A', },
            { data: 'dob', name: 'dob', title: 'DOB' },
            { data: 'test_name', name: 'test_name', title: 'Test Name' },
            {
                data: 'test_date',
                name: 'test_date',
                title: 'Date',
                render: function (data) {
                    return data ? moment(data).format('MMM D, YYYY') : 'N/A';
                }
            },
            {
                data: 'price',
                name: 'price',
                title: 'Price',
                render: $.fn.dataTable.render.number(',', '.', 2, 'Rs. ')
            },
            {
                data: null,
                name: 'actions',
                title: 'Actions',
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    return `
                        <button type="button" class="btn btn-success btn-sm uploadReportBtn"
                                data-id="${row.id}"
                                data-patient-name="${row.patient_name}">
                            <i class="fas fa-upload"></i> Upload Report
                        </button>
                        <button type="button" class="btn btn-danger btn-sm deleteTestBtn"
                                data-id="${row.id}"
                                data-patient-name="${row.patient_name}">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    `;
                }
            },
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
                    columns: ':not(:last-child)',
                },
            },
            {
                extend: 'excel',
                text: 'Excel',
                exportOptions: {
                    columns: ':not(:last-child)',
                },
            },
            {
                extend: 'print',
                text: 'Print',
                exportOptions: {
                    columns: ':not(:last-child)',
                },
            },
        ],
        language: {
            emptyTable: "No data available in the table",
            processing: "Loading data, please wait...",
        },
    });

    // Handle Upload Report button click
    $(document).on('click', '.uploadReportBtn', function () {
        const testId = $(this).data('id');
        const patientName = $(this).data('patient-name'); // Get the patient's name

        $('#testId').val(testId); // Set the test ID in the hidden input
        $('#patientName').text(patientName); // Set the patient's name in the modal
        $('#uploadReportModal').modal('show'); // Show the modal
        $('#viewPdfBtn').hide().prop('disabled', true); // Hide and disable the "View PDF" button
        $('#reportFile').val(''); // Clear the file input
        selectedFileUrl = null; // Reset the selected file URL
    });

    // Enable "View PDF" button when a file is selected
    $('#reportFile').on('change', function (e) {
        const file = e.target.files[0];
        if (file && file.type === 'application/pdf') {
            selectedFileUrl = URL.createObjectURL(file); // Create a temporary URL for the file
            $('#viewPdfBtn').show().prop('disabled', false); // Enable the "View PDF" button
        } else {
            $('#viewPdfBtn').hide().prop('disabled', true); // Hide and disable the button if no valid file is selected
            selectedFileUrl = null;
        }
    });

    // Open the selected PDF in a new tab
    $('#viewPdfBtn').on('click', function () {
        if (selectedFileUrl) {
            window.open(selectedFileUrl, '_blank'); // Open the PDF in a new tab
        }
    });

    // Handle file upload
    $('#uploadReportBtn').on('click', function () {
        const formData = new FormData($('#uploadReportForm')[0]);

        // Show the spinner inside the modal
        $('#modalSpinner').fadeIn();

        $.ajax({
            url: '{{ route("admin.uploadPdf") }}', // Laravel route for uploading the report
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                toastr.success('Report uploaded successfully!');
                $('#uploadReportModal').modal('hide');
                $('#testsTable').DataTable().ajax.reload(); // Reload the table
            },
            error: function (xhr, status, error) {
                toastr.error('Failed to upload the report. Please try again.');
            },
            complete: function () {
                // Hide the spinner inside the modal
                $('#modalSpinner').fadeOut();
                $('#reportFile').val(''); // Clear the file input after upload
                $('#viewPdfBtn').hide().prop('disabled', true); // Hide and disable the "View PDF" button
                selectedFileUrl = null; // Reset the selected file URL
            }
        });
    });

    // Handle Delete Button Click
    $(document).on('click', '.deleteTestBtn', function () {
        const testId = $(this).data('id');
        const patientName = $(this).data('patient-name');

        $('#deleteTestId').val(testId); // Set the test ID in the hidden input
        $('#deletePatientName').text(patientName); // Set the patient's name in the modal
        $('#deleteTestModal').modal('show'); // Show the delete confirmation modal
    });

    // Handle Confirm Delete Button Click
    $('#confirmDeleteBtn').on('click', function () {
        const testId = $('#deleteTestId').val();

        $.ajax({
            url: '{{ route("admin.deleteSendOutRequestedTest") }}', // Laravel route for deleting the requested test
            type: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}',
                id: testId,
            },
            success: function (response) {
                toastr.success('Requested test deleted successfully!');
                $('#deleteTestModal').modal('hide'); // Hide the modal
                $('#testsTable').DataTable().ajax.reload(); // Reload the table
            },
            error: function (xhr, status, error) {
                toastr.error('Failed to delete the requested test. Please try again.');
            }
        });
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
</script>
@endpush

@push('specificCSS')
<style>
.modal-content {
    border-radius: 10px; /* Rounded corners */
    overflow: hidden; /* Prevent content overflow */
}

.modal-header {
    border-bottom: none; /* Remove default border */
}

.modal-footer {
    border-top: none; /* Remove default border */
}

#modalSpinner {
    text-align: center;
    margin-top: 20px;
}

.spinner-border {
    width: 2.5rem;
    height: 2.5rem;
}

.btn-primary {
    background-color: #007bff;
    border-color: #007bff;
    transition: background-color 0.3s ease, border-color 0.3s ease;
}

.btn-primary:hover {
    background-color: #0056b3;
    border-color: #004085;
}

.btn-outline-info {
    border-color: #17a2b8;
    color: #17a2b8;
    transition: background-color 0.3s ease, color 0.3s ease;
}

.btn-outline-info:hover {
    background-color: #17a2b8;
    color: #fff;
}
</style>
@endpush
