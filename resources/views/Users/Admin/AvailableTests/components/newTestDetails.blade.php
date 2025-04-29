{{--
<div class="col-lg-10 ">
    @include('Users.Admin.messages.addMsg')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Available Test's Details</h3>
        </div>
        <div class="box-body">
            <form action="{{ route('admin.addingAvailableTest') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-lg-6 col-12">
                        <div class="form-group">
                            <label>Test Name</label>
                            <input type="text" name="AvailableTestName" class="form-control" placeholder="Enter Name">
                        </div>
                    </div>
                    <div class="col-lg-3 col-12">
                        <div class="form-group">
                            <label>Days</label>
                            <input type="number" name="resultDays" class="form-control" placeholder="How Long Does It Take?">
                        </div>
                    </div>
                    <div class="col-lg-3 col-12">
                        <div class="form-group">
                            <label>Cost</label>
                            <input type="number" name="AvailableTestCost" class="form-control" placeholder="Cost for the test">
                        </div>
                    </div>
                    <div class="col-lg-11">
                        <div class="box box-success">
                            <div class="box-header with-border">
                                <h3 class="box-title">Sub Categories</h3>
                            </div>
                            <div class="box-body" id="input-container">
                            </div>
                            <button type="button" id="add-input" class="btn btn-success float-right">Add Sub-Category</button>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <div class="form-group pull-right">
                        <small class="form-text text-muted text-right">Please check details again.</small><br>
                        <button type="submit" class="btn btn-danger float-right"><b>&nbsp; Save All&nbsp;</b></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
--}}













    <div class="container col-lg-12 col-sm-12">
        <form action="{{ route('admin.storeNewTest') }}" method="POST">
            <div id="tests-container">
            <div class="test-block">

                @csrf
                <div class="mb-3 col-lg-8">
                <label class="form-label">Test Name</label>
                <input type="text" name="tests[0][name]" class="form-control test-name" />
                </div>
                <div class="row mb-3">
                <div class="col col-lg-4">
                    <label class="form-label">Cost</label>
                    <input type="number" name="tests[0][cost]" class="form-control" step="0.01" />
                </div>
                <div class="col col-lg-4">
                    <label class="form-label">Price</label>
                    <input type="number" name="tests[0][price]" class="form-control" step="0.01" />
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
        <select name="${name}" class="form-select form-control">
          <option value="">--Select Unit--</option>
          <option value="mg/dL">mg/dL</option>
          <option value="mmol/L">mmol/L</option>
          <option value="g/L">g/L</option>

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


document.addEventListener('click', function (e) {
  if (e.target.classList.contains('add-category')) {
    const testBlock = e.target.closest('.test-block');
    const categoriesContainer = testBlock.querySelector('.categories-container');
    const testIdx = Array.from(document.querySelectorAll('.test-block')).indexOf(testBlock);
    const catIdx = categoriesContainer.querySelectorAll('.category-block').length;
    categoriesContainer.insertAdjacentHTML('beforeend', addCategoryHTML(testIdx, catIdx));
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

  if (e.target.classList.contains('add-space')) {
      categoriesContainer.insertAdjacentHTML('beforeend', `
      <div class="space-block my-4">
          <input type="hidden" name="tests[${testIdx}][custom_space][]" value="1">
          <hr />
          <button type="button" class="btn btn-sm btn-danger mt-1 remove-block">Remove Space</button>
      </div>
      `);
  }

  if (e.target.classList.contains('add-title')) {
      categoriesContainer.insertAdjacentHTML('beforeend', `
      <div class="title-block mb-3">
          <label class="form-label">Custom Title</label>
          <input type="text" name="tests[${testIdx}][custom_title][]" class="form-control" />
          <button type="button" class="btn btn-sm btn-danger mt-1 remove-block">Remove Title</button>
      </div>
      `);
  }

  if (e.target.classList.contains('add-paragraph')) {
      categoriesContainer.insertAdjacentHTML('beforeend', `
      <div class="paragraph-block mb-3">
          <label class="form-label">Custom Paragraph</label>
          <textarea name="tests[${testIdx}][custom_paragraph][]" class="form-control" rows="3"></textarea>
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
            <div class="mb-3 col-lg-8">
              <label class="form-label">Test Name</label>
              <input type="text" name="tests[${testIndex}][name]" class="form-control test-name" />
            </div>
            <div class="row mb-3">
              <div class="col col-lg-4">
                <label class="form-label">Cost</label>
                <input type="number" name="tests[${testIndex}][cost]" class="form-control" step="0.01" />
              </div>
              <div class="col col-lg-4">
                <label class="form-label">Price</label>
                <input type="number" name="tests[${testIndex}][price]" class="form-control" step="0.01" />
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
                        <select name="Units[]" class="form-control">
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
