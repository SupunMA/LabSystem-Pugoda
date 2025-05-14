<!-- Delete Test Modal -->
<div class="modal fade" id="deleteTestModal" tabindex="-1" role="dialog" aria-labelledby="deleteTestModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="deleteTestForm" method="POST" action="{{ route('admin.destroyExternalAvailableTest')}}">
            @csrf
            <input type="hidden" name="test_id" id="delete-test-id"> <!-- Hidden input for test ID -->

            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteTestModalLabel">
                        <i class="fas fa-exclamation-triangle"></i> Delete Test
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <p>Are you sure you want to delete this test: <strong id="delete-test-name"></strong>?</p>
                    <p class="text-danger">
                        <i class="fas fa-exclamation-circle"></i> This action cannot be undone and will remove all associated data with this test.
                    </p>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('specificJs')
<script>
    var deleteTestUrl = "{{ route('admin.destroyExternalAvailableTest', ':id') }}";
</script>
<script>
$(document).on('click', '.deleteBtn', function () {
    const id = $(this).data('id'); // Get the test ID from the button
    const name = $(this).data('name'); // Get the test name from the button

    // Populate the modal fields
    $('#delete-test-id').val(id); // Set the hidden input value for test ID
    $('#delete-test-name').text(name); // Set the test name in the modal

    // Show the modal
    $('#deleteTestModal').modal('show');
});

$('#deleteTestForm').on('submit', function (e) {
    e.preventDefault(); // Prevent the default form submission

        const $btn = $('#deleteTestForm button[type="submit"]');
        const originalBtnText = $btn.html();
        $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> Deleting...');

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                $('#deleteTestModal').modal('hide');
                $('#testsTable').DataTable().ajax.reload(null, false);
                toastr.success(response.message || 'Test deleted successfully');
            },
            error: function(xhr) {
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    toastr.error(xhr.responseJSON.message);
                } else {
                    toastr.error('Error deleting test. Please try again.');
                }
            },
            complete: function() {
                $btn.prop('disabled', false).html(originalBtnText);
            }
        });
});








</script>
@endpush
