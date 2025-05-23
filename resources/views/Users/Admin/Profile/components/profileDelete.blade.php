 <!-- This form included into addClient Blade -->

 {{-- Start of Second Card --}}

 <div class="col-lg-8 col-md-12">
    <div class="box box-danger">
        <div class="box-header with-border">
            <h3 class="box-title">Delete The Account</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->

        <div class="box-body">

            <div class="row">

            </div>

            <div class="row">
                <div class="col-lg-6 col-12">
                    <div class="form-group">
                        <label>Click Below Button to Delete the Account!</label>

                    </div>
                </div>




            </div>


            <!-- /.card-body -->


            <div class="row">
                <div class="col-lg-6 col-12">
                    <div class="form-group">


                    {{-- Delete Button --}}
                    <a class="btn btn-danger" type="button" data-toggle="modal" data-target="#clientDeleteModal-{{$client->id}}"  >
                        <h6> <i class="far fa-trash-alt"></i> Delete My Account</h6>
                    </a>
                    <!-- /.card-body -->
                    {{-- add delete modal --}}
                    @include('Users.Admin.Profile.components.deleteProfile')
                </div>
            </div>

            </div>
        </div>

    </div>

</div>


{{-- End of Second Card --}}
