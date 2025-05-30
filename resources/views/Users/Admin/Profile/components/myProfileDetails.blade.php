<!-- This form included into addClient Blade -->

<!-- This form included into addClient Blade -->

<div class="col-lg-12 col-12">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Your Details</h3>
        </div>
        <!-- /.card-header -->

        <!-- Form Start -->
        <div class="card-body">
            {{-- <form action="{{route('admin.updateAdmin')}}" method="post"> --}}
            @csrf

            <input type="hidden" name="id" value="{{ $client->id }}">

            <!-- Name and Email Row -->
            <div class="row">
                <!-- Name Field -->
                <div class="col-lg-4 col-12">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" value="{{ $client->name }}" class="form-control" id="name" placeholder="Enter Name">
                    </div>
                </div>

                <!-- Email Field -->
                <div class="col-lg-4 col-12">
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="Email Address" value="{{ $client->email }}">
                    </div>
                </div>

                {{-- NIC --}}
                <div class="col-lg-4 col-12">
                    <div class="form-group">
                        <label for="nic">NIC</label>
                        <input type="text" class="form-control" name="nic" placeholder="National Identity Card Number" value="{{ $client->nic }}">
                    </div>
                </div>
            </div>
            <!-- /.row -->

            {{-- </form> --}}
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>
<!-- /.col -->
{{-- End of First Card --}}

@push('specificJs')


@endpush
