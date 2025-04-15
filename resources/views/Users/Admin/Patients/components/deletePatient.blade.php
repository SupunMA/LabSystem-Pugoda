<!-- Delete Modal -->
<div class="modal fade" id="deletePatientModal" tabindex="-1" role="dialog" aria-labelledby="deletePatientModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <form  method="POST" id="deletePatientForm">
        @csrf
        <input type="hidden" name="pid" id="delete_pid">

        <div class="modal-content">
          <div class="modal-header bg-danger text-white">
            <h5 class="modal-title" id="deletePatientModalLabel">Delete Patient</h5>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="modal-body">
            <p>Are you sure you want to delete this patient?</p>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-danger">Yes, Delete</button>
          </div>
        </div>
      </form>
    </div>
  </div>


  @push('specificJs')
  <script>
    $('#deletePatientForm').submit(function(e) {
    e.preventDefault();

    const pid = $('#delete_pid').val();
    const url = "{{ route('admin.deletePatient') }}";
    const token = $('input[name="_token"]').val();

    const $submitBtn = $('#deletePatientForm button[type="submit"]');
    $submitBtn.prop('disabled', true).text('Deleting...');

    $.ajax({
        url: url,
        type: 'POST',
        data: {
            _token: token,
            pid: pid
        },
        success: function(response) {
            $('#deletePatientModal').modal('hide');
            $('#patientsTable').DataTable().ajax.reload(null, false);
            toastr.success(response.message);
        },
        error: function(xhr) {
            $('#deletePatientModal').modal('hide');
            if (xhr.responseJSON && xhr.responseJSON.message) {
                toastr.error(xhr.responseJSON.message);
            } else {
                toastr.error('Error deleting patient');
            }
        },
        complete: function() {
            $submitBtn.prop('disabled', false).text('Delete');
        }
    });
});
  </script>
@endpush
