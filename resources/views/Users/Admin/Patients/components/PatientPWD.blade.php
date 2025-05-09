<div class="col-lg-6">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Login Information</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <!-- /.card-header -->

        <div class="card-body">
            <div class="row">
                <div class="col-lg-6 col-12">
                    <div class="form-group">
                        <label>NIC Number</label>
                        <input type="text" class="form-control" name="nic" placeholder="National Identity Card Number">
                    </div>
                </div>


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
                        <label for="exampleInputPassword1">Password</label>
                        <div class="input-group">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                                name="password" required autocomplete="new-password" placeholder="Enter password">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-default" id="defaultPasswordBtn">Use Default</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-12">
                    <div class="form-group">
                        <label for="exampleInputPassword1">Confirm the Password</label>
                        <input id="password-confirm" type="password" class="form-control"
                            name="password_confirmation" required autocomplete="new-password" placeholder="Confirm password">
                    </div>
                </div>
            </div>

            <small class="form-text text-muted">Minimum Password Length is 8 characters!</small>
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
            <div class="form-group text-right mb-0">
                <small class="form-text text-muted text-right">Please check details again.</small><br>
                <button type="submit" class="btn btn-danger btn-lg float-right"><b>&nbsp; Save All&nbsp;</b></button>
            </div>
        </div>
        <!-- /.card-footer -->
    </div>
    <!-- /.card -->
</div>


@push('specificCSS')
<style>
    .radio-tile-group {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
    }

    .input-container {
        position: relative;
        width: 160px;
        height: 90px;
    }

    .radio-button {
        opacity: 0;
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
        width: 100%;
        margin: 0;
        cursor: pointer;
        z-index: 2;
    }

    .radio-tile {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 100%;
        border: 2px solid #ddd;
        border-radius: 8px;
        padding: 15px;
        transition: all 0.2s ease;
        background-color: white;
    }

    .icon {
        color: #888;
        font-size: 1.5rem;
        transition: all 0.2s ease;
    }

    .radio-tile-label {
        margin-top: 8px;
        text-align: center;
        font-weight: 500;
        font-size: 0.9rem;
        color: #555;
        transition: all 0.2s ease;
    }

    .radio-button:checked + .radio-tile {
        border-color: #007bff;
        box-shadow: 0 0 12px rgba(0, 123, 255, 0.2);
        transform: scale(1.03);
    }

    .radio-button:checked + .radio-tile .icon {
        color: #007bff;
    }

    .radio-button:checked + .radio-tile .radio-tile-label {
        color: #007bff;
        font-weight: 600;
    }

    .radio-button:hover + .radio-tile {
        border-color: #007bff;
    }
</style>
@endpush
@push('specificJs')
<script>
document.getElementById('defaultPasswordBtn').addEventListener('click', function() {
    document.getElementById('password').value = '12345678';
    document.getElementById('password-confirm').value = '12345678';
});
</script>
@endpush
