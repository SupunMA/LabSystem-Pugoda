<!-- Edit Modal -->
<div class="modal fade" id="editTestModal" tabindex="-1" role="dialog" aria-labelledby="editTestModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editTestModalLabel">Edit Test</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editTestForm">
                @csrf
                <input type="hidden" id="editTestId" name="id">
                <div class="modal-body">
                    <!-- Test Name -->
                    <div class="form-group">
                        <label for="editName">Test Name</label>
                        <input type="text" class="form-control" id="editName" name="name" required>
                    </div>

                    <!-- Specimen -->
                    <div class="form-group">
                        <label for="editSpecimen">Specimen</label>
                        <select class="form-control select2" id="editSpecimen" name="specimen" required>
                            <option value="Blood">Blood</option>
                            <option value="Urine">Urine</option>
                            <option value="Stool">Stool (Feces)</option>
                            <option value="Sputum">Sputum</option>
                            <option value="Saliva">Saliva</option>
                            <option value="Swab">Swab (e.g., throat, nasal)</option>
                            <option value="Tissue">Tissue (Biopsy)</option>
                            <option value="CSF">Cerebrospinal Fluid (CSF)</option>
                            <option value="Semen">Semen</option>
                            <option value="Vaginal">Vaginal Secretion</option>
                            <option value="Amniotic">Amniotic Fluid</option>
                            <option value="Pleural">Pleural Fluid</option>
                            <option value="Peritoneal">Peritoneal Fluid</option>
                            <option value="Synovial">Synovial Fluid</option>
                            <option value="Bone Marrow">Bone Marrow</option>
                            <option value="Hair">Hair</option>
                            <option value="Nail">Nail</option>
                        </select>
                    </div>

                    <!-- Price -->
                    <div class="form-group">
                        <label for="editPrice">Price</label>
                        <input type="number" step="0.01" class="form-control" id="editPrice" name="price" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>


@push('specificJs')
<script>
    $(document).on('click', '.editBtn', function () {
    const id = $(this).data('id');
    const name = $(this).data('name');
    const specimen = $(this).data('specimen');
    const price = $(this).data('price');

    // Populate the modal fields
    $('#editTestId').val(id);
    $('#editName').val(name);
    $('#editSpecimen').val(specimen).trigger('change');
    $('#editPrice').val(price);

    // Show the modal
    $('#editTestModal').modal('show');
});

$('#editTestForm').on('submit', function (e) {
    e.preventDefault(); // Prevent the default form submission

    const id = $('#editTestId').val(); // Get the test ID from the hidden input
    const formData = $(this).serialize(); // Serialize the form data

    $.ajax({
        url: `{{ route('admin.updateExternalAvailableTest', ':id') }}`.replace(':id', id), // Dynamically replace :id with the test ID
        type: 'PUT', // HTTP method for updating
        data: formData, // Form data to be sent
        success: function (response) {
            // Show success message
            toastr.success(response.message);

            // Hide the modal
            $('#editTestModal').modal('hide');

            // Reload the DataTable to reflect the changes
            $('#testsTable').DataTable().ajax.reload();
        },
        error: function (xhr) {
            // Show error message
            toastr.error('An error occurred. Please try again.');
        }
    });
})
</script>
@endpush
