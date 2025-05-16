<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <table id="testsTable" class="table table-bordered table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Patient Name</th>
                            <th>NIC</th>
                            <th>DOB</th>
                            <th>Test Name</th>
                            <th>Date</th>
                            <th>Price</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data will be populated via AJAX -->
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Patient Name</th>
                            <th>NIC</th>
                            <th>DOB</th>
                            <th>Test Name</th>
                            <th>Date</th>
                            <th>Price</th>
                            <th>Actions</th>
                        </tr>
                    </tfoot>
                </table>

            </div>
        </div>
    </div>
</section>

{{-- add result modal --}}
<!-- Result Entry Modal -->
<div class="modal fade" id="resultModal" tabindex="-1" role="dialog" aria-labelledby="resultModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="resultModalLabel">Add Test Results</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="resultForm">
                    <meta name="csrf-token" content="{{ csrf_token() }}">
                    {{-- @csrf --}}
                    <input type="hidden" id="requested_test_id" name="requested_test_id">

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Patient:</label>
                                <span id="modalPatientName" class="font-weight-bold"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Test:</label>
                                <span id="modalTestName" class="font-weight-bold"></span>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> Please fill in the results for all test categories below.
                    </div>

                    <div id="categoriesContainer">
                        <!-- Test categories will be dynamically added here -->
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveResultsBtn">
                    <i class="fas fa-save"></i> Save Results
                </button>
            </div>
        </div>
    </div>
</div>


