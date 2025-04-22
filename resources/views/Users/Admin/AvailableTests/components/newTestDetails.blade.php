

<div class="col-lg-10 ">
    @include('Users.Admin.messages.addMsg')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Available Test's Details</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <div class="box-body">

<form action="{{ route('admin.addingAvailableTest') }}" method="post">
                @csrf
            <div class="row">
                <div class="col-lg-6 col-12">
                    <div class="form-group">
                        <label>Test Name</label>
                        <input type="text" name="AvailableTestName" class="form-control"  placeholder="Enter Name">
                    </div>
                </div>
            {{-- Gender --}}

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
                        <!-- /.box-header -->
                        <!-- form start -->
                        <div class="box-body" id="input-container">




                        </div>
                        <button type="button" id="add-input" class="btn btn-success  float-right">Add Sub-Category</button>
                    </div>
                    <!-- /.box -->
                </div>

            </div>

            <div class="box-footer">
                <div class="form-group pull-right">
                    <small class="form-text text-muted text-right">Please check details again.</small><br>
                    <button type="submit" class="btn btn-danger  float-right"><b>&nbsp; Save All&nbsp;</b>
                    </button>
                </div>
            </div>

 </form>
        </div>
    </div>
    <!-- /.box -->
</div>








<div class="container-fluid">
    <div id="tests-container">
      <div class="card test-block">
        <div class="card-body">
          <div class="form-group">
            <label>Test Name</label>
            <input type="text" name="tests[0][name]" class="form-control test-name" />
          </div>
          <div class="categories-container"></div>
          <div class="btn-group mt-3">
            <button type="button" class="btn btn-primary add-category"><i class="fas fa-plus"></i> Add Category</button>
            <button type="button" class="btn btn-outline-secondary add-space">Add Space</button>
            <button type="button" class="btn btn-outline-secondary add-title">Add Title</button>
            <button type="button" class="btn btn-outline-secondary add-paragraph">Add Paragraph</button>
          </div>
        </div>
      </div>
    </div>

    <button type="button" id="add-test" class="btn btn-dark mt-3"><i class="fas fa-plus-circle"></i> Add New Test</button>
  </div>




@push('specificCSS')


<style>
    .test-block, .category-block {
      margin-bottom: 1.5rem;
    }
    .category-block {
      background: #f4f6f9;
      padding: 20px;
      border-radius: 8px;
      border: 1px solid #dee2e6;
    }
    table input {
      width: 100%;
    }
  </style>
@endpush








@push('specificJs')


