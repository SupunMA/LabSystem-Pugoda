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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.66/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.66/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
@push('specificCSS')
<style>
    /* Add some basic styling for better appearance */








    /* Add this to your CSS section */
@media (max-width: 768px) {
    /* Ensure modal is properly sized on small screens */
    .modal-dialog {
        margin: 10px;
        max-width: calc(100% - 20px);
    }

    .modal-dialog.modal-lg {
        max-width: calc(100% - 20px);
    }

    /* Improve form layout on small screens */
    .modal-body .row .col-md-6 {
        margin-bottom: 10px;
    }


}


</style>
@endpush

@push('specificJs')
<script>
$(document).ready(function () {
    // Initialize DataTable (existing code)
// Replace your DataTable initialization with this corrected version
$('#testsTable').DataTable({
    processing: true,
    serverSide: true,
    responsive: {
        details: {
            type: 'column',
            target: 0  // Makes the first column (ID) the control column
        }
    },
    scrollX: true,
    autoWidth: false,
    lengthChange: true,
    ajax: {
        url: '{{ route("getAllInternalRequestedTests") }}',
        type: 'GET',
        error: function (xhr, error, code) {
            console.error('Error fetching data:', error);
            toastr.error('Error fetching data. Please check the console for details.');
        },
        dataSrc: function (json) {
            if (json.data && json.data.length > 0) {
                return json.data;
            }

        }
    },
    columnDefs: [
        {
            className: 'dtr-control',
            orderable: false,
            targets: 0  // First column becomes the control
        },
        {
            targets: -1,  // Last column (Actions)
            orderable: false,
            searchable: false
        }
    ],
    columns: [
        {
            data: 'id',
            name: 'id',
            title: 'ID',
            className: 'dtr-control'  // This adds the responsive control
        },
        { data: 'patient_name', name: 'patient_name', title: 'Patient Name' },
        { data: 'nic', name: 'nic', title: 'NIC', defaultContent: 'N/A' },
        { data: 'dob', name: 'dob', title: 'DOB' },
        { data: 'test_name', name: 'test_name', title: 'Test Name' },
        {
            data: 'test_date',
            name: 'test_date',
            title: 'Date',
            render: function (data) {
                return data ? moment(data).format('MMM D,YYYY') : 'N/A';
            }
        },
        {
            data: 'price',
            name: 'price',
            title: 'Price',
            render: $.fn.dataTable.render.number(',', '.', 2, 'Rs. ')
        },
        {
            data: null,  // Changed to null since we're using render function
            name: 'actions',
            title: 'Actions',
            orderable: false,
            searchable: false,
            render: function(data, type, row) {
                return `<button class="btn btn-sm btn-info addResultBtn"
                          data-id="${row.id}"
                          data-test-id="${row.test_id || row.availableTests_id}"
                          data-patient-name="${row.patient_name}"
                          data-test-name="${row.test_name}">
                          <i class="fas fa-plus-circle"></i> Add Result
                        </button>`;
            }
        }
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
    }
});

    // Variable to store test categories for Mindray processing
    let mindrayCategories = [];

    // Store all categories for formula calculation
    let allCategories = [];

    // Handle Add Result button click
// Replace the existing click handler with this improved version
$('#testsTable').on('click', '.addResultBtn', function() {
    const requestedTestId = $(this).data('id');
    const testId = $(this).data('test-id');
    const button = $(this);
    const dataTable = $('#testsTable').DataTable();

    // Get row data - handle both regular and responsive modes
    let rowData;
    const row = button.closest('tr');

    if (row.hasClass('child')) {
        // This is a child row in responsive mode, get parent row
        const parentRow = row.prev('tr');
        rowData = dataTable.row(parentRow).data();
    } else {
        // Regular row or parent row in responsive mode
        rowData = dataTable.row(row).data();
    }

    // Fallback: if rowData is still undefined, try to get it by button's data attributes
    if (!rowData) {
        // You can store additional data attributes on the button for fallback
        rowData = {
            patient_name: button.data('patient-name') || 'Unknown Patient',
            test_name: button.data('test-name') || 'Unknown Test'
        };
    }

    // Validate that we have the necessary data
    if (!rowData || !rowData.patient_name) {
        toastr.error('Unable to retrieve patient data. Please refresh the page and try again.');
        return;
    }

    // Set modal title and data
    $('#requested_test_id').val(requestedTestId);
    $('#modalPatientName').text(rowData.patient_name || 'Unknown Patient');
    $('#modalTestName').text(rowData.test_name || 'Unknown Test');

    // Clear previous categories and Mindray section
    $('#categoriesContainer').empty();

    // Show loading
    $('#categoriesContainer').html('<div class="text-center py-3"><i class="fas fa-spinner fa-spin fa-2x"></i><p class="mt-2">Loading test categories...</p></div>');

    // Rest of your existing code for fetching test categories...
    $.ajax({
        url: '{{ route("getTestCategories", "") }}/' + testId,
        method: 'GET',
        success: function(response) {
            // Your existing success handler code remains the same
            if (response.success && response.categories.length > 0) {
                $('#categoriesContainer').empty();
                mindrayCategories = [];
                allCategories = response.categories;

                const hasMindrayCategories = response.categories.some(category => category.value_type === 'getFromMindray');

                if (hasMindrayCategories) {
                    const mindrayUploadHtml = `
                        <div class="card mb-3" id="mindrayFileUploadSection">
                            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                                <h5 class="mb-0"><i class="fas fa-upload"></i> Mindray File Upload</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Upload Mindray .txt file:</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="master_mindray_file_input" accept=".txt">
                                            <label class="custom-file-label" for="master_mindray_file_input">Choose .txt file</label>
                                        </div>
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="button" id="readMindrayFileBtn">Read File</button>
                                        </div>
                                    </div>
                                    <small class="form-text text-muted mt-2">Upload a single .txt file from the Mindray machine. Data for relevant categories will be extracted.</small>
                                </div>
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="mindrayManualEntryToggle">
                                    <label class="custom-control-label text-black" for="mindrayManualEntryToggle">Manual Entry</label>
                                </div>
                            </div>
                        </div>
                    `;
                    $('#categoriesContainer').prepend(mindrayUploadHtml);
                }

                response.categories.forEach(function(category, index) {
                    const categoryHtml = createCategoryInputs(category, index);
                    $('#categoriesContainer').append(categoryHtml);
                    if (category.value_type === 'getFromMindray') {
                        mindrayCategories.push({
                            id: category.id,
                            name: category.name,
                            param: category.value_type_Value,
                            index: index
                        });
                    }
                });

                $('.mindray-result-input').prop('readonly', !$('#mindrayManualEntryToggle').is(':checked'));
                calculateAllFormulaFields();

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
            <div class="card mb-3 category-card" data-category-id="${category.id}" data-category-name="${category.name}">
                <div class="card-header bg-light">
                    <h5 class="mb-0">${category.name}</h5>
                </div>
                <div class="card-body">
                    <input type="hidden" name="results[${index}][category_id]" value="${category.id}">
                    <input type="hidden" name="results[${index}][value_type]" value="${category.value_type}">
        `;

        // Add appropriate input based on value_type
        switch(category.value_type) {
            case 'number':
            case 'range': // 'range' also uses number input for value
                html += `
                    <div class="form-group">
                        <label>Value:${category.unit_enabled ? ' (' + category.unit + ')' : ''}</label>
                        <input type="number" class="form-control category-input" name="results[${index}][value]" required step="any" data-category-id="${category.id}">
                    </div>
                    ${category.reference_type === 'minmax' ?
                      `<small class="text-muted">Reference Range: ${category.min_value} - ${category.max_value}${category.unit_enabled ? ' ' + category.unit : ''}</small>` : ''}
                `;
                break;

            case 'text':
                html += `
                    <div class="form-group">
                        <label>Result:</label>
                        <textarea class="form-control category-input" name="results[${index}][value]" rows="2" required data-category-id="${category.id}"></textarea>
                    </div>
                `;
                break;

            case 'negpos':
                html += `
                    <div class="form-group">
                        <label>Result:</label>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="positive_${category.id}" name="results[${index}][value]" class="custom-control-input category-input" value="Positive" required data-category-id="${category.id}">
                            <label class="custom-control-label" for="positive_${category.id}">Positive</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="negative_${category.id}" name="results[${index}][value]" class="custom-control-input category-input" value="Negative" required>
                            <label class="custom-control-label" for="negative_${category.id}">Negative</label>
                        </div>
                    </div>
                `;
                break;

            case 'negpos_with_Value':
                html += `
                    <div class="form-group">
                        <label>Result:</label>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="positive_${category.id}" name="results[${index}][value]" class="custom-control-input category-input" value="Positive" required data-category-id="${category.id}">
                            <label class="custom-control-label" for="positive_${category.id}">Positive</label>
                        </div>
                        <div class="custom-control custom-radio mb-2">
                            <input type="radio" id="negative_${category.id}" name="results[${index}][value]" class="custom-control-input category-input" value="Negative" required>
                            <label class="custom-control-label" for="negative_${category.id}">Negative</label>
                        </div>
                        <label for="additional_value_${category.id}">Associated Value (Optional):${category.unit_enabled ? ' (' + category.unit + ')' : ''}</label>
                        <input type="text" class="form-control category-input" id="additional_value_${category.id}" name="results[${index}][additional_value]">
                    </div>
                `;
                break;

            case 'getFromMindray':
                html += `
                    <div class="form-group">
                        <label>Mindray Data for "${category.value_type_Value}"${category.unit_enabled ? ' (' + category.unit + ')' : ''}:</label>
                        <input type="text" class="form-control mindray-result-input category-input" name="results[${index}][value]" id="mindray_result_${category.id}" placeholder="Extracted Value" readonly required data-mindray-param="${category.value_type_Value}" data-category-id="${category.id}" data-category-index="${index}">
                        <small class="form-text text-muted">Value extracted from Mindray file for parameter: <strong>${category.value_type_Value}</strong>.</small>
                    </div>
                `;
                break;

            case 'dropdown':
                const options = category.value_type_Value ? category.value_type_Value.split(',') : [];
                html += `
                    <div class="form-group">
                        <label>Select Result:${category.unit_enabled ? ' (' + category.unit + ')' : ''}</label>
                        <select class="custom-select category-input" name="results[${index}][value]" required data-category-id="${category.id}">
                            <option value="">-- Select --</option>
                            ${options.map(option => `<option value="${option.trim()}">${option.trim()}</option>`).join('')}
                        </select>
                    </div>
                `;
                break;

            case 'formula':
                html += `
                    <div class="form-group">
                        <label>Calculated Result:${category.unit_enabled ? ' (' + category.unit + ')' : ''}</label>
                        <input type="number" class="form-control formula-result-input category-input" name="results[${index}][value]" id="formula_result_${category.id}" data-formula="${category.value_type_Value}" data-category-id="${category.id}" required step="any">
                        <small class="form-text text-muted">This value is derived from a formula: <code>${category.value_type_Value}</code>. You can adjust it manually.</small>
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

    // Handle master Mindray file input change
    $(document).on('change', '#master_mindray_file_input', function() {
        const input = this;
        const fileName = input.files[0] ? input.files[0].name : 'Choose .txt file';
        $(input).next('.custom-file-label').html(fileName);
    });

    // Handle master Mindray read button click
    $(document).on('click', '#readMindrayFileBtn', function() {
        const fileInput = $('#master_mindray_file_input')[0];

        if (fileInput.files.length === 0) {
            toastr.warning('Please select a .txt file first.');
            return;
        }

        // Ensure manual entry is disabled when reading file
        $('#mindrayManualEntryToggle').prop('checked', false).trigger('change');

        const file = fileInput.files[0];
        const reader = new FileReader();

        reader.onload = function(e) {
            const fileContent = e.target.result;
            let foundCount = 0;

            mindrayCategories.forEach(function(category) {
                const mindrayParam = category.param;
                const resultInput = $(`#mindray_result_${category.id}`);
                let extractedValue = 'N/A';

                // Robust regex for various formats, e.g., "WBC : 5.2", "HGB=14.5", "PLT 250"
                const regex = new RegExp(`(?:${mindrayParam}|${mindrayParam.replace(/\s+/g, '')}|${mindrayParam.replace(/([A-Z])/g, ' $1').trim()})\\s*[:=\\s]*([\\d\\.-]+)`, 'i');
                const match = fileContent.match(regex);

                if (match && match[1]) {
                    extractedValue = match[1];
                    foundCount++;
                } else {
                    // Fallback to simpler regex if the first one fails
                    const simplerRegex = new RegExp(`\\b${mindrayParam}\\b[^\\d\\.-]*([\\d\\.-]+)`, 'i');
                    const simplerMatch = fileContent.match(simplerRegex);
                    if (simplerMatch && simplerMatch[1]) {
                        extractedValue = simplerMatch[1];
                        foundCount++;
                    } else {
                        toastr.warning(`Could not find parameter "${mindrayParam}" in the file.`);
                    }
                }
                resultInput.val(extractedValue).trigger('input'); // Trigger 'input' for formula calculation
            });

            if (foundCount > 0) {
                toastr.success(`Successfully extracted ${foundCount} parameter(s) from Mindray file.`);
            } else {
                toastr.info('No Mindray parameters extracted from the file.');
            }
        };

        reader.onerror = function() {
            toastr.error('Error reading file.');
            // Clear all Mindray results on error
            $('.mindray-result-input').val('Error').trigger('input');
        };

        reader.readAsText(file);
    });

    // --- Formula Calculation Logic ---

    // Function to get the current value of a category by its name (for formula evaluation)
    function getCategoryValueByName(categoryName) {
        let value = null;
        // Find the category card by its data-category-name attribute
        const categoryCard = $(`.category-card[data-category-name="${categoryName.trim()}"]`);

        if (categoryCard.length > 0) {
            // Find the input within this specific category card that holds the value
            // We use .filter(':input[name$="[value]"]') to target the primary result input
            const inputElement = categoryCard.find(':input[name$="[value]"]').first();

            if (inputElement.length > 0) {
                if (inputElement.attr('type') === 'radio') {
                    value = categoryCard.find(':input[name$="[value]"]:checked').val();
                } else {
                    value = inputElement.val();
                }
            }
        }
        return value;
    }


    // Function to calculate a single formula field
    function calculateFormula(formulaElement) {
        const formula = $(formulaElement).data('formula');
        let calculatedValue;

        try {
            // Replace category names in curly braces {Category Name} with their current values
            let executableFormula = formula.replace(/\{([^}]+)\}/g, (match, categoryName) => {
                const categoryValue = getCategoryValueByName(categoryName.trim());

                if (categoryValue === null || categoryValue === '') {
                    return 0; // Treat missing or empty values as 0 for calculation
                }
                // Attempt to parse as float, if not a number, return 0
                return isNaN(parseFloat(categoryValue)) ? 0 : parseFloat(categoryValue);
            });

            // Evaluate the formula
            calculatedValue = eval(executableFormula);
            if (isNaN(calculatedValue)) {
                calculatedValue = 'Invalid Calculation';
            }
        } catch (e) {
            console.error('Error evaluating formula:', formula, e);
            calculatedValue = 'Error';
        }

        // Set the calculated value and ensure it's editable
        $(formulaElement).val(calculatedValue);
    }

    // Function to calculate all formula fields in the modal
    function calculateAllFormulaFields() {
        $('.formula-result-input').each(function() {
            calculateFormula(this);
        });
    }

    // Recalculate formulas whenever a relevant input changes
    // Targets all category inputs EXCEPT formula inputs
    $(document).on('input change', '.category-input:not(.formula-result-input)', function() {
        calculateAllFormulaFields();
    });

    // --- End Formula Calculation Logic ---

    // --- Mindray Manual Entry Toggle Logic ---
    $(document).on('change', '#mindrayManualEntryToggle', function() {
        const isChecked = $(this).is(':checked');
        $('.mindray-result-input').prop('readonly', !isChecked);
        if (isChecked) {
            toastr.info('Mindray result fields are now editable for manual entry.');
        } else {
            toastr.info('Mindray result fields are set to read-only.');
            // If toggle is disabled, clear values only if they were manually entered (optional, but good for consistency)
            // Or, simply reset to 'N/A' if you want to explicitly clear them.
            // For now, we just make them readonly.
        }
    });
    // --- End Mindray Manual Entry Toggle Logic ---

    // Handle Save Results button click
    $('#saveResultsBtn').click(function() {
        // Check if all required fields are filled
        let valid = true;
        $('#resultForm [required]').each(function() {
            if ($(this).val() === '' || ($(this).attr('type') === 'radio' && $(`input[name="${$(this).attr('name')}"]:checked`).length === 0)) {
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
            const valueType = $(this).find('input[name^="results"][name$="[value_type]"]').val();
            let value;
            let additionalValue = null;

            // Handle different input types
            if (valueType === 'getFromMindray' || valueType === 'formula') {
                 // For Mindray and Formula, value is taken directly from the displayed input field
                value = $(this).find('input[name^="results"][name$="[value]"]').val();
            } else if ($(this).find('textarea[name^="results"][name$="[value]"]').length) {
                value = $(this).find('textarea[name^="results"][name$="[value]"]').val();
            } else if ($(this).find('input[type="radio"][name^="results"][name$="[value]"]:checked').length) {
                value = $(this).find('input[type="radio"][name^="results"][name$="[value]"]:checked').val();
                if (valueType === 'negpos_with_Value') {
                    // Changed to 'text' type, so just get the value
                    additionalValue = $(this).find('input[name^="results"][name$="[additional_value]"]').val();
                }
            } else { // Includes 'number', 'range', 'dropdown'
                value = $(this).find('input[name^="results"][name$="[value]"], select[name^="results"][name$="[value]"]').val();
            }

            formData.results.push({
                category_id: categoryId,
                value_type: valueType, // Include value type for server-side processing
                value: value,
                additional_value: additionalValue // For negpos_with_Value
            });
        });

        // Send data to server
        $.ajax({
            url: '{{ route("storeTestResults") }}', // Replace with your actual Laravel route
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
                // Dummy success response for demonstration
                const successResponse = {
                    success: true,
                    message: 'Results saved successfully!'
                };

                if (successResponse.success) {
                    // Show success message
                    toastr.success(successResponse.message);

                    // Close modal and refresh table
                    $('#resultModal').modal('hide');
                    $('#testsTable').DataTable().ajax.reload();
                } else {
                    toastr.error(successResponse.message || 'Failed to save results.');
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
     // Reset validation for radio buttons
     $(document).on('change', 'input[type="radio"][name^="results"]', function() {
        const name = $(this).attr('name');
        if ($(`input[name="${name}"]:checked`).length > 0) {
            $(`input[name="${name}"]`).removeClass('is-invalid');
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
