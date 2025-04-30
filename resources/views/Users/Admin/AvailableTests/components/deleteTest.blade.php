<!-- Delete Test Modal -->
<div class="modal fade" id="deleteTestModal" tabindex="-1" role="dialog" aria-labelledby="deleteTestModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="deleteTestForm" action="{{ route('admin.deleteAvailableTestNEW') }}" method="POST">
            @csrf
            <input type="hidden" name="test_id" id="delete-test-id">

            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteTestModalLabel">Delete Test</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this test: <strong id="delete-test-name"></strong>?</p>
                    <p class="text-danger">This action cannot be undone and will remove all categories and reference data associated with this test.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('specificJs')
<script>
    // Show delete modal
    $(document).on('click', '.deleteBtn', function() {
        let btn = $(this);

        $('#delete-test-id').val(btn.data('id'));
        $('#delete-test-name').text(btn.data('name'));

        $('#deleteTestModal').modal('show');
    });

    // AJAX Submit for Delete
    $('#deleteTestForm').submit(function(e) {
        e.preventDefault();

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
