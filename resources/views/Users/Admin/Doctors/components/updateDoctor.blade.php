<!-- Edit branch -->
<div class="modal fade" id="ClientEditModal-{{$UserDoctor->did}}" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalCenterTitle">Update Doctor<b> {{$UserDoctor->user->name}}</b> </h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{route('admin.updateDoctor')}}" method="post">
                @csrf

            <div class="box box-primary">
       
                    <!-- /.box-header -->
                    <!-- form start -->
                    <div class="box-body">

                        <div class="row">
                            <div class="col-lg-8 col-12">
                                <div class="form-group">
                                    <label >Name</label>
                                    <input type="name" name="name" class="form-control" id="name" value="{{$UserDoctor->user->name}}" placeholder="Enter Name">
                                </div>
                            </div>
                        {{-- Gender --}}
                        
                            <div class="col-lg-4 col-12">
                                <div class="form-group">
                                    <label>Gender</label>
                                    
                                    <select class="form-control" style="width: 100%;" name="gender">
                                        @if ($UserDoctor->gender=="M")
                                    {
                                        <option value="M" selected="selected">Male</option>
                                        <option value="F">Female</option>
                                        <option value="O">Other</option>
                                    }
                                    @elseif ($UserDoctor->gender=="F")
                                    {
                                        <option value="M">Male</option>
                                        <option value="F" selected="selected">Female</option>
                                        <option value="O">Other</option>
                                    }
                                    @elseif ($UserDoctor->gender=="O")
                                    {
                                        <option value="M">Male</option>
                                        <option value="F">Female</option>
                                        <option value="O" selected="selected">Other</option>
                                    }
                                   
                                    @endif 
                                        
                                        
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
                                    <input type="text" class="form-control" name="mobile" value="{{$UserDoctor->mobile}}" data-inputmask='"mask": "(999) 999-9999"' data-mask>
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
                                    <input type="name" name="clinicName" class="form-control" placeholder="Clinic Name" value="{{$UserDoctor->clinicName}}">
                                </div>
                            </div>
            
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label>Clinic Address</label>
                                    <textarea class="form-control" rows="3" name="clinicAddress" placeholder="Clinic Address..">{{$UserDoctor->clinicAddress}}</textarea>
                             
                                </div>
                            </div>
                        </div>
            
                        
                    </div>
        
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success btn-lg pull-right">Save</button>   
                    </div>

                <input type="hidden" name="did" value="{{$UserDoctor->did}}">
                <input type="hidden" name="id" value="{{$UserDoctor->user->id}}">
    <!-- /.box -->
            </div>
            </form>

        </div>
    </div>
</div>
