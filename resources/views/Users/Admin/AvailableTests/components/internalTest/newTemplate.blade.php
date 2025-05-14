<!-- View Test Template Modal -->
<div class="modal fade" id="viewTemplateModal" tabindex="-1" role="dialog" aria-labelledby="viewTemplateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewTemplateModalLabel">Test Template: <span id="template-test-name"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="template-loading" class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
                <div id="template-content" style="display: none;">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p><strong>Specimen:</strong> <span id="template-specimen"></span></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Price:</strong> <span id="template-price"></span></p>
                        </div>
                    </div>

                    <h5 class="mt-4 mb-3">Template Structure</h5>
                    <div id="template-structure" class="border rounded p-3">
                        <!-- Template structure will be populated here -->
                    </div>
                </div>
                <div id="template-error" class="alert alert-danger" style="display: none;">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    <span id="template-error-message"></span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@push('specificCSS')
<style>
    /* Template structure styles */
    .category-item {
        background-color: #f8f9fa;
        border-left: 3px solid #17a2b8 !important;
        border-radius: 0.25rem;
    }

    /* Test table styles */
    #testsTable .btn-group .btn {
        margin-right: 2px;
    }

    #template-structure h5 {
        color: #495057;
    }

    #template-structure hr {
        border-top: 1px dashed #dee2e6;
    }
</style>
@endpush


@push('specificJs')
<script>
// View Template button handler
$(document).on('click', '.viewTemplateBtn', function() {
    const testId = $(this).data('id');
    const testName = $(this).data('name');

    // Reset modal content and show loading
    $('#template-test-name').text(testName);
    $('#template-loading').show();
    $('#template-content').hide();
    $('#template-error').hide();
    $('#template-structure').empty();

    // Show modal
    $('#viewTemplateModal').modal('show');

    // Load template data
    $.ajax({
        url: `{{ url('Admin/tests') }}/${testId}/template`,
        method: 'GET',
        success: function(response) {
            $('#template-loading').hide();

            if (response.success) {
                const test = response.test;
                const components = response.components;

                // Set basic test info
                $('#template-specimen').text(test.specimen ? ucFirst(test.specimen) : 'Not specified');
                $('#template-price').text(test.price ? new Intl.NumberFormat('en-US', {
                    style: 'currency',
                    currency: 'USD'
                }).format(test.price) : 'Not specified');

                // Build template structure visualization
                let structureHTML = '';

                components.forEach(function(component) {
                    switch(component.type) {
                        case 'category':
                            const category = component.data;

                            structureHTML += `
                                <div class="category-item mb-3 border-left border-info pl-3 py-1">
                                    <h6 class="font-weight-bold text-info">${category.name}</h6>
                                    <div class="ml-3">
                                        <p class="mb-1"><small>Result Type: ${ucFirst(category.value_type)}</small></p>
                                        ${category.unit_enabled ? `<p class="mb-1"><small>Unit: ${category.unit}</small></p>` : ''}

                                        ${getReferenceSummary(category)}
                                    </div>
                                </div>
                            `;
                            break;

                        case 'space':
                            structureHTML += `<hr class="my-3">`;
                            break;

                        case 'title':
                            structureHTML += `<h5 class="font-weight-bold mt-3">${component.data.content}</h5>`;
                            break;

                        case 'paragraph':
                            structureHTML += `<p>${component.data.content}</p>`;
                            break;
                    }
                });

                $('#template-structure').html(structureHTML || '<p>This test has no template elements defined.</p>');
                $('#template-content').show();
            } else {
                $('#template-error-message').text(response.message || 'Error loading template data.');
                $('#template-error').show();
            }
        },
        error: function(xhr) {
            $('#template-loading').hide();
            $('#template-error-message').text('Failed to load template data. Please try again.');
            $('#template-error').show();
            console.error('Template loading error:', xhr.responseText);
        }
    });
});

// Helper functions
function ucFirst(string) {
    if (!string) return '';
    return string.charAt(0).toUpperCase() + string.slice(1);
}

function getReferenceSummary(category) {
    if (category.reference_type === 'none') {
        return '<p class="mb-1"><small>Reference: Not specified</small></p>';
    } else if (category.reference_type === 'minmax') {
        let range = '';
        if (category.min_value !== null && category.max_value !== null) {
            range = `${category.min_value} - ${category.max_value}`;
            if (category.unit_enabled && category.unit) {
                range += ` ${category.unit}`;
            }
        } else if (category.min_value !== null) {
            range = `> ${category.min_value}`;
            if (category.unit_enabled && category.unit) {
                range += ` ${category.unit}`;
            }
        } else if (category.max_value !== null) {
            range = `<script ${category.max_value}`;
            if (category.unit_enabled && category.unit) {
                range += ` ${category.unit}`;
            }
        }
        return `<p class="mb-1"><small>Reference Range: ${range}</small></p>`;
    } else if (category.reference_type === 'table') {
        return '<p class="mb-1"><small>Reference: Reference table defined</small></p>';
    }

    return '';
}
</script>

@endpush
