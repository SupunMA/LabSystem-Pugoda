
<div class="container col-lg-12 col-sm-12">
    <form action="{{ route('admin.storeNewTest') }}" method="POST">
        <div id="tests-container">
        <div class="test-block">

            @csrf
            <div class="row mb-3">
                <div class="mb-3 col-lg-8">
                <label class="form-label">Test Name</label>
                <input type="text" name="tests[0][name]" class="form-control test-name" />
                </div>
                <div class="col col-lg-4">
                <label class="form-label">Specimen</label>
                <select name="tests[0][specimen]" class="form-control select2">
                    <option value="">--Select Specimen Type--</option>
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
            </div>
            <div class="row mb-3">
            <div class="col col-lg-4">
                <label class="form-label">Price</label>
                <input type="number" name="tests[0][price]" class="form-control" step="10.00" />
            </div>
            </div>
            <div class="categories-container"></div>
            <div class="button-group mt-2">
                <button type="button" class="btn btn-primary add-category mb-1">
                    <i class="fas fa-folder-plus me-1"></i> Add Category
                </button>

                <button type="button" class="btn btn-secondary add-space mb-1">
                    <i class="fas fa-arrows-alt-v me-1"></i> Add Space
                </button>

                <button type="button" class="btn btn-secondary add-title mb-1">
                    <i class="fas fa-heading me-1"></i> Add Title
                </button>

                <button type="button" class="btn btn-secondary add-paragraph mb-1">
                    <i class="fas fa-align-left me-1"></i> Add Paragraph
                </button>
            </div>

        </div>
        </div>

        <div class="d-flex justify-content-end mb-4">
            <button type="submit" id="save-tests" class="btn btn-success">
                <i class="fas fa-save me-1"></i> Save Test Data
            </button>
        </div>
    </form>
</div>


