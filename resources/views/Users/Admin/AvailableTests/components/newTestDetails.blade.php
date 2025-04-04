

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




@push('specificJs')

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
