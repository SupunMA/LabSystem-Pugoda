<!-- Edit Modal -->
<div class="modal fade" id="editPatientModal" tabindex="-1" role="dialog" aria-labelledby="editPatientModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <form id="editPatientForm" action="{{ route('admin.updatePatient') }}"  method="POST">
        @csrf
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="editPatientModalLabel">Edit Patient's Details</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span>&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <input type="hidden" id="edit-id" name="userID">
            <input type="hidden" id="edit-pid" name="pid">
            <div class="form-group">
              <label>Name</label>
              <input type="text" id="edit-name" name="name" class="form-control">
            </div>
            <div class="form-group">
                <label>NIC</label>
                <input type="text" id="edit-nic" name="nic" class="form-control">
              </div>
            <div class="form-group row">
            <!-- Date of Birth Field -->
            <div class="col-md-6">
                <label>Date of Birth (M/D/Y)</label>
                <input type="date" id="edit-dob" name="dob" class="form-control">
            </div>

            <!-- Gender Field -->
            <div class="col-md-6">
                <label>Gender</label>
                <select id="edit-gender" name="gender" class="form-control">
                <option value="M">Male</option>
                <option value="F">Female</option>
                <option value="O">Other</option>
                </select>
            </div>
            </div>
            <div class="form-group">
              <label>Mobile</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                    </div>
                    <input type="text" id="edit-mobile" class="form-control" data-inputmask="&quot;mask&quot;: &quot;(999) 999-9999&quot;" data-mask="" inputmode="text" name="mobile">
                </div>
            </div>


            <div class="form-group">
              <label>Email</label>
              <input type="email" id="edit-email" name="email" class="form-control">
            </div>
            <div class="form-group">
              <label>Address</label>
              <textarea id="edit-address" name="address" class="form-control"></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Save changes</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          </div>
        </div>
      </form>
    </div>
  </div>


  @push('specificJs')
  <script>
        //Update Patient
    // AJAX Submit for Update
    $('#editPatientForm').submit(function (e) {
    e.preventDefault();

    const $btn = $('#editPatientForm button[type="submit"]');
    const originalBtnText = $btn.html();
    $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> Saving...');

    // Clear old errors
    $('#editPatientForm .is-invalid').removeClass('is-invalid');
    $('#editPatientForm .invalid-feedback').remove();

    $.ajax({
      url: "{{ route('admin.updatePatient') }}",
      type: 'POST',
      data: $(this).serialize(),
      success: function (response) {
        $('#editPatientModal').modal('hide');
        $('#patientsTable').DataTable().ajax.reload(null, false);
        toastr.success(response.message || 'Updated successfully');
      },
      error: function (xhr) {
        if (xhr.status === 422 && xhr.responseJSON.errors) {
          const errors = xhr.responseJSON.errors;
          // Loop through each field error
          $.each(errors, function (key, messages) {
            const input = $('#editPatientForm [name="' + key + '"]');
            input.addClass('is-invalid');
            input.after('<div class="invalid-feedback">' + messages[0] + '</div>');
          });
        } else {
          toastr.error('Something went wrong!');
        }
      },
      complete: function () {
        $btn.prop('disabled', false).html(originalBtnText);
      }
    });
  });
  </script>

  @endpush