@push('specificCSS')
{{-- select 2 --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
<style>
    .test-block, .category-block {
        border: 2px solid #dee2e6;
        padding: 20px;
        margin-bottom: 20px;
        border-radius: 10px;
    }
    .category-block { background-color: #f8f9fa; }
    table input { width: 100%; }
</style>
@endpush

@push('specificJs')
{{-- select 2 --}}
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
// Modified JavaScript for Medical Test Form

let testIndex = 0;

function getUnitToggleAndDropdown(name, unitNameBase) {
  return `
    <div class="mb-3">
      <div class="form-check mb-2">
        <input class="form-check-input enable-unit" type="checkbox" id="${unitNameBase}_enabled">
        <label class="form-check-label" for="${unitNameBase}_enabled">Enable Unit</label>
      </div>
      <div class="unit-dropdown" style="display: none;">
        <label class="form-label">Unit</label>
        <select name="${name}" class="form-control select2">
          <option value="">--Select Unit--</option>
            <option value="%">%</option>
            <option value="fL">Femtolitres</option>
            <option value="g">Grams</option>
            <option value="g/dL">Grams per decilitre (g/dL)</option>
            <option value="g/L">Grams per litre (g/L)</option>
            <option value="IU/L">International units per litre (IU/L)</option>
            <option value="IU/mL">International units per millilitre (IU/mL)</option>
            <option value="mcg">Micrograms (mcg)</option>
            <option value="mcg/dL">Micrograms per decilitre (mcg/dL)</option>
            <option value="mcg/L">Micrograms per litre (mcg/L)</option>
            <option value="mckat/L">Microkatals per litre (mckat/L)</option>
            <option value="mL">Microlitres (mcL)</option>
            <option value="mcmol/L">Micromoles per litre (mcmol/L)</option>
            <option value="mEq">Milliequivalents (mEq)</option>
            <option value="mEq/L">Milliequivalents per litre (mEq/L)</option>
            <option value="mg">Milligrams (mg)</option>
            <option value="mg/dL">Milligrams per decilitre (mg/dL)</option>
            <option value="mg/L">Milligrams per litre (mg/L)</option>
            <option value="mIU/L">Milli-international units per litre (mIU/L)</option>
            <option value="mL">Millilitres (mL)</option>
            <option value="mm">Millimetres (mm)</option>
            <option value="mmHg">Millimetres of mercury (mm Hg)</option>
            <option value="mmol">Millimoles (mmol)</option>
            <option value="mmol/L">Millimoles per litre (mmol/L)</option>
            <option value="mOsm/kg">Milliosmoles per kilogram of water (mOsm/kg water)</option>
            <option value="mU/g">Milliunits per gram (mU/g)</option>
            <option value="mU/L">Milliunits per litre (mU/L)</option>
            <option value="ng/dL">Nanograms per decilitre (ng/dL)</option>
            <option value="ng/L">Nanograms per litre (ng/L)</option>
            <option value="ng/mL">Nanograms per millilitre (ng/mL)</option>
            <option value="ng/mL/hr">Nanograms per millilitre per hour (ng/mL/hr)</option>
            <option value="nmol">Nanomoles (nmol)</option>
            <option value="nmol/L">Nanomoles per litre (nmol/L)</option>
            <option value="pg">Picograms (pg)</option>
            <option value="pg/mL">Picograms per millilitre (pg/mL)</option>
            <option value="pmol/L">Picomoles per litre (pmol/L)</option>
            <option value="Titres">Titres</option>
            <option value="U/L">Units per litre (U/L)</option>
            <option value="U/mL">Units per millilitre (U/mL)</option>
        </select>
      </div>
    </div>`;
}


function addCategoryHTML(testIdx, catIdx) {
  const unitNameBase = `unit_${testIdx}_${catIdx}`;
  return `
  <div class="category-block mt-4">
    <div class="mb-3">
      <label class="form-label">Category Name</label>
      <input type="text" name="tests[${testIdx}][categories][${catIdx}][name]" class="form-control" />
    </div>

    <div class="mb-3">
      <label class="form-label">Result Type</label>
      <div>
        <div class="form-check">
          <label class="form-check-label">
              <input class="form-check-input" type="radio" name="tests[${testIdx}][categories][${catIdx}][value_type]" value="range" checked>
              Range
          </label>
        </div>
        <div class="form-check">
          <label class="form-check-label">
              <input class="form-check-input" type="radio" name="tests[${testIdx}][categories][${catIdx}][value_type]" value="text">
              Text
          </label>
        </div>
        <div class="form-check">
          <label class="form-check-label">
              <input class="form-check-input" type="radio" name="tests[${testIdx}][categories][${catIdx}][value_type]" value="negpos">
              Negative / Positive
          </label>
        </div>
      </div>
      <div class="value-type-extra mt-3">
        ${getUnitToggleAndDropdown(`tests[${testIdx}][categories][${catIdx}][unit]`, unitNameBase)}
      </div>
    </div>

    <div class="mb-3">
      <label class="form-label">Reference Range</label>
      <div>
        <div class="form-check">
          <label class="form-check-label">
              <input class="form-check-input" type="radio" name="tests[${testIdx}][categories][${catIdx}][reference_type]" value="none" checked>
              None
          </label>
        </div>
        <div class="form-check">
          <label class="form-check-label">
              <input class="form-check-input" type="radio" name="tests[${testIdx}][categories][${catIdx}][reference_type]" value="minmax">
              Min - Max
          </label>
        </div>
        <div class="form-check">
          <label class="form-check-label">
              <input class="form-check-input" type="radio" name="tests[${testIdx}][categories][${catIdx}][reference_type]" value="table">
              Ranges Table
          </label>
        </div>
      </div>
      <div class="reference-extra mt-3"></div>
    </div>

    <button type="button" class="btn btn-danger remove-category">Remove Category</button>
  </div>`;
}

let elementOrderCounter = 0;
document.addEventListener('click', function (e) {
    // At the beginning of your script

// For categories
if (e.target.classList.contains('add-category')) {
    const testBlock = e.target.closest('.test-block');
    const categoriesContainer = testBlock.querySelector('.categories-container');
    const testIdx = Array.from(document.querySelectorAll('.test-block')).indexOf(testBlock);
    const catIdx = categoriesContainer.querySelectorAll('.category-block').length;

    // Add order tracking hidden field
    elementOrderCounter++;
    const categoryHTML = addCategoryHTML(testIdx, catIdx);
    const wrapper = document.createElement('div');
    wrapper.innerHTML = categoryHTML;
    const categoryBlock = wrapper.firstElementChild;
    categoryBlock.insertAdjacentHTML('beforeend', `<input type="hidden" name="tests[${testIdx}][element_order][category_${catIdx}]" value="${elementOrderCounter}">`);

    categoriesContainer.appendChild(categoryBlock);
}

  if (e.target.classList.contains('remove-category')) {
    e.target.closest('.category-block').remove();
  }

  if (e.target.classList.contains('remove-test')) {
    e.target.closest('.test-block').remove();
  }

  if (e.target.classList.contains('remove-block')) {
      e.target.closest('.space-block, .title-block, .paragraph-block').remove();
  }

  // Handle unit toggle checkboxes
  if (e.target.classList.contains('enable-unit')) {
    const unitDropdown = e.target.closest('.mb-3').querySelector('.unit-dropdown');
    if (e.target.checked) {
      unitDropdown.style.display = 'block';
    } else {
      unitDropdown.style.display = 'none';
    }
  }

  const testBlock = e.target.closest('.test-block');
  if (!testBlock) return;
  const categoriesContainer = testBlock.querySelector('.categories-container');
  const testIdx = Array.from(document.querySelectorAll('.test-block')).indexOf(testBlock);

// For spaces
if (e.target.classList.contains('add-space')) {
    elementOrderCounter++;
    categoriesContainer.insertAdjacentHTML('beforeend', `
    <div class="space-block my-4">
        <input type="hidden" name="tests[${testIdx}][custom_space][]" value="1">
        <input type="hidden" name="tests[${testIdx}][element_order][space_${categoriesContainer.querySelectorAll('.space-block').length}]" value="${elementOrderCounter}">
        <hr />
        <button type="button" class="btn btn-sm btn-danger mt-1 remove-block">Remove Space</button>
    </div>
    `);
}

// Similarly for titles
if (e.target.classList.contains('add-title')) {
    elementOrderCounter++;
    categoriesContainer.insertAdjacentHTML('beforeend', `
    <div class="title-block mb-3">
        <label class="form-label">Custom Title</label>
        <input type="text" name="tests[${testIdx}][custom_title][]" class="form-control" />
        <input type="hidden" name="tests[${testIdx}][element_order][title_${categoriesContainer.querySelectorAll('.title-block').length}]" value="${elementOrderCounter}">
        <button type="button" class="btn btn-sm btn-danger mt-1 remove-block">Remove Title</button>
    </div>
    `);
}

// And for paragraphs
if (e.target.classList.contains('add-paragraph')) {
    elementOrderCounter++;
    categoriesContainer.insertAdjacentHTML('beforeend', `
    <div class="paragraph-block mb-3">
        <label class="form-label">Custom Paragraph</label>
        <textarea name="tests[${testIdx}][custom_paragraph][]" class="form-control" rows="3"></textarea>
        <input type="hidden" name="tests[${testIdx}][element_order][paragraph_${categoriesContainer.querySelectorAll('.paragraph-block').length}]" value="${elementOrderCounter}">
        <button type="button" class="btn btn-sm btn-danger mt-1 remove-block">Remove Paragraph</button>
    </div>
    `);
}

  if (e.target.classList.contains('generate-table')) {
    const block = e.target.closest('.category-block');
    const rows = parseInt(block.querySelector('.table-rows').value);
    const cols = parseInt(block.querySelector('.table-cols').value);
    const tableArea = block.querySelector('.table-area');
    const testIdx = Array.from(document.querySelectorAll('.test-block')).indexOf(block.closest('.test-block'));
    const catIdx = Array.from(block.closest('.categories-container').querySelectorAll('.category-block')).indexOf(block);

    const oldInputs = tableArea.querySelectorAll('input');
    const existingValues = {};
    oldInputs.forEach(input => {
      const match = input.name.match(/tests\[\d+\]\[categories\]\[\d+\]\[table\]\[(\d+)\]\[(\d+)\]/);
      if (match) {
        const row = parseInt(match[1]);
        const col = parseInt(match[2]);
        if (!existingValues[row]) existingValues[row] = {};
        existingValues[row][col] = input.value;
      }
    });

    let tableHTML = '<table class="table table-bordered">';
    for (let r = 0; r < rows; r++) {
      tableHTML += '<tr>';
      for (let c = 0; c < cols; c++) {
        const val = (existingValues[r] && existingValues[r][c]) ? existingValues[r][c] : '';
        tableHTML += `<td><input type="text" name="tests[${testIdx}][categories][${catIdx}][table][${r}][${c}]" class="form-control" value="${val}" /></td>`;
      }
      tableHTML += '</tr>';
    }
    tableHTML += '</table>';
    tableArea.innerHTML = tableHTML;
  }
});

document.addEventListener('change', function (e) {
  if (e.target.name.includes('value_type')) {
    const block = e.target.closest('.category-block');
    const extraDiv = block.querySelector('.value-type-extra');
    const testIdx = Array.from(document.querySelectorAll('.test-block')).indexOf(block.closest('.test-block'));
    const catIdx = Array.from(block.closest('.categories-container').querySelectorAll('.category-block')).indexOf(block);
    const unitNameBase = `unit_${testIdx}_${catIdx}`;

    if (e.target.value === 'range' || e.target.value === 'text') {
      extraDiv.innerHTML = getUnitToggleAndDropdown(`tests[${testIdx}][categories][${catIdx}][unit]`, unitNameBase);
    } else {
      extraDiv.innerHTML = '';
    }
  }

  if (e.target.name.includes('reference_type')) {
    const block = e.target.closest('.category-block');
    const extraDiv = block.querySelector('.reference-extra');
    const testIdx = Array.from(document.querySelectorAll('.test-block')).indexOf(block.closest('.test-block'));
    const catIdx = Array.from(block.closest('.categories-container').querySelectorAll('.category-block')).indexOf(block);

    if (e.target.value === 'minmax') {
      extraDiv.innerHTML = `
        <div class="mb-3">
          <label class="form-label">Min Value</label>
          <input type="text" name="tests[${testIdx}][categories][${catIdx}][min_value]" class="form-control" />
        </div>
        <div class="mb-3">
          <label class="form-label">Max Value</label>
          <input type="text" name="tests[${testIdx}][categories][${catIdx}][max_value]" class="form-control" />
        </div>`;
      // Note: Unit selection is removed for reference range
    } else if (e.target.value === 'table') {
      extraDiv.innerHTML = `
        <div class="row g-2 align-items-end">
          <div class="col-auto">
            <label class="form-label">Rows</label>
            <input type="number" class="form-control table-rows" value="2" min="1" />
          </div>
          <div class="col-auto">
            <label class="form-label">Columns</label>
            <input type="number" class="form-control table-cols" value="2" min="1" />
          </div>
          <div class="col-auto">
            <button type="button" class="btn btn-outline-secondary generate-table">Generate Table</button>
          </div>
        </div>
        <div class="table-area mt-3"></div>`;
    } else {
      extraDiv.innerHTML = '';
    }
  }
});

// Optional: Add functionality to add multiple tests
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('tests-container');
    const addTestBtn = document.createElement('button');
    addTestBtn.type = 'button';
    addTestBtn.className = 'btn btn-info mb-4';
    addTestBtn.innerHTML = '<i class="fas fa-plus-circle me-1"></i> Add Another Test';

    addTestBtn.addEventListener('click', function() {
        testIndex++;
        const newTest = document.createElement('div');
        newTest.className = 'test-block';
        newTest.innerHTML = `
            <div class="row mb-3">
            <div class="mb-3 col-lg-8">
              <label class="form-label">Test Name</label>
              <input type="text" name="tests[${testIndex}][name]" class="form-control test-name" />
            </div>
            <div class="col col-lg-4">
                <label class="form-label">Specimen</label>
                <select name="tests[${testIndex}][specimen]" class="form-control select2">
                    <option value="">--Select Specimen Type--</option>
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
            </div>
            <div class="row mb-3">
              <div class="col col-lg-4">
                <label class="form-label">Price</label>
                <input type="number" name="tests[${testIndex}][price]" class="form-control" step="10.00" />
              </div>
            </div>
            <div class="categories-container"></div>
            <div class="button-group mt-2">
                <button type="button" class="btn btn-primary add-category mb-1">
                    <i class="fas fa-folder-plus me-1"></i> Add Category
                </button>
                <button type="button" class="btn btn-secondary add-space mb-1">
                    <i class="fas fa-arrows-alt-v me-1"></i> Add Space
                </button>
                <button type="button" class="btn btn-secondary add-title mb-1">
                    <i class="fas fa-heading me-1"></i> Add Title
                </button>
                <button type="button" class="btn btn-secondary add-paragraph mb-1">
                    <i class="fas fa-align-left me-1"></i> Add Paragraph
                </button>
            </div>
            <button type="button" class="btn btn-danger mt-3 remove-test">
                <i class="fas fa-trash me-1"></i> Remove This Test
            </button>
        `;
        container.appendChild(newTest);
    });

    container.parentNode.insertBefore(addTestBtn, container.nextSibling);
});





// AJAX Form Submission
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        // Show loading indicator
        const saveButton = document.getElementById('save-tests');
        const originalButtonText = saveButton.innerHTML;
        saveButton.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Saving...';
        saveButton.disabled = true;

        // Reset previous validation errors
        document.querySelectorAll('.is-invalid').forEach(el => {
            el.classList.remove('is-invalid');
        });
        document.querySelectorAll('.invalid-feedback').forEach(el => {
            el.remove();
        });

        // Create FormData object
        const formData = new FormData(this);

        // Send AJAX request
        $.ajax({
            url: form.action,
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            success: function(response) {
                // Reset button
                saveButton.innerHTML = originalButtonText;
                saveButton.disabled = false;

                // Show success toast
                toastr.success(response.message, 'Success');

                // Optional: Reset form or redirect
                form.reset();
                // window.location.href = response.redirect;
            },
            error: function(xhr) {
                // Reset button
                saveButton.innerHTML = originalButtonText;
                saveButton.disabled = false;

                if (xhr.status === 422) {
                    // Validation errors
                    let errors = xhr.responseJSON.errors;

                    // Display validation errors next to fields
                    Object.keys(errors).forEach(function(key) {
                        // Handle nested form fields (for test names)
                        const field = key;
                        let inputField;

                        // Check if this is a test name error
                        if (key.match(/tests\.\d+\.name/)) {
                            const testIndex = key.match(/tests\.(\d+)\.name/)[1];
                            inputField = document.querySelector(`input[name="tests[${testIndex}][name]"]`);
                        } else {
                            inputField = document.querySelector(`[name="${key}"]`);
                        }

                        if (inputField) {
                            inputField.classList.add('is-invalid');

                            // Add error message under the field
                            const feedbackDiv = document.createElement('div');
                            feedbackDiv.className = 'invalid-feedback';
                            feedbackDiv.textContent = errors[key][0];
                            inputField.parentNode.appendChild(feedbackDiv);

                            // Show toast for each error
                            toastr.error(errors[key][0], 'Validation Error');
                        } else {
                            // Generic toast for errors that don't map to a field
                            toastr.error(errors[key][0], 'Validation Error');
                        }
                    });
                } else {
                    // General error
                    toastr.error(xhr.responseJSON?.message || 'An error occurred while saving the test. Please try again.', 'Error');
                }
            }
        });
    });
});

