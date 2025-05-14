<!-- View Test Modal -->
<div class="modal fade" id="viewTestModal" tabindex="-1" role="dialog" aria-labelledby="viewTestModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewTestModalLabel">Test Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="test-details-content">
                <div class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@push('specificJs')
<script>
    // Show view test modal
    $(document).on('click', '.viewBtn', function() {
    let btn = $(this);
    let testId = btn.data('id');

    // Show modal with loading spinner
    $('#viewTestModal').modal('show');

    // Reset content and show spinner
    $('#test-details-content').html(`
        <div class="text-center">
            <div class="spinner-border text-primary" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    `);

    // Load test details via AJAX - Fix URL here
    $.ajax({
        url: `{{ url('/Admin/tests') }}/${testId}/details`, // Make sure this matches your route
        method: 'GET',
        success: function(response) {
            $('#test-details-content').html(response);
        },
        error: function(xhr) {
            $('#test-details-content').html(`
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    Error loading test details. Error code: ${xhr.status}
                    <br><small>${xhr.responseText}</small>
                </div>
            `);
            console.error('Error details:', xhr.status, xhr.responseText);
        }
    });
});
</script>
@endpush
