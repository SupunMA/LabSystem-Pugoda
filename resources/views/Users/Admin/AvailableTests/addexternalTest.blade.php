@extends('layouts.adminLayout')

@section('content')
<div class="container-fluid">
    <!-- Button to View External Available Tests -->
    <a class="btn btn-danger mb-3" href="{{ route('admin.allExternalAvailableTest') }}">
        <i class="fa fa-th-list" aria-hidden="true"></i>
        <b> View SendOut Available Tests</b>
    </a>

    <!-- Card for the Form -->
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Add SendOut Available Test</h3>
        </div>
        <!-- /.card-header -->

        <!-- Form Start -->
        <form id="addTestForm" method="POST">
            @csrf
            <div class="card-body">
                <!-- Test Name -->
                <div class="form-group">
                    <label for="name">Test Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter Test Name" required>
                </div>

                <!-- Specimen and Price Row -->
                <div class="row">
                    <!-- Specimen -->
                    <div class="form-group col-md-6">
                        <label for="specimen">Specimen</label>
                        <select class="form-control select2" id="specimen" name="specimen" required>
                            <option value="" disabled selected>Select Specimen</option>
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
                    <div class="form-group col-md-6">
                        <label for="price">Price</label>
                        <input type="number" step="10" class="form-control" id="price" name="price" placeholder="Enter Price" required>
                    </div>
                </div>

                <!-- Hidden Field for is_internal -->
                <input type="hidden" name="is_internal" value="0">
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <button type="submit" class="btn btn-success float-right">
                    <i class="fa fa-save"></i> Save
                </button>
            </div>
        </form>
        <!-- /.form -->
    </div>
    <!-- /.card -->
</div>
@endsection

@section('header')
Add SendOut Available Test
@endsection

@push('specificCSS')
<!-- Include Select2 CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
@endpush

@push('specificJs')
<!-- Include Select2 JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script>
    $(function () {
        // Initialize Select2 Elements
        $('.select2').select2({
            dropdownParent: $('#addTestForm') // Attach dropdown to the form
        });

        // Handle Form Submission with AJAX
        $('#addTestForm').on('submit', function (e) {
            e.preventDefault(); // Prevent default form submission

            let formData = $(this).serialize(); // Serialize form data

            $.ajax({
                url: '{{ route("admin.addingExternalAvailableTest") }}', // Replace with your route
                type: 'POST',
                data: formData,
                success: function (response) {
                    // Show success message
                    toastr.success(response.message);

                    // Clear the form
                    $('#addTestForm')[0].reset();

                    // Reset Select2 dropdown
                    $('#specimen').val(null).trigger('change');
                },
                error: function (xhr) {
                    // Handle validation errors
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        for (let key in errors) {
                            toastr.error(errors[key][0]);
                        }
                    } else {
                        toastr.error('Something went wrong. Please try again.');
                    }
                }
            });
        });
    });
</script>
@endpush