// Configure toastr options
toastr.options = {
    "closeButton": true,
    "progressBar": true,
    "positionClass": "toast-top-right",
    "timeOut": "8000"
};
    </script>




<script>
    $(document).ready(function() {


        $('#add-input').click(function() {
            // Clone the last set of input fields and append it to the container
            var clonedInput = $('#input-container .row:last').clone();

            // Clear the values in the cloned input fields
            clonedInput.find('input').val('');

            // Append the cloned input to the container
            $('#input-container').append(`
                <div class="row">
                    <div class="col-lg-4 col-12">
                        <div class="form-group">
                            <label>Sub-Category Name</label>
                            <input type="text" name="SubCategoryName[]" class="form-control"  placeholder="Enter Name" required>
                        </div>
                    </div>

                    <div class="col-lg-2 col-12">
                        <div class="form-group">
                            <label>Minimum Value</label>
                            <input type="number" step="any" id="normal_range" name="SubCategoryRangeMin[]" class="form-control" placeholder="e.g. 1.5" required>
                        </div>
                    </div>
                    <div class="col-lg-2 col-12">
                        <div class="form-group">
                            <label>Maximum Value</label>
                            <input type="number" step="any" id="normal_range" name="SubCategoryRangeMax[]" class="form-control" placeholder="e.g. 50" required>
                        </div>
                    </div>

                    <div class="col-lg-4 col-12">
                    <div class="form-group">
                        <label>Units</label>
                        <select name="Units[]" class="form-control select2">
          <option value="">--Select Unit--</option>
            <option value="%">%</option>
            <option value="Femtolitres">Femtolitres</option>
            <option value="Grams">Grams</option>
            <option value="Grams per decilitre">Grams per decilitre (g/dL)</option>
            <option value="Grams per litre">Grams per litre (g/L)</option>
            <option value="International units per litre">International units per litre (IU/L)</option>
            <option value="International units per millilitre">International units per millilitre (IU/mL)</option>
            <option value="Micrograms">Micrograms (mcg)</option>
            <option value="Micrograms per decilitre">Micrograms per decilitre (mcg/dL)</option>
            <option value="Micrograms per litre">Micrograms per litre (mcg/L)</option>
            <option value="Microkatals per litre">Microkatals per litre (mckat/L)</option>
            <option value="Microlitres">Microlitres (mcL)</option>
            <option value="Micromoles per litre">Micromoles per litre (mcmol/L)</option>
            <option value="Milliequivalents">Milliequivalents (mEq)</option>
            <option value="Milliequivalents per litre">Milliequivalents per litre (mEq/L)</option>
            <option value="Milligrams">Milligrams (mg)</option>
            <option value="Milligrams per decilitre">Milligrams per decilitre (mg/dL)</option>
            <option value="Milligrams per litre">Milligrams per litre (mg/L)</option>
            <option value="Milli-international units per litre">Milli-international units per litre (mIU/L)</option>
            <option value="Millilitres">Millilitres (mL)</option>
            <option value="Millimetres">Millimetres (mm)</option>
            <option value="Millimetres of mercury">Millimetres of mercury (mm Hg)</option>
            <option value="Millimoles">Millimoles (mmol)</option>
            <option value="Millimoles per litre">Millimoles per litre (mmol/L)</option>
            <option value="Milliosmoles per kilogram of water">Milliosmoles per kilogram of water (mOsm/kg water)</option>
            <option value="Milliunits per gram">Milliunits per gram (mU/g)</option>
            <option value="Milliunits per litre">Milliunits per litre (mU/L)</option>
            <option value="Nanograms per decilitre">Nanograms per decilitre (ng/dL)</option>
            <option value="Nanograms per litre">Nanograms per litre (ng/L)</option>
            <option value="Nanograms per millilitre">Nanograms per millilitre (ng/mL)</option>
            <option value="Nanograms per millilitre per hour">Nanograms per millilitre per hour (ng/mL/hr)</option>
            <option value="Nanomoles">Nanomoles (nmol)</option>
            <option value="Nanomoles per litre">Nanomoles per litre (nmol/L)</option>
            <option value="Picograms">Picograms (pg)</option>
            <option value="Picograms per millilitre">Picograms per millilitre (pg/mL)</option>
            <option value="Picomoles per litre">Picomoles per litre (pmol/L)</option>
            <option value="Titres">Titres</option>
            <option value="Units per litre">Units per litre (U/L)</option>
            <option value="Units per millilitre">Units per millilitre (U/mL)</option>

                        </select>
                    </div>
                </div>

                    <div class="col-lg-2 col-12">
                    <div class="form-group">
                        <label>&nbsp;</label>
                        <button type="button" class="btn btn-danger remove-input">Remove</button>
                    </div>
                </div>
                </div>
            `);
        // Initialize InputMask for the new "Normal Range" input
        // $('.normal-range-input').inputmask('999-999', {
            // placeholder: '0', // Space as a placeholder for each digit
        // });

        });

            // Remove input button click event
        $('#input-container').on('click', '.remove-input', function() {
            // Remove the parent row of the clicked button
            $(this).closest('.row').remove();
        });
    });


</script>
@endpush
