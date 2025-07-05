<div class="modal fade" id="requestTestModal" tabindex="-1" role="dialog" aria-labelledby="requestTestModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="requestTestModalLabel">Request Test for <span id="patientName"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="requestTestForm">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="patient_id" id="patientId">
                    <div class="form-group">
                        <label for="testName">Select Test</label>
                        <small class="form-text text-muted" style="font-size: 1.0rem;">
                            Note: <span style="color: red;">Red</span> indicate <span style="color: red;">Send-Out</span> tests, <span style="color: blue;">Blue</span> represent <span style="color: blue;">On-Site</span> tests.
                        </small>
                        <select class="form-control select2" id="testName" name="test_id" required>
                            <!-- Options will be populated dynamically -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="testDate">Test Date (M/D/Y)</label>
                        <div class="input-group">
                            <input type="date" class="form-control" id="testDate" name="test_date" required>
                            <div class="input-group-append">
                                <button type="button" class="btn btn-primary" id="setTodayBtn">Today</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Request Test</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('specificCSS')
<!-- Select2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap4-theme@1.0.0/dist/select2-bootstrap4.min.css">
@endpush

@push('specificJs')
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).on('click', '.requestTestBtn', function () {
        const patientId = $(this).data('id');
        const patientName = $(this).data('name');

        // Set patient details in the modal
        $('#patientId').val(patientId);
        $('#patientName').text(patientName);

        // Fetch available tests
        $.ajax({
            url: '{{ route("admin.getAvailableTests") }}', // Create this route
            type: 'GET',
            success: function (response) {
                const testSelect = $('#testName');
                testSelect.empty(); // Clear existing options

                // Add a placeholder option
                testSelect.append('<option value="" disabled selected>Select On-Site or Send-Out Tests</option>');

                // Populate the dropdown with test options
                response.forEach(test => {
                    const fontColor = test.is_internal ? 'blue' : 'red';
                    testSelect.append(`<option value="${test.id}" data-color="${fontColor}" style="color: ${fontColor};">${test.name} (${test.specimen}) - Rs/රු.${test.price}</option>`);
                });

                // Initialize Select2 after populating options
                testSelect.select2({
                    placeholder: 'Search and select a test...',
                    allowClear: true,
                    width: '100%',
                    dropdownParent: $('#requestTestModal'), // Important: ensures dropdown appears above modal
                    templateResult: function(option) {
                        if (!option.id) {
                            return option.text;
                        }
                        const $option = $(option.element);
                        const color = $option.data('color');
                        return $('<span style="color: ' + color + '">' + option.text + '</span>');
                    },
                    templateSelection: function(option) {
                        if (!option.id) {
                            return option.text;
                        }
                        const $option = $(option.element);
                        const color = $option.data('color');
                        return $('<span style="color: ' + color + '">' + option.text + '</span>');
                    }
                });

                // Show the modal
                $('#requestTestModal').modal('show');
            },
            error: function () {
                toastr.error('Failed to fetch available tests. Please try again.');
            }
        });
    });

    // Handle modal close event to destroy Select2 instance
    $('#requestTestModal').on('hidden.bs.modal', function () {
        $('#testName').select2('destroy');
    });

    // Change the color of the select element based on the selected option
    $('#testName').on('select2:select', function (e) {
        const selectedOption = $(e.target).find('option:selected');
        const color = selectedOption.data('color');
        $(this).next('.select2-container').find('.select2-selection__rendered').css('color', color);
    });
</script>

<script>
    document.getElementById('setTodayBtn').addEventListener('click', function () {
        // Get today's date in the format YYYY-MM-DD
        const today = new Date().toISOString().split('T')[0];

        // Set the value of the date input field to today's date
        document.getElementById('testDate').value = today;
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Get today's date in the format YYYY-MM-DD
        const today = new Date().toISOString().split('T')[0];

        // Set the value of the date input field to today's date
        document.getElementById('testDate').value = today;
    });
</script>

<script>
    $(document).ready(function () {
        // Set today's date when the "Today" button is clicked
        $('#setTodayBtn').on('click', function () {
            const today = new Date().toISOString().split('T')[0];
            $('#testDate').val(today);
        });

        // Handle form submission
        $('#requestTestForm').on('submit', function (e) {
            e.preventDefault(); // Prevent default form submission

            const formData = $(this).serialize(); // Serialize form data

            $.ajax({
                url: '{{ route("requestTest") }}', // Replace with your route name
                type: 'POST',
                data: formData,
                success: function (response) {
                    // Show success message
                    toastr.success(response.message);

                    // Close the modal
                    $('#requestTestModal').modal('hide');

                    // Optionally, refresh the table or UI to reflect the new test request
                    $('#patientsTable').DataTable().ajax.reload();
                },
                error: function (xhr) {
                    // Handle validation errors or other errors
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        for (const key in errors) {
                            toastr.error(errors[key][0]); // Display validation error messages
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
