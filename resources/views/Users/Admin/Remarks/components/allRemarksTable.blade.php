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
    {{-- remark --}}
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
                        {{-- This is the input for adding new remarks --}}
                        <input type="text" class="form-control" id="remark_description" name="remark_description" required placeholder="e.g., Late submission, Incomplete data">
                        {{-- This is the feedback area for adding new remarks --}}
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
                        {{-- Feedback element for uniqueness/length in edit modal (optional, but good) --}}
                        <div id="editRemarkDescriptionFeedback" class="mt-2">
                            <small class="form-text text-muted">Description should be short and unique.</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="updateRemarkButton">Update Remark</button>
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


    // Variable for edit modal uniqueness check (similar to add modal)
    var editUniquenessCheckXhr = null;

    // Handle Edit button click - Populate modal
    $('#remarkTable tbody').on('click', '.edit-remark', function () {
        var remarkId = $(this).data('id');
        var remarkDescription = $(this).data('description');

        $('#edit_remark_id').val(remarkId);
        $('#edit_remark_description').val(remarkDescription);

        // Reset feedback for edit modal
        $('#editRemarkDescriptionFeedback').html('<small class="form-text text-muted">Description should be short and unique.</small>').removeClass('text-danger text-success');
        $('#updateRemarkButton').prop('disabled', false);
    });

    // Live uniqueness and length check for Edit Remark Modal
    $('#edit_remark_description').on('keyup input', function() {
        var remarkDescription = $(this).val().trim();
        var remarkId = $('#edit_remark_id').val(); // Get the ID of the remark being edited
        var feedbackElement = $('#editRemarkDescriptionFeedback');
        var updateButton = $('#updateRemarkButton');

        // Clear previous feedback and reset button
        feedbackElement.html('<small class="form-text text-muted">Description should be short and unique.</small>').removeClass('text-danger text-success');
        updateButton.prop('disabled', false);

        if (remarkDescription.length === 0) {
            return; // Do nothing if input is empty
        }

        // Check for length (adjust max length as desired)
        if (remarkDescription.length > 50) {
            feedbackElement.html('<small class="form-text text-danger">Description is too long (max 50 characters).</small>');
            updateButton.prop('disabled', true);
            return;
        }

        // Abort previous request if still in progress
        if (editUniquenessCheckXhr && editUniquenessCheckXhr.readyState !== 4) {
            editUniquenessCheckXhr.abort();
        }

        // Show a temporary loading indicator
        feedbackElement.html('<small class="form-text text-info"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Checking uniqueness...</small>');

        // Perform AJAX call to check uniqueness
        editUniquenessCheckXhr = $.ajax({
            url: '{{ route("remarks.checkUnique") }}',
            type: 'GET',
            data: {
                description: remarkDescription,
                remark_id: remarkId // Pass the ID to exclude current remark from uniqueness check
            },
            success: function(response) {
                if (response.isUnique) {
                    feedbackElement.html('<small class="form-text text-success">Description is unique and good!</small>');
                    updateButton.prop('disabled', false);
                } else {
                    feedbackElement.html('<small class="form-text text-danger">This remark description already exists.</small>');
                    updateButton.prop('disabled', true);
                }
            },
            error: function(xhr) {
                if (xhr.status !== 0) {
                    feedbackElement.html('<small class="form-text text-danger">Error checking uniqueness. Please try again.</small>');
                    updateButton.prop('disabled', true);
                }
            }
        });
    });

    // Intercept Edit Remark Form Submission
    $('#editRemarkForm').on('submit', function(e) {
        e.preventDefault(); // Prevent default form submission

        var form = $(this);
        var url = form.attr('action');
        var method = form.attr('method');
        var formData = form.serialize(); // Get form data including CSRF token and _method

        var updateButton = $('#updateRemarkButton');
        updateButton.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Updating...');
        updateButton.prop('disabled', true);

        $.ajax({
            url: url,
            type: method, // Will be POST
            data: formData, // Contains _method: 'PUT' due to Laravel's form method spoofing
            success: function(response) {
                $('#editRemarkModal').modal('hide'); // Hide the modal
                toastr.success(response.message); // Show success toast
                remarkTable.ajax.reload(null, false); // Reload DataTables
                // No need to reset form here, it will be populated next time
                $('#editRemarkDescriptionFeedback').html('<small class="form-text text-muted">Description should be short and unique.</small>').removeClass('text-danger text-success');
                updateButton.html('Update Remark').prop('disabled', false);
            },
            error: function(xhr) {
                updateButton.html('Update Remark').prop('disabled', false); // Re-enable button

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
                            break;
                        }
                    }
                    toastr.error(firstError || errorMessage);
                } else {
                    toastr.error(errorMessage);
                }
            }
        });
    });

    // Reset form and feedback when edit modal is hidden
    $('#editRemarkModal').on('hidden.bs.modal', function () {
        // Abort any pending uniqueness check for edit modal
        if (editUniquenessCheckXhr && editUniquenessCheckXhr.readyState !== 4) {
            editUniquenessCheckXhr.abort();
        }
        // Optionally reset form if you don't want old data to persist on next open
        // $('#editRemarkForm')[0].reset();
        $('#editRemarkDescriptionFeedback').html('<small class="form-text text-muted">Description should be short and unique.</small>').removeClass('text-danger text-success');
        $('#updateRemarkButton').prop('disabled', false);
    });

    // Variable to store the AJAX request for uniqueness check in Add Remark Modal
    var uniquenessCheckXhr = null; // This variable is specific to the add modal's check

    // Listener for the 'remark_description' input (in the Add Remark Modal)
    $('#remark_description').on('keyup input', function() {
        var remarkDescription = $(this).val().trim();
        var feedbackElement = $('#remarkDescriptionFeedback'); // Targets the add modal's feedback div
        var saveButton = $('#saveRemarkButton'); // Targets the add modal's save button

        // Clear previous feedback and reset button
        feedbackElement.html('<small class="form-text text-muted">Description should be short and unique.</small>').removeClass('text-danger text-success text-info');
        saveButton.prop('disabled', false);

        if (remarkDescription.length === 0) {
            return; // Do nothing if input is empty
        }

        // Check for length
        if (remarkDescription.length > 50) { // Adjust max length as desired
            feedbackElement.html('<small class="form-text text-danger">Description is too long (max 50 characters).</small>');
            saveButton.prop('disabled', true);
            return;
        }

        // Abort previous request if still in progress
        if (uniquenessCheckXhr && uniquenessCheckXhr.readyState !== 4) {
            uniquenessCheckXhr.abort();
        }

        // Show a temporary loading indicator
        feedbackElement.html('<small class="form-text text-info"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Checking uniqueness...</small>');

        // Perform AJAX call to check uniqueness
        uniquenessCheckXhr = $.ajax({
            url: '{{ route("remarks.checkUnique") }}', // The common route for uniqueness check
            type: 'GET',
            // --- IMPORTANT FOR ADD REMARK: We do NOT send remark_id here ---
            data: { description: remarkDescription },
            success: function(response) {
                if (response.isUnique) {
                    feedbackElement.html('<small class="form-text text-success">Description is unique and good!</small>');
                    saveButton.prop('disabled', false);
                } else {
                    feedbackElement.html('<small class="form-text text-danger">This remark description already exists.</small>');
                    saveButton.prop('disabled', true);
                }
            },
            error: function(xhr) {
                if (xhr.status !== 0) { // status 0 is usually an abort, so only show error for others
                    feedbackElement.html('<small class="form-text text-danger">Error checking uniqueness. Please try again.</small>');
                    saveButton.prop('disabled', true);
                }
            }
        });
    });

    // Reset form and feedback when Add Remark modal is hidden
    $('#addRemarkModal').on('hidden.bs.modal', function () {
        $('#addRemarkForm')[0].reset(); // Resets the form fields
        $('#remarkDescriptionFeedback').html('<small class="form-text text-muted">Description should be short and unique.</small>').removeClass('text-danger text-success text-info');
        $('#saveRemarkButton').prop('disabled', false);

        // Abort any pending uniqueness check for the add modal
        if (uniquenessCheckXhr && uniquenessCheckXhr.readyState !== 4) {
            uniquenessCheckXhr.abort();
        }
    });
});

</script>
@endpush('specificJs')
