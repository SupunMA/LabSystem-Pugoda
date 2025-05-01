<!-- Edit Test Modal -->
<div class="modal fade" id="editTestModal" tabindex="-1" role="dialog" aria-labelledby="editTestModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="editTestForm" action="{{ route('admin.updateTestnew') }}" method="POST">
            @csrf
            <input type="hidden" id="edit-id" name="test_id">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editTestModalLabel">Edit Test Basic Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Test Name</label>
                        <input type="text" id="edit-name" name="name" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Specimen</label>
                        <select id="edit-specimen" name="specimen" class="form-control">
                            <option value="">--Select Specimen Type--</option>
                            <option value="blood">Blood</option>
                            <option value="urine">Urine</option>
                            <option value="stool">Stool (Feces)</option>
                            <option value="sputum">Sputum</option>
                            <option value="saliva">Saliva</option>
                            <option value="swab">Swab (e.g., throat, nasal)</option>
                            <option value="tissue">Tissue (Biopsy)</option>
                            <option value="csf">Cerebrospinal Fluid (CSF)</option>
                            <option value="semen">Semen</option>
                            <option value="vaginal">Vaginal Secretion</option>
                            <option value="amniotic">Amniotic Fluid</option>
                            <option value="pleural">Pleural Fluid</option>
                            <option value="peritoneal">Peritoneal Fluid</option>
                            <option value="synovial">Synovial Fluid</option>
                            <option value="bone_marrow">Bone Marrow</option>
                            <option value="hair">Hair</option>
                            <option value="nail">Nail</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Cost</label>
                                <input type="number" id="edit-cost" name="cost" class="form-control" step="10.00">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Price</label>
                                <input type="number" id="edit-price" name="price" class="form-control" step="10.00">
                            </div>
                        </div>
                    </div>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle mr-1"></i> To edit categories and other elements, please use the full edit page.
                        <a href="#" id="full-edit-link" class="alert-link">Full Edit</a>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('specificJs')
<script>
    // Show edit test modal
    $(document).on('click', '.editBtn', function() {
        let btn = $(this);

        $('#edit-id').val(btn.data('id'));
        $('#edit-name').val(btn.data('name'));
        $('#edit-specimen').val(btn.data('specimen'));
        $('#edit-cost').val(btn.data('cost'));
        $('#edit-price').val(btn.data('price'));

        // Set the full edit link href
        $('#full-edit-link').attr('href', `{{ url('Admin/tests') }}/${btn.data('id')}/edit`);

        $('#editTestModal').modal('show');
    });

    // AJAX Submit for Update
    $('#editTestForm').submit(function(e) {
        e.preventDefault();

        const $btn = $('#editTestForm button[type="submit"]');
        const originalBtnText = $btn.html();
        $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> Saving...');

        // Clear old errors
        $('#editTestForm .is-invalid').removeClass('is-invalid');
        $('#editTestForm .invalid-feedback').remove();

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                $('#editTestModal').modal('hide');
                $('#testsTable').DataTable().ajax.reload(null, false);
                toastr.success(response.message || 'Test updated successfully');
            },
            error: function(xhr) {
                if (xhr.status === 422 && xhr.responseJSON.errors) {
                    const errors = xhr.responseJSON.errors;
                    // Loop through each field error
                    $.each(errors, function(key, messages) {
                        const input = $(`#editTestForm [name="${key}"]`);
                        input.addClass('is-invalid');
                        input.after('<div class="invalid-feedback">' + messages[0] + '</div>');
                    });
                } else {
                    toastr.error('Something went wrong!');
                }
            },
            complete: function() {
                $btn.prop('disabled', false).html(originalBtnText);
            }
        });
    });
</script>
@endpush
