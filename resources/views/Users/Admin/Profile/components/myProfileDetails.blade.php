<!-- This form included into addClient Blade -->

<div class="col-lg-8 col-12 ">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="card-title">Your Details</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->

        <div class="box-body">
            

            {{-- <form action="{{route('admin.updateAdmin')}}" method="post"> --}}
                @csrf
                
                <input type="hidden" name="id" value="{{$client->id}}">
                
                
    {{-- Gender and DOB --}}
                <div class="row">
                    <div class="col-lg-6 col-12">
                        <div class="form-group">
                        <label >Name</label>
                        <input type="name" name="name" value="{{$client->name}}" class="form-control" id="name" placeholder="Enter Name">
                    
                        </div>
                    
                </div>
    
                    
                    <div class="col-lg-6 col-12">
                        <div class="form-group">
                            <label >Email Address</label>
                            <input type="email" class="form-control" name="email" placeholder="Email Address" value="{{$client->email}}">
                        </div>
                    </div>
                    
    
                </div>
  
                    
            {{-- </form> --}}
        </div>

        


    </div>
</div>
{{-- End of First Card --}}

@push('specificJs')


@endpush