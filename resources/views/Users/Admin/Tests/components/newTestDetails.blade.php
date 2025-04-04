@include('Users.Admin.messages.addMsg')

<div class="col-lg-8">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Test's Details</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <div class="box-body">
<form action="{{ route('admin.addingTest') }}" method="post">
                @csrf
            <div class="row">

                <div class="col-lg-6 col-12">
                    <div class="form-group">
                        <label>Select The Patient</label>

                        <select class="form-control select2" style="width: 100%;" name="pid">
                            {{-- <option selected="selected">Alabama</option> --}}
                            @foreach ($patients as $patient)
                                <option value="{{$patient->pid}}">{{$patient->user->name}} - {{$patient->dob}}</option>
                            @endforeach

                        </select>
                    </div>


                </div>


                <div class="col-lg-6 col-12">
                    <div class="form-group">
                        <label>Select The Test</label>

                        <select class="form-control select2" style="width: 100%;" name="tlid">
                            {{-- <option selected="selected">Alabama</option> --}}
                            @foreach ($availableTests as $availableTest)
                                <option value="{{$availableTest->tlid}}">{{$availableTest->AvailableTestName}} - Rs.{{$availableTest->AvailableTestCost}}</option>
                            @endforeach

                        </select>
                    </div>
                </div>

            </div>


            <div class = "row">
                <!-- Date -->
                <div class="col-lg-6 col-12">
                    <!-- Date dd/mm/yyyy -->
                    <!-- Date -->

                    <div class="form-group">
                        <label>Date (M/D/Y)</label>

                        <div class="input-group date" id="reservationdate" data-target-input="nearest">
                            <input type="text" class="form-control datetimepicker-input" data-target="#reservationdate" name="date">
                            <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>



                <!-- /.form group -->
                </div>

                <div class="col-lg-6 col-12">
                    <div class="form-group">
                        <label>Name of the Doctor</label>

                        <input type="text" name="doctorName" class="form-control" placeholder="Name of the Doctor">
                    </div>
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
    $('.select2').select2({
        theme: 'bootstrap4' // Ensures it matches AdminLTE 3 styling
    });
});

</script>


<script>
    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    })
  </script>
@endpush
