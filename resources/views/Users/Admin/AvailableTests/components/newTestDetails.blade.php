<div class="container col-lg-12 col-sm-12">
    <form action="{{ route('admin.storeNewTest') }}" method="POST">
        <div id="tests-container">
            {{-- Initial Test Block --}}
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
                {{-- Container for dynamically added categories and other elements --}}
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
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
<style>
    .test-block,
    .category-block {
        border: 2px solid #dee2e6;
        padding: 20px;
        margin-bottom: 20px;
        border-radius: 10px;
    }

    .category-block {
        background-color: #f8f9fa;
    }

    table input {
        width: 100%;
    }
</style>
@endpush

@push('specificJs')
{{-- jQuery (needed for Select2 and AJAX) --}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
{{-- select 2 --}}
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
{{-- Toastr for notifications --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


<script>
    // Modified JavaScript for Medical Test Form

    let testIndex = 0; // Tracks current test block index for naming
    let elementOrderCounter = 0; // Tracks global order of all elements (categories, spaces, titles, paragraphs)

    // Helper function to get the Unit Toggle and Dropdown HTML
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
                    <option value="/HPF">per High Power Field</option>
                    <option value="x 10³/uL">x 10³/uL</option>
                    <option value="x 10⁶/uL">x 10⁶/uL</option>
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
                    <option value="mcL">Microlitres (mcL)</option>
                    <option value="mcmol/L">Micromoles per litre (mcmol/L)</option>
                    <option value="mEq">Milliequivalents (mEq)</option>
                    <option value="mEq/L">Milliequivalents per litre (mEq/L)</option>
                    <option value="mg">Milligrams (mg)</option>
                    <option value="mg/dL">Milligrams per decilitre (mg/dL)</option>
                    <option value="mg/L">Milligrams per litre (mg/L)</option>
                    <option value="mIU/L">Milli-international units per litre (mIU/L)</option>
                    <option value="million/mL">Millions per milliliter (million/mL)</option>
                    <option value="min">Minutes (min)</option>
                    <option value="mIU/mL">Milli-International Units per milliliter (mIU/mL)</option>
                    <option value="uIU/mL">Micro-International Units per milliliter (uIU/mL)</option>
                    <option value="mL">Millilitres (mL)</option>
                    <option value="mm">Millimetres (mm)</option>
                    <option value="mmHg">Millimetres of mercury (mm Hg)</option>
                    <option value="mmol">Millimoles (mmol)</option>
                    <option value="mmol/L">Millimoles per litre (mmol/L)</option>
                    <option value="mOsm/kg">Milliosmoles per kilogram of water (mOsm/kg water)</option>
                    <option value="mU/g">Milliunits per gram (mU/g)</option>
                    <option value="mU/L">Milliunits per litre (mU/L)</option>
                    <option value="mU/L">Millimeters per hour (mm/hr)</option>
                    <option value="ng/dL">Nanograms per decilitre (ng/dL)</option>
                    <option value="ng/L">Nanograms per litre (ng/L)</option>
                    <option value="ng/mL">Nanograms per millilitre (ng/mL)</option>
                    <option value="ng/mL/hr">Nanograms per millilitre per hour (ng/mL/hr)</option>
                    <option value="nmol">Nanomoles (nmol)</option>
                    <option value="nmol/L">Nanomoles per litre (nmol/L)</option>
                    <option value="pg">Picograms (pg)</option>
                    <option value="pg/mL">Picograms per millilitre (pg/mL)</option>
                    <option value="pmol/L">Picomoles per litre (pmol/L)</option>
                    <option value="s">Seconds (s)</option>
                    <option value="Titres">Titres</option>
                    <option value="U/L">Units per litre (U/L)</option>
                    <option value="U/mL">Units per millilitre (U/mL)</option>
                </select>
              </div>
            </div>`;
    }

    // Helper function to get the Category HTML block
    function addCategoryHTML(testIdx, catIdx) {
        const unitNameBase = `unit_${testIdx}_${catIdx}`;
        return `
            <div class="category-block mt-4" data-test-idx="${testIdx}" data-cat-idx="${catIdx}">
                <div class="mb-3">
                    <label class="form-label">Category Name</label>
                    <input type="text" name="tests[${testIdx}][categories][${catIdx}][name]" class="form-control" />
                </div>

                <div class="mb-3">
                    <label class="form-label">Result Type</label>
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-2"> <div class="col">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" name="tests[${testIdx}][categories][${catIdx}][value_type]" value="number" checked>
                                    Number Input
                                </label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" name="tests[${testIdx}][categories][${catIdx}][value_type]" value="text">
                                    Text Input
                                </label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" name="tests[${testIdx}][categories][${catIdx}][value_type]" value="negpos">
                                    Negative / Positive
                                </label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" name="tests[${testIdx}][categories][${catIdx}][value_type]" value="negpos_with_Value">
                                    Negative / Positive with Value (e.g., &lt;6)
                                </label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" name="tests[${testIdx}][categories][${catIdx}][value_type]" value="getFromMindray">
                                    Extract from File (Mindray)
                                </label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" name="tests[${testIdx}][categories][${catIdx}][value_type]" value="dropdown">
                                    Dropdown List
                                </label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" name="tests[${testIdx}][categories][${catIdx}][value_type]" value="formula">
                                    Formula (Calculated)
                                </label>
                            </div>
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

    document.addEventListener('click', function(e) {
        // Add Category button
        if (e.target.classList.contains('add-category')) {
            const testBlock = e.target.closest('.test-block');
            const categoriesContainer = testBlock.querySelector('.categories-container');
            const testIdx = parseInt(testBlock.dataset.testIdx || 0); // Use data-test-idx
            const catIdx = categoriesContainer.querySelectorAll('.category-block').length;

            elementOrderCounter++;
            const categoryHTML = addCategoryHTML(testIdx, catIdx);
            const wrapper = document.createElement('div');
            wrapper.innerHTML = categoryHTML;
            const categoryBlock = wrapper.firstElementChild;
            // Add order tracking hidden field
            categoryBlock.insertAdjacentHTML('beforeend', `<input type="hidden" name="tests[${testIdx}][element_order][category_${catIdx}]" value="${elementOrderCounter}">`);

            categoriesContainer.appendChild(categoryBlock);
            // Initialize Select2 for the newly added category's unit dropdown
            $(categoryBlock).find('.select2').select2();
        }

        // Remove Category button
        if (e.target.classList.contains('remove-category')) {
            e.target.closest('.category-block').remove();
        }

        // Remove Test button
        if (e.target.classList.contains('remove-test')) {
            e.target.closest('.test-block').remove();
        }

        // Remove custom block (Space, Title, Paragraph)
        if (e.target.classList.contains('remove-block')) {
            e.target.closest('.space-block, .title-block, .paragraph-block').remove();
        }

        // Handle unit toggle checkboxes
        if (e.target.classList.contains('enable-unit')) {
            const unitDropdown = e.target.closest('.mb-3').querySelector('.unit-dropdown');
            if (e.target.checked) {
                unitDropdown.style.display = 'block';
                $(unitDropdown).find('.select2').select2(); // Ensure Select2 is initialized if it becomes visible
            } else {
                unitDropdown.style.display = 'none';
                $(unitDropdown).find('.select2').select2('destroy'); // Destroy Select2 if hidden
            }
        }

        const testBlock = e.target.closest('.test-block');
        if (!testBlock) return; // Only proceed if click is within a test block
        const categoriesContainer = testBlock.querySelector('.categories-container');
        const testIdx = parseInt(testBlock.dataset.testIdx || 0);

        // Add Space button
        if (e.target.classList.contains('add-space')) {
            elementOrderCounter++;
            categoriesContainer.insertAdjacentHTML('beforeend', `
                <div class="space-block my-4">
                    <input type="hidden" name="tests[${testIdx}][custom_space][${categoriesContainer.querySelectorAll('.space-block').length}]" value="1">
                    <input type="hidden" name="tests[${testIdx}][element_order][space_${categoriesContainer.querySelectorAll('.space-block').length}]" value="${elementOrderCounter}">
                    <hr />
                    <button type="button" class="btn btn-sm btn-danger mt-1 remove-block">Remove Space</button>
                </div>
            `);
        }

        // Add Title button
        if (e.target.classList.contains('add-title')) {
            elementOrderCounter++;
            categoriesContainer.insertAdjacentHTML('beforeend', `
                <div class="title-block mb-3">
                    <label class="form-label">Custom Title</label>
                    <input type="text" name="tests[${testIdx}][custom_title][${categoriesContainer.querySelectorAll('.title-block').length}]" class="form-control" />
                    <input type="hidden" name="tests[${testIdx}][element_order][title_${categoriesContainer.querySelectorAll('.title-block').length}]" value="${elementOrderCounter}">
                    <button type="button" class="btn btn-sm btn-danger mt-1 remove-block">Remove Title</button>
                </div>
            `);
        }

        // Add Paragraph button
        if (e.target.classList.contains('add-paragraph')) {
            elementOrderCounter++;
            categoriesContainer.insertAdjacentHTML('beforeend', `
                <div class="paragraph-block mb-3">
                    <label class="form-label">Custom Paragraph</label>
                    <textarea name="tests[${testIdx}][custom_paragraph][${categoriesContainer.querySelectorAll('.paragraph-block').length}]" class="form-control" rows="3"></textarea>
                    <input type="hidden" name="tests[${testIdx}][element_order][paragraph_${categoriesContainer.querySelectorAll('.paragraph-block').length}]" value="${elementOrderCounter}">
                    <button type="button" class="btn btn-sm btn-danger mt-1 remove-block">Remove Paragraph</button>
                </div>
            `);
        }

        // Generate Table for Reference Ranges
        if (e.target.classList.contains('generate-table')) {
            const block = e.target.closest('.category-block');
            const rows = parseInt(block.querySelector('.table-rows').value);
            const cols = parseInt(block.querySelector('.table-cols').value);
            const tableArea = block.querySelector('.table-area');
            const testIdx = parseInt(block.dataset.testIdx);
            const catIdx = parseInt(block.dataset.catIdx);

            // Preserve existing values if regenerating table
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

    document.addEventListener('change', function(e) {
        // Handle Result Type radio button changes
        if (e.target.name.includes('value_type')) {
            const block = e.target.closest('.category-block');
            const extraDiv = block.querySelector('.value-type-extra');
            const testIdx = parseInt(block.dataset.testIdx);
            const catIdx = parseInt(block.dataset.catIdx);
            const unitNameBase = `unit_${testIdx}_${catIdx}`;

            extraDiv.innerHTML = ''; // Clear existing content

            switch (e.target.value) {
                case 'number':
                case 'text':
                    extraDiv.innerHTML = getUnitToggleAndDropdown(`tests[${testIdx}][categories][${catIdx}][unit]`, unitNameBase);
                    $(extraDiv).find('.select2').select2(); // Re-initialize Select2
                    break;
                case 'negpos':
                    // No extra fields needed, unit is generally not applicable
                    break;
                case 'negpos_with_Value':
                    // No extra fields needed, unit is generally not applicable
                    break;
                case 'getFromMindray':
                    extraDiv.innerHTML = `
                        <div class="mb-3">
                            <label class="form-label">Select Mindray Field</label>
                            <select name="tests[${testIdx}][categories][${catIdx}][mindray_field_name]" class="form-control mindray-field-dropdown">
                                <option value="">-- Select a field --</option>
                                <option value="WBC">WBC</option>
                                <option value="LYM#">LYM#</option>
                                <option value="LYM%">LYM%</option>
                                <option value="RBC">RBC</option>
                                <option value="HGB">HGB</option>
                                <option value="MCV">MCV</option>
                                <option value="MCH">MCH</option>
                                <option value="MCHC">MCHC</option>
                                <option value="RDW-CV">RDW-CV</option>
                                <option value="RDW-SD">RDW-SD</option>
                                <option value="HCT">HCT</option>
                                <option value="PLT">PLT</option>
                                <option value="MPV">MPV</option>
                                <option value="PDW">PDW</option>
                                <option value="PCT">PCT</option>
                                <option value="MID#">MID#</option>
                                <option value="MID%">MID%</option>
                                <option value="GRAN#">GRAN#</option>
                                <option value="GRAN%">GRAN%</option>
                                <option value="PLCR">PLCR</option>
                            </select>
                        </div>
                    `;
                    extraDiv.innerHTML += getUnitToggleAndDropdown(`tests[${testIdx}][categories][${catIdx}][unit]`, unitNameBase);
                    // If you are using Select2 for this dropdown, uncomment the line below:
                    // $(extraDiv).find('.mindray-field-dropdown').select2();
                    break;
                case 'dropdown':
                    extraDiv.innerHTML = `
                        <div class="mb-3">
                            <label class="form-label">Dropdown Options (comma-separated values)</label>
                            <input type="text" name="tests[${testIdx}][categories][${catIdx}][dropdown_options]" class="form-control" placeholder="Option1, Option2, Option3" />
                        </div>
                    `;
                    break;
                case 'formula':
                    extraDiv.innerHTML = `
                        <div class="mb-3">
                            <label class="form-label">Formula Definition (Use {Category Name} for other categories)</label>
                            <textarea name="tests[${testIdx}][categories][${catIdx}][formula_definition]" class="form-control" rows="3" placeholder="e.g., {Category A} + {Category B} * 2"></textarea>
                        </div>
                    `;
                    extraDiv.innerHTML += getUnitToggleAndDropdown(`tests[${testIdx}][categories][${catIdx}][unit]`, unitNameBase);
                    $(extraDiv).find('.select2').select2(); // Re-initialize Select2
                    break;
            }
        }

        // Handle Reference Type radio button changes
        if (e.target.name.includes('reference_type')) {
            const block = e.target.closest('.category-block');
            const extraDiv = block.querySelector('.reference-extra');
            const testIdx = parseInt(block.dataset.testIdx);
            const catIdx = parseInt(block.dataset.catIdx);

            extraDiv.innerHTML = ''; // Clear existing content

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
                extraDiv.innerHTML = ''; // 'none' selected
            }
        }
    });

    // Optional: Add functionality to add multiple tests
    document.addEventListener('DOMContentLoaded', function() {
        const testsContainer = document.getElementById('tests-container');
        const addTestBtn = document.createElement('button');
        addTestBtn.type = 'button';
        addTestBtn.className = 'btn btn-info mb-4';
        addTestBtn.innerHTML = '<i class="fas fa-plus-circle me-1"></i> Add Another Test';

        // Initialize Select2 for the first test block's specimen dropdown
        $('#tests-container').find('.select2').select2();

        // Set initial test block data-test-idx
        testsContainer.querySelector('.test-block').dataset.testIdx = 0;


        addTestBtn.addEventListener('click', function() {
            testIndex++; // Increment for new test block
            elementOrderCounter++; // Increment for the test block itself in overall order (optional, but good for test-level ordering)

            const newTest = document.createElement('div');
            newTest.className = 'test-block';
            newTest.dataset.testIdx = testIndex; // Set data attribute for new test block
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
            testsContainer.appendChild(newTest);
            $(newTest).find('.select2').select2(); // Initialize Select2 for new test block
        });

        testsContainer.parentNode.insertBefore(addTestBtn, testsContainer.nextSibling);
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
                    // You might want to remove all dynamically added tests/categories here
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
                            let inputField;

                            // Handle nested form fields
                            // Example: tests.0.name -> input[name="tests[0][name]"]
                            // Example: tests.0.categories.0.name -> input[name="tests[0][categories][0][name]"]
                            // Example: tests.0.categories.0.min_value -> input[name="tests[0][categories][0][min_value]"]
                            const htmlName = key.replace(/\.(\d+)\./g, '[$1].').replace(/\.(.*?)(?=\.|$)/g, '[$1]');
                            inputField = document.querySelector(`[name="${htmlName}"]`);

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
                                // Generic toast for errors that don't map to a specific field (e.g., if a complex rule fails)
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
@endpush


@push('specificCSS')
<style>
    .result-type-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); /* Example: 200px minimum width, fills available space */
        gap: 15px; /* Spacing between grid items */
    }

    /* Optional: for a fixed number of columns */
    /* .result-type-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr); /* 3 equal columns */
        gap: 15px;
    } */

    /* Optional: For responsiveness with fixed columns (requires media queries) */
    /* @media (max-width: 768px) {
        .result-type-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    @media (max-width: 576px) {
        .result-type-grid {
            grid-template-columns: 1fr;
        }
    } */
</style>
@endpush
