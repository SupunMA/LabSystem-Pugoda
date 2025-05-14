{{-- Start of Second Card --}}
<div class="col-lg-8 col-12">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Change Password</h3>
        </div>
        <!-- /.card-header -->

        <!-- Form Start -->
        <div class="card-body">

                <!-- New Password and Confirm Password Row -->
                <div class="row">
                    <!-- New Password -->
                    <div class="col-lg-6 col-12">
                        <div class="form-group">
                            <label for="new-password">New Password</label>
                            <input id="new-password" type="password" class="form-control @error('new_password') is-invalid @enderror" name="new_password" placeholder="Enter new password" autocomplete="new-password">
                            @error('new_password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Confirm New Password -->
                    <div class="col-lg-6 col-12">
                        <div class="form-group">
                            <label for="new-password-confirm">Confirm New Password</label>
                            <input id="new-password-confirm" type="password" class="form-control" name="new_password_confirmation" placeholder="Confirm new password" autocomplete="new-password">
                        </div>
                    </div>
                </div>
                <!-- /.row -->

                <small class="form-text text-muted">Minimum password length is 8 characters.</small>

                <!-- Current Password Row -->
                <div class="row mt-4">
                    <!-- Current Password -->
                    <div class="col-lg-6 col-12">
                        <div class="form-group">
                            <label for="current-password">Current Password</label>
                            <input id="current-password" type="password" class="form-control @error('current_password') is-invalid @enderror" name="current_password" placeholder="Enter current password" required autocomplete="current-password">
                            @error('current_password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="col-lg-6 col-12 d-flex align-items-end">
                        <div class="form-group w-100">
                            <button type="submit" class="btn btn-success btn-lg w-100">
                                <i class="fas fa-save"></i> Save Changes
                            </button>
                        </div>
                    </div>
                </div>
                <!-- /.row -->

        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>
{{-- End of Second Card --}}