@push('specificJs')
<script>
$(document).ready(function () {
    // Initialize DataTable (existing code)
    $('#testsTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        scrollX: true,
        autoWidth: false,
        lengthChange: true,
        ajax: {
            url: '{{ route("getAllInternalRequestedTests") }}',
            type: 'GET',
            error: function (xhr, error, code) {
                console.error('Error fetching data:', error);
            },
        },
        columns: [
            { data: 'id', name: 'id', title: 'ID' },
            { data: 'patient_name', name: 'patient_name', title: 'Patient Name' },
            { data: 'nic', name: 'nic', title: 'NIC' },
            { data: 'dob', name: 'dob', title: 'DOB' },
            { data: 'test_name', name: 'test_name', title: 'Test Name' },
            {
                data: 'test_date',
                name: 'test_date',
                title: 'Date',
                render: function (data) {
                    return data ? moment(data).format('MMM D, YYYY') : 'N/A';
                }
            },
            {
                data: 'price',
                name: 'price',
                title: 'Price',
                render: $.fn.dataTable.render.number(',', '.', 2, 'Rs. ')
            },
            { data: 'actions', name: 'actions', title: 'Actions', orderable: false, searchable: false }
        ],
        order: [[0, 'desc']],
        dom: 'flBrtip',
        buttons: [
            {
                extend: 'pdf',
                text: 'PDF',
                orientation: 'portrait',
                pageSize: 'A4',
                exportOptions: {
                    columns: ':not(:last-child)',
                },
            },
            {
                extend: 'excel',
                text: 'Excel',
                exportOptions: {
                    columns: ':not(:last-child)',
                },
            },
            {
                extend: 'print',
                text: 'Print',
                exportOptions: {
                    columns: ':not(:last-child)',
                },
            },
        ],
        language: {
            emptyTable: "No data available in the table",
            processing: "Loading data, please wait...",
        },
    });

    // Handle Add Result button click
    $('#testsTable').on('click', '.addResultBtn', function() {
        const requestedTestId = $(this).data('id');
        const testId = $(this).data('test-id');
        const row = $(this).closest('tr');
        const dataTable = $('#testsTable').DataTable();
        const rowData = dataTable.row(row).data();

        // Set modal title and data
        $('#requested_test_id').val(requestedTestId);
        $('#modalPatientName').text(rowData.patient_name);
        $('#modalTestName').text(rowData.test_name);

        // Clear previous categories
        $('#categoriesContainer').empty();

        // Show loading
        $('#categoriesContainer').html('<div class="text-center py-3"><i class="fas fa-spinner fa-spin fa-2x"></i><p class="mt-2">Loading test categories...</p></div>');

        // Fetch test categories
        $.ajax({
            url: '{{ route("getTestCategories", "") }}/' + testId,
            method: 'GET',
            success: function(response) {
                if (response.success && response.categories.length > 0) {
                    // Clear loading
                    $('#categoriesContainer').empty();

                    // Add categories to form
                    response.categories.forEach(function(category, index) {
                        const categoryHtml = createCategoryInputs(category, index);
                        $('#categoriesContainer').append(categoryHtml);
                    });
                } else {
                    $('#categoriesContainer').html('<div class="alert alert-warning">No test categories found for this test.</div>');
                }
            },
            error: function() {
                $('#categoriesContainer').html('<div class="alert alert-danger">Failed to load test categories. Please try again.</div>');
            }
        });

        // Show modal
        $('#resultModal').modal('show');
    });

    // Function to create appropriate inputs based on category type
    function createCategoryInputs(category, index) {
        let html = `
            <div class="card mb-3 category-card">
                <div class="card-header bg-light">
                    <h5 class="mb-0">${category.name}</h5>
                </div>
                <div class="card-body">
                    <input type="hidden" name="results[${index}][category_id]" value="${category.id}">
        `;

        // Add appropriate input based on value_type
        switch(category.value_type) {
            case 'range':
                html += `
                    <div class="form-group">
                        <label>Value:${category.unit_enabled ? ' (' + category.unit + ')' : ''}</label>
                        <input type="number" class="form-control" name="results[${index}][value]" required step="any">
                    </div>
                    ${category.reference_type === 'minmax' ?
                      `<small class="text-muted">Reference Range: ${category.min_value} - ${category.max_value}${category.unit_enabled ? ' ' + category.unit : ''}</small>` : ''}
                `;
                break;

            case 'text':
                html += `
                    <div class="form-group">
                        <label>Result:</label>
                        <textarea class="form-control" name="results[${index}][value]" rows="2" required></textarea>
                    </div>
                `;
                break;

            case 'negpos':
                html += `
                    <div class="form-group">
                        <label>Result:</label>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="positive_${category.id}" name="results[${index}][value]" class="custom-control-input" value="Positive" required>
                            <label class="custom-control-label" for="positive_${category.id}">Positive</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="negative_${category.id}" name="results[${index}][value]" class="custom-control-input" value="Negative" required>
                            <label class="custom-control-label" for="negative_${category.id}">Negative</label>
                        </div>
                    </div>
                `;
                break;
        }

        html += `
                </div>
            </div>
        `;

        return html;
    }

    // Handle Save Results button click
    $('#saveResultsBtn').click(function() {
        // Check if all required fields are filled
        let valid = true;
        $('#resultForm [required]').each(function() {
            if ($(this).val() === '') {
                valid = false;
                $(this).addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid');
            }
        });

        if (!valid) {
            toastr.error('Please fill in all required fields.');
            return;
        }

        // Collect all form data
        const formData = {
            requested_test_id: $('#requested_test_id').val(),
            results: []
        };

        // Collect results from each category
        $('.category-card').each(function(index) {
            const categoryId = $(this).find('input[name^="results"][name$="[category_id]"]').val();
            let value;

            // Handle different input types
            if ($(this).find('textarea[name^="results"][name$="[value]"]').length) {
                value = $(this).find('textarea[name^="results"][name$="[value]"]').val();
            } else if ($(this).find('input[type="radio"][name^="results"][name$="[value]"]:checked').length) {
                value = $(this).find('input[type="radio"][name^="results"][name$="[value]"]:checked').val();
            } else {
                value = $(this).find('input[name^="results"][name$="[value]"]').val();
            }

            formData.results.push({
                category_id: categoryId,
                value: value
            });
        });

        // Send data to server
        $.ajax({
            url: '{{ route("storeTestResults") }}',
            method: 'POST',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function() {
                // Disable button and show loading state
                $('#saveResultsBtn').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Saving...');
            },
            success: function(response) {
                if (response.success) {
                    // Show success message
                    toastr.success(response.message);

                    // Close modal and refresh table
                    $('#resultModal').modal('hide');
                    $('#testsTable').DataTable().ajax.reload();
                } else {
                    toastr.error(response.message || 'Failed to save results.');
                }
            },
            error: function(xhr) {
                const errorMsg = xhr.responseJSON && xhr.responseJSON.message
                    ? xhr.responseJSON.message
                    : 'An error occurred while saving results.';

                toastr.error(errorMsg);
            },
            complete: function() {
                // Reset button state
                $('#saveResultsBtn').prop('disabled', false).html('<i class="fas fa-save"></i> Save Results');
            }
        });
    });

    // Reset validation on input change
    $(document).on('input change', '#resultForm [required]', function() {
        if ($(this).val() !== '') {
            $(this).removeClass('is-invalid');
        }
    });

    // Adjust table on window resize
    $(window).on('resize', function() {
        $('#testsTable').DataTable().columns.adjust().draw();
    });

    // Adjust table when sidebar is toggled
    $('a[data-widget="pushmenu"]').on('click', function() {
        setTimeout(function() {
            $('#testsTable').DataTable().columns.adjust().draw();
        }, 300);
    });

    // Initialize toastr
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "timeOut": "8000"
    };
});
</script>
@endpush
