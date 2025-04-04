 <!-- This form included into addClient Blade -->
 
 {{-- Start of Second Card --}}

 <div class="col-lg-8 col-12">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="card-title">Change Password</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->

        <div class="box-body">

            <div class="row">
                <div class="col-lg-6 col-12">
                    <div class="form-group">
                        <label for="exampleInputPassword1">New Password</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="new_password" autocomplete="new-password">
                    </div>
                </div>

                <div class="col-lg-6 col-12">
                    <div class="form-group">
                        <label for="exampleInputPassword1">Confirm the New Password</label>
                        <input id="password-confirm" type="password" class="form-control" name="new_password_confirmation" autocomplete="new-password">
                    </div>
                </div>

            </div>
            <small class="form-text text-muted text-left">Minimum Password Length is 8 characters!</small>

            
        </div>
        <!-- /.card-body -->

        <div class="box-footer">
            <div class="row">
                <div class="col-lg-6 col-12">
                    <div class="form-group">
                        <label for="exampleInputPassword1">Current Password</label>
                        <input id="password-confirm" type="password" class="form-control" name="current_password" required autocomplete="new-password">
                    </div>
                </div>
                <div class="col-lg-6 col-12">
                    <div class="form-group pull-right">
                        <small class="form-text text-muted text-right">Please check details again.</small>
                        <br>
                        <button type="submit" class="btn btn-success btn-lg float-right"><b>&nbsp; Save All&nbsp;</b>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>


{{-- End of Second Card --}}