@include('Users.Admin.messages.addMsg')

<div class="col-lg-10">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Report's Details</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <div class="box-body">
<form action="{{ route('admin.addingReport') }}" method="post">
                @csrf
            <div class="row">

            {{-- Gender --}}
                <div class="col-lg-6 col-12">
                    <div class="form-group">
                        <label>Select Requested Test</label>

                        <select class="form-control select2" style="width: 100%;" name="tid" id="selectOption" onchange="updateUI(this)">
                            @php
                                $uniqueTids = [];
                            @endphp

                            @foreach ($allTestData as $Data)
                                @if (!in_array($Data->tid, $uniqueTids))
                                    <option value="{{$Data->tid}}">{{$Data->id}} - {{$Data->name}} - {{$Data->AvailableTestName}}</option>
                                    @php
                                        $uniqueTids[] = $Data->tid;
                                    @endphp
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-lg-4 col-12">
                    <div class="form-group" id="updateInfo">

                    </div>
                </div>


                    <!-- Display updated information here -->

                {{-- <div class="col-lg-6 col-12">
                    <div class="form-group">
                        <label>Select Status</label>

                        <select class="form-control select2" style="width: 100%;" name="status">

                            <option selected="selected" value="Normal">Normal</option>
                            <option value="Abnormal">Abnormal</option>

                        </select>
                    </div>
                </div> --}}
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

function updateUI(selectElement) {
    var selectedValue = selectElement.value;

    // Find all selected data in the allTestData array for the given tid
    var selectedDataArray = @json($allTestData->groupBy('tid')->map(function($items) { return $items->toArray(); })->toArray())[selectedValue];

    // Update the UI with the selected data
    if (selectedDataArray && selectedDataArray.length > 0) {
        var htmlContent = '';
// console.log(selectedDataArray);
        selectedDataArray.forEach(function(selectedData) {
            htmlContent += '<label>'+selectedData.SubCategoryName+' ('+selectedData.Units+')</label><input type="number" step="any"  name="result[]" class="form-control" placeholder="Enter Result" required>';
        });
        // selectedData.id + ' - ' + selectedData.name + ' - ' + selectedData.AvailableTestName + '<br>'
        document.getElementById('updateInfo').innerHTML = htmlContent;
    } else {
        // Handle the case where no data is found for the selectedValue
        document.getElementById('updateInfo').innerHTML = 'No data found for ' + selectedValue;
    }
}

// Execute code when the document is ready
$(document).ready(function () {
    // Initialize Select2 Elements
    $('.select2').select2();

    updateUI(document.getElementById('selectOption'));
});

    </script>

@endpush
