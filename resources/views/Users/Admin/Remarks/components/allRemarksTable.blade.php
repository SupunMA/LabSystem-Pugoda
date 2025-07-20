<div class="box">
    <div class="box-header">
      <h3 class="box-title">List of Remarks</h3>

    </div>
    <div class="box-body">

        <table id="remarkTable" class="table table-bordered table-striped" style="width:100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Remark</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                </tbody>
            <tfoot>
                <tr>
                    <th>ID</th>
                    <th>Remark</th>
                    <th>Actions</th>
                </tr>
            </tfoot>
        </table>

    </div>
    </div>
{{-- Add Remark Modal --}}
<div class="modal fade" id="addRemarkModal" tabindex="-1" role="dialog" aria-labelledby="addRemarkModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addRemarkModalLabel">Add New Remark</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addRemarkForm" method="POST" action="{{ route('admin.addingRemarks') }}">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="remark_description">Remark Description</label>
                        <input type="text" class="form-control" id="remark_description" name="remark_description" required placeholder="e.g., Repeated and Confirmed, Get reviewed by a doctor">
                        {{-- Feedback element for uniqueness and length --}}
                        <div id="remarkDescriptionFeedback" class="mt-2">
                            <small class="form-text text-muted">Description should be short and unique.</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="saveRemarkButton">Save Remark</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Edit Remark Modal --}}
<div class="modal fade" id="editRemarkModal" tabindex="-1" role="dialog" aria-labelledby="editRemarkModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editRemarkModalLabel">Edit Remark</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editRemarkForm" method="POST" action="{{ route('admin.updateRemarks') }}">
                @csrf
                <div class="modal-body">
                    <input type="hidden" id="edit_remark_id" name="remark_id">
                    <div class="form-group">
                        <label for="edit_remark_description">Remark Description</label>
                        <input type="text" class="form-control" id="edit_remark_description" name="remark_description" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Remark</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Delete Remark Modal --}}
<div class="modal fade" id="deleteRemarkModal" tabindex="-1" role="dialog" aria-labelledby="deleteRemarkModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteRemarkModalLabel">Confirm Delete</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this remark? This action cannot be undone.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteRemark">Delete</button>
            </div>
        </div>
    </div>
</div>


@push('specificJs')
<script>
$(document).ready(function() {
    var remarkTable = $('#remarkTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        scrollX: true,
        autoWidth: false,
        lengthChange: true,
        ajax: '{{ route("remarks.data") }}',
        columns: [
            {
                data: 'remark_id',
                name: 'remark_id',
                orderable: true,
                title: 'ID'
            },
            {
                data: 'remark_description',
                name: 'remark_description',
                orderable: true
            },
            {
                data: 'actions',
                name: 'actions',
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    return `
                        <button class="btn btn-sm btn-info edit-remark" data-id="${row.remark_id}" data-description="${row.remark_description}" data-toggle="modal" data-target="#editRemarkModal">
                            <i class="fa fa-pencil"></i> Edit
                        </button>
                        <button class="btn btn-sm btn-danger delete-remark" data-id="${row.remark_id}" data-toggle="modal" data-target="#deleteRemarkModal">
                            <i class="fa fa-trash"></i> Delete
                        </button>
                    `;
                }
            }
        ],
        order: [[0, 'desc']], // Sort by test date by default
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
        remarkTable.columns.adjust().draw();
    });

    // Adjust table when sidebar is toggled
    $('a[data-widget="pushmenu"]').on('click', function() {
        setTimeout(function() {
            remarkTable.columns.adjust().draw();
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

    // Handle Edit button click
    $('#remarkTable tbody').on('click', '.edit-remark', function () {
        var remarkId = $(this).data('id');
        var remarkDescription = $(this).data('description');

        $('#edit_remark_id').val(remarkId);
        $('#edit_remark_description').val(remarkDescription);
    });

    // Handle Delete button click
    var deleteRemarkId;
    $('#remarkTable tbody').on('click', '.delete-remark', function () {
        deleteRemarkId = $(this).data('id');
    });

    // Handle confirm delete button click
    $('#confirmDeleteRemark').on('click', function () {
        // Show a loading spinner (optional, but good for UX)
        $(this).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Deleting...');
        $(this).prop('disabled', true); // Disable button to prevent multiple clicks

        // Perform the AJAX delete request
        $.ajax({
            url: '{{ route("admin.deleteRemarksAjax") }}', // Use a new dedicated AJAX route
            type: 'POST', // Or 'DELETE' if you prefer RESTful DELETE requests (requires method spoofing)
            data: {
                _token: '{{ csrf_token() }}', // CSRF token
                _method: 'POST', // Spoof DELETE method for Laravel route
                id: deleteRemarkId // Pass the ID of the remark to delete
            },
            success: function (response) {
                // Hide the modal
                $('#deleteRemarkModal').modal('hide');

                // Show success message
                toastr.success(response.message);

                // Reload the DataTable
                remarkTable.ajax.reload(null, false); // null to keep current page, false to not reset paging

                // Reset button state
                $('#confirmDeleteRemark').html('Delete').prop('disabled', false);
            },
            error: function (xhr) {
                // Hide the modal
                $('#deleteRemarkModal').modal('hide');

                // Parse error message (assuming JSON response from Laravel)
                var errorMessage = 'An error occurred. Please try again.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                } else if (xhr.responseText) {
                    // Try to parse as JSON first, then fallback to text
                    try {
                        errorMessage = JSON.parse(xhr.responseText).message;
                    } catch (e) {
                        errorMessage = xhr.responseText;
                    }
                }
                toastr.error(errorMessage);

                // Reset button state
                $('#confirmDeleteRemark').html('Delete').prop('disabled', false);
            }
        });
    });

    // Intercept Add Remark Form Submission
    $('#addRemarkForm').on('submit', function(e) {
        e.preventDefault(); // Prevent default form submission

        var form = $(this);
        var url = form.attr('action');
        var method = form.attr('method');
        var formData = form.serialize(); // Get form data including CSRF token

        var saveButton = $('#saveRemarkButton');
        saveButton.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...');
        saveButton.prop('disabled', true);

        $.ajax({
            url: url,
            type: method,
            data: formData,
            success: function(response) {
                $('#addRemarkModal').modal('hide'); // Hide the modal
                toastr.success(response.message); // Show success toast
                remarkTable.ajax.reload(null, false); // Reload DataTables
                form[0].reset(); // Reset the form fields
                $('#remarkDescriptionFeedback').html('<small class="form-text text-muted">Description should be short and unique.</small>').removeClass('text-danger text-success');
                saveButton.html('Save Remark').prop('disabled', false);
            },
            error: function(xhr) {
                saveButton.html('Save Remark').prop('disabled', false); // Re-enable button

                var errorMessage = 'An unexpected error occurred.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }

                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    // Display specific validation errors
                    var errors = xhr.responseJSON.errors;
                    var firstError = '';
                    for (var key in errors) {
                        if (errors.hasOwnProperty(key)) {
                            firstError = errors[key][0]; // Get the first error message for the field
                            break; // Only show the first error for simplicity
                        }
                    }
                    toastr.error(firstError || errorMessage); // Show the specific validation error or general message
                } else {
                    toastr.error(errorMessage); // Show general error
                }
            }
        });
    });
});

</script>
@endpush('specificJs')
