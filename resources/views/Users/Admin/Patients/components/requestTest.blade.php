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
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
@endpush

@push('specificJs')
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

                // Add a placeholder option (Select2 will use this as the initial selection)
                testSelect.append('<option value="">Select On-Site or Send-Out Tests</option>');

                // Populate the dropdown with test options
                response.forEach(test => {
                    const fontColor = test.is_internal ? 'blue' : 'red';
                    testSelect.append(`<option value="${test.id}" data-color="${fontColor}" style="color: ${fontColor};">${test.name} (${test.specimen}) - Rs/රු.${test.price}</option>`);
                });

                // Initialize Select2 after options are populated
                testSelect.select2({
                    placeholder: "Select On-Site or Send-Out Tests", // This will be visible when nothing is selected
                    allowClear: true // Option to clear the selection
                });

                // Set the initial color of the Select2 container based on the default selected option (if any)
                // This might be tricky as the placeholder isn't an option. You might need to re-evaluate
                // the color change logic with Select2, as Select2 creates its own DOM structure.
                // For now, the option text itself will have the color. If you need the Select2 *input* to change color,
                // you'll need a different approach (e.g., custom Select2 template or CSS based on selected value).

                // Show the modal
                $('#requestTestModal').modal('show');
            },
            error: function () {
                toastr.error('Failed to fetch available tests. Please try again.');
            }
        });
    });

    // To apply the color to the *selected* item within the Select2 input,
    // you'll likely need a custom `templateSelection` function for Select2.
    // The current `.on('change')` listener on the original select element won't directly
    // style the Select2 generated elements.
    // For a quick fix, let's just make sure the option itself still has the color,
    // and if you want the Select2 display box to change color, it's more complex.
    // For now, remove the direct `.css('color', color)` on the select element itself,
    // as Select2 will manage its own styling.
    // The options within the dropdown will still display their respective colors.
    // If you specifically want the selected value in the Select2 input box to also have the color,
    // you'll need to use Select2's `templateSelection` option.
    // Example for templateSelection (add this inside testSelect.select2({...})):
    /*
    templateSelection: function(state) {
        if (!state.id) {
            return state.text;
        }
        const color = $(state.element).data('color');
        if (color) {
            return $('<span>' + state.text + '</span>').css('color', color);
        }
        return state.text;
    }
    */
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