<script>
    let testIndex = 0;

    function getUnitDropdown(name) {
      return `
        <div class="form-group">
          <label>Unit</label>
          <select name="${name}" class="form-control">
            <option value="">--Select Unit--</option>
            <option value="mg/dL">mg/dL</option>
            <option value="mmol/L">mmol/L</option>
            <option value="g/L">g/L</option>
          </select>
        </div>`;
    }

    function addCategoryHTML(testIdx, catIdx) {
      return `
      <div class="category-block mt-4">
        <div class="form-group">
          <label>Category Name</label>
          <input type="text" name="tests[${testIdx}][categories][${catIdx}][name]" class="form-control" />
        </div>

        <div class="form-group">
          <label>Value Type</label>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="tests[${testIdx}][categories][${catIdx}][value_type]" value="range" checked>
            <label class="form-check-label">Range</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="tests[${testIdx}][categories][${catIdx}][value_type]" value="text">
            <label class="form-check-label">Text</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="tests[${testIdx}][categories][${catIdx}][value_type]" value="yesno">
            <label class="form-check-label">Yes / No</label>
          </div>
          <div class="value-type-extra mt-3">${getUnitDropdown(`tests[${testIdx}][categories][${catIdx}][unit]`)}</div>
        </div>

        <div class="form-group">
          <label>Reference Range</label>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="tests[${testIdx}][categories][${catIdx}][reference_type]" value="none" checked>
            <label class="form-check-label">None</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="tests[${testIdx}][categories][${catIdx}][reference_type]" value="minmax">
            <label class="form-check-label">Min - Max</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="tests[${testIdx}][categories][${catIdx}][reference_type]" value="table">
            <label class="form-check-label">Ranges Table</label>
          </div>
          <div class="reference-extra mt-3"></div>
        </div>

        <button type="button" class="btn btn-danger remove-category"><i class="fas fa-trash"></i> Remove Category</button>
      </div>`;
    }

    document.getElementById('add-test').addEventListener('click', function () {
      testIndex++;
      const testHTML = `
        <div class="card test-block">
          <div class="card-body">
            <div class="form-group">
              <label>Test Name</label>
              <input type="text" name="tests[${testIndex}][name]" class="form-control test-name" />
            </div>
            <div class="categories-container"></div>
            <div class="btn-group mt-3">
              <button type="button" class="btn btn-primary add-category"><i class="fas fa-plus"></i> Add Category</button>
              <button type="button" class="btn btn-outline-secondary add-space">Add Space</button>
              <button type="button" class="btn btn-outline-secondary add-title">Add Title</button>
              <button type="button" class="btn btn-outline-secondary add-paragraph">Add Paragraph</button>
            </div>
            <button type="button" class="btn btn-danger remove-test mt-3"><i class="fas fa-trash-alt"></i> Remove Test</button>
          </div>
        </div>`;
      document.getElementById('tests-container').insertAdjacentHTML('beforeend', testHTML);
    });

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

      const testBlock = e.target.closest('.test-block');
      if (!testBlock) return;
      const categoriesContainer = testBlock.querySelector('.categories-container');

      if (e.target.classList.contains('add-space')) {
        categoriesContainer.insertAdjacentHTML('beforeend', `<hr class="my-4">`);
      }

      if (e.target.classList.contains('add-title')) {
        categoriesContainer.insertAdjacentHTML('beforeend', `
          <div class="form-group">
            <label>Custom Title</label>
            <input type="text" name="custom_title[]" class="form-control" />
          </div>`);
      }

      if (e.target.classList.contains('add-paragraph')) {
        categoriesContainer.insertAdjacentHTML('beforeend', `
          <div class="form-group">
            <label>Custom Paragraph</label>
            <textarea name="custom_paragraph[]" class="form-control" rows="3"></textarea>
          </div>`);
      }

      if (e.target.classList.contains('generate-table')) {
        const block = e.target.closest('.category-block');
        const rows = parseInt(block.querySelector('.table-rows').value);
        const cols = parseInt(block.querySelector('.table-cols').value);
        const tableArea = block.querySelector('.table-area');

        const oldInputs = tableArea.querySelectorAll('input');
        const existingValues = {};
        oldInputs.forEach(input => {
          const match = input.name.match(/table\[(\d+)\]\[(\d+)\]/);
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
            tableHTML += `<td><input type="text" name="table[${r}][${c}]" class="form-control" value="${val}" /></td>`;
          }
          tableHTML += '</tr>';
        }
        tableArea.innerHTML = tableHTML;
      }
    });

    document.addEventListener('change', function (e) {
      if (e.target.name.includes('value_type')) {
        const block = e.target.closest('.category-block');
        const extraDiv = block.querySelector('.value-type-extra');
        if (e.target.value === 'range') {
          extraDiv.innerHTML = getUnitDropdown("unit[]");
        } else {
          extraDiv.innerHTML = '';
        }
      }

      if (e.target.name.includes('reference_type')) {
        const block = e.target.closest('.category-block');
        const extraDiv = block.querySelector('.reference-extra');
        if (e.target.value === 'minmax') {
          extraDiv.innerHTML = `
            <div class="form-group">
              <label>Min Value</label>
              <input type="text" name="min_value" class="form-control" />
            </div>
            <div class="form-group">
              <label>Max Value</label>
              <input type="text" name="max_value" class="form-control" />
            </div>
            ${getUnitDropdown("range_unit")}`;
        } else if (e.target.value === 'table') {
          extraDiv.innerHTML = `
            <div class="row">
              <div class="col-md-3">
                <label>Rows</label>
                <input type="number" class="form-control table-rows" value="2" min="1" />
              </div>
              <div class="col-md-3">
                <label>Columns</label>
                <input type="number" class="form-control table-cols" value="2" min="1" />
              </div>
              <div class="col-md-4 d-flex align-items-end">
                <button type="button" class="btn btn-outline-secondary generate-table">Generate Table</button>
              </div>
            </div>
            <div class="table-area mt-3"></div>`;
        } else {
          extraDiv.innerHTML = '';
        }
      }
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
