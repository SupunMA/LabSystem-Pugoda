@include('Users.Admin.messages.addMsg')

<div class="col-lg-6">
    <div class="box box-primary">

        <!-- /.box-header -->
        <!-- form start -->
        <div class="box-body">

            <div class="row">
                <div class="col-lg-8 col-12">
                    <div class="form-group">
                        <label >Name</label>
                        <input type="name" name="name" class="form-control" id="name" placeholder="Enter Name">
                    </div>
                </div>
            {{-- Gender --}}

                <div class="col-lg-4 col-12">
                    <div class="form-group">
                        <label>Gender</label>

                        <select class="form-control" style="width: 100%;" name="gender">
                            <option selected="selected" value="M">Male</option>
                            <option value="F">Female</option>
                            <option value="O">Other</option>


                        </select>
                    </div>
                </div>
            </div>


            <div class="row">
                <!-- Date -->
                <div class="col-lg-6 col-12">
                    <!-- Date dd/mm/yyyy -->
                    <!-- Date -->



                    <div class="form-group">
                        <label>Date of Birth (M/D/Y)</label>
                        <input type="date" id="edit-dob" name="dob" class="form-control">
                    </div>


                <!-- /.form group -->
                </div>



                {{-- email --}}
                <div class="col-lg-6 col-12">
                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" class="form-control" name="email" placeholder="Email (Optional)">
                    </div>
                </div>


            </div>



            <div class="row">
                <div class="col-lg-6 col-12">
                    <div class="form-group">
                        <label>Address</label>
                        <textarea class="form-control" rows="3" name="address" placeholder="Enter ..."></textarea>

                    </div>
                </div>
            </div>





            {{-- Role value --}}
            <input name="role" type="hidden" value="0">
            <!-- /.box-body -->


        </div>


    <!-- /.box -->
    </div>

</div>




@push('specificJs')



<script>
    $(document).ready(function () {
        $('#name').on('input', function () {
            let name = $(this).val();
            if (name.length < 3) {
                $(this).addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid');
            }
        });

        $('#email').on('input', function () {
            let email = $(this).val();
            let regex = /^\S+@\S+\.\S+$/;
            if (!regex.test(email)) {
                $(this).addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid');
            }
        });

        $('#password').on('input', function () {
            if ($(this).val().length < 8) {
                $(this).addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid');
            }
        });

        $('#password-confirm').on('input', function () {
            if ($(this).val() !== $('#password').val()) {
                $(this).addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid');
            }
        });
    });
</script>

<script>
    $('#patient-form').on('submit', function (e) {
        e.preventDefault(); // Prevent default form submission

        // Get the button and spinner elements
        const saveButton = $('#saveButton');
        const loadingSpinner = $('#loadingSpinner');

        // Show the spinner and disable the button
        loadingSpinner.show();
        saveButton.prop('disabled', true);

        let formData = new FormData(this);

        $.ajax({
            type: "POST",
            url: "{{ route('admin.addingPatient') }}",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                toastr.success('Patient added successfully!', 'Success');
                $('#patient-form')[0].reset();
                $('.is-invalid').removeClass('is-invalid');

                // Redirect to the all patients page after success
                setTimeout(function () {
                    window.location.href = "{{ route('admin.allPatient') }}";
                }, 3000); // Redirect after 3 seconds
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    $.each(errors, function (key, value) {
                        $(`[name="${key}"]`).addClass('is-invalid');
                        toastr.error(value[0], 'Validation Error');
                    });
                } else {
                    toastr.error('Something went wrong. Please try again.', 'Error');
                }
            },
            complete: function () {
                // Hide the spinner and re-enable the button
                loadingSpinner.hide();
                saveButton.prop('disabled', false);
            }
        });
    });

    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "timeOut": "8000"
    };
</script>

@endpush
