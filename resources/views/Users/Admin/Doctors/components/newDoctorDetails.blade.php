@include('Users.Admin.messages.addMsg')

<div class="col-lg-6">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Doctor's Details</h3>
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
                <div class="col-lg-6 col-12">
                    

                    <!-- phone mask -->
                    <div class="form-group">
                        <label>Mobile</label>

                        <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-phone"></i>
                        </div>
                        <input type="text" class="form-control" name="mobile" data-inputmask='"mask": "(999) 999-9999"' data-mask>
                        </div>
                        <!-- /.input group -->
                    </div>
                    <!-- /.form group -->

                </div>
            </div>



            <div class="row">

                <div class="col-lg-6 col-12">
                    <div class="form-group">
                        <label>Clinic Name</label>
                        <input type="name" name="clinicName" class="form-control" placeholder="Clinic Name">
                    </div>
                </div>

                <div class="col-lg-6 col-12">
                    <div class="form-group">
                        <label>Clinic Address</label>
                        <textarea class="form-control" rows="3" name="clinicAddress" placeholder="Clinic Address.."></textarea>
                 
                    </div>
                </div>
            </div>


            
            

            {{-- Role value --}}
            <input name="role" type="hidden" value="2">
            <!-- /.box-body -->
    
            
        </div>
    </div>
    <!-- /.box -->
</div>




















@push('specificJs')


@endpush