@include('Users.Admin.messages.addMsg')

<div class="col-lg-6">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">New Patient's Details</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <div class="box-body">

            <div class="row">
                <div class="col-lg-8 col-12">
                    <div class="form-group">
                        <label >Name</label>
                        <input type="name" name="name" class="form-control" id="name" placeholder="Enter Name">
                    </div>
                </div>
            {{-- Gender --}}

                <div class="col-lg-4 col-12">
                    <div class="form-group">
                        <label>Gender</label>

                        <select class="form-control" style="width: 100%;" name="gender">
                            <option selected="selected" value="M">Male</option>
                            <option value="F">Female</option>
                            <option value="O">Other</option>


                        </select>
                    </div>
                </div>
            </div>


            <div class="row">
                <!-- Date -->
                <div class="col-lg-6 col-12">
                    <!-- Date dd/mm/yyyy -->
                    <!-- Date -->
                    <div class="form-group">
                        <label>Date of Birth (M/D/Y)</label>

                        <div class="input-group date" id="reservationdate" data-target-input="nearest">
                            <input type="text" class="form-control datetimepicker-input" data-target="#reservationdate" name="dob">
                            <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>


                <!-- /.form group -->
                </div>



                {{-- Mobile --}}

                <div class="col-lg-6 col-12">


                    <!-- phone mask -->
                    <div class="form-group">
                        <label>Mobile</label>

                        <div class="input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="fas fa-phone"></i></span>
                            </div>
                            <input type="text" class="form-control" data-inputmask="&quot;mask&quot;: &quot;(999) 999-9999&quot;" data-mask="" inputmode="text" name="mobile">
                        </div>
                    </div>
                    <!-- /.form group -->

                </div>
            </div>



            <div class="row">
                <div class="col-lg-6 col-12">
                    <div class="form-group">
                        <label>Address</label>
                        <textarea class="form-control" rows="3" name="address" placeholder="Enter ..."></textarea>

                    </div>
                </div>
            </div>





            {{-- Role value --}}
            <input name="role" type="hidden" value="0">
            <!-- /.box-body -->


        </div>


    <!-- /.box -->
    </div>

</div>




@push('specificJs')

  <script>
    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    })
  </script>

@endpush
