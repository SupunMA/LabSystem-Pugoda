<!-- Edit branch -->
<div class="modal fade" id="ClientEditModal-{{$UserPatient->pid}}" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalCenterTitle">Update Patient<b> {{$UserPatient->user->name}}</b> </h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{route('admin.updatePatient')}}" method="post">
                @csrf
            <div class="box box-primary">
       
                    <!-- /.box-header -->
                    <!-- form start -->
                <div class="box-body">

                    <div class="row">
                        <div class="col-lg-8 col-12">
                            <div class="form-group">
                                <label >Name</label>
                                <input type="name" name="name" value="{{$UserPatient->user->name}}" class="form-control" placeholder="Enter Name">
                            </div>
                        </div>
                    {{-- Gender --}}
                    
                        <div class="col-lg-4 col-12">
                            <div class="form-group">
                                <label>Gender</label>
                                
                                <select class="form-control" style="width: 100%;" name="gender">
                                    @if ($UserPatient->gender=="M")
                                    {
                                        <option value="M" selected="selected">Male</option>
                                        <option value="F">Female</option>
                                        <option value="O">Other</option>
                                    }
                                    @elseif ($UserPatient->gender=="F")
                                    {
                                        <option value="M">Male</option>
                                        <option value="F" selected="selected">Female</option>
                                        <option value="O">Other</option>
                                    }
                                    @elseif ($UserPatient->gender=="O")
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
                        <!-- Date -->
                        <div class="col-lg-6 col-12">
                            <!-- Date dd/mm/yyyy -->
                            <!-- Date -->
                            <div class="form-group">
                                <label>Date of Birth </label>

                                <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" value="{{\Carbon\Carbon::parse($UserPatient->dob)->format('m/d/Y')}}" class="form-control pull-right" id="{{$UserPatient->pid}}datepicker" name="dob">
                                </div>
                                <!-- /.input group -->
                            </div>
                        <!-- /.form group -->
                        </div>

            

                        {{-- Mobile --}}
                    
                        <div class="col-lg-6 col-12">
                            

                            <!-- phone mask -->
                            <div class="form-group">
                                <label>Mobile</label>

                                <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-phone"></i>
                                </div>
                                <input type="text" value="{{$UserPatient->mobile}}" class="form-control" name="mobile" data-inputmask='"mask": "(999) 999-9999"' data-mask>
                                </div>
                                <!-- /.input group -->
                            </div>
                            <!-- /.form group -->

                        </div>
                    </div>

                    {{-- address --}}
                    <div class="row">
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label>Address</label>
                                <textarea class="form-control" rows="3" name="address" placeholder="Enter ...">{{$UserPatient->address}}</textarea>
                         
                            </div>
                        </div>
                    </div>

                    
                
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success btn-lg pull-right">Save</button>   


                    </div>     

                </div>
        
    <input type="hidden" name="pid" value="{{$UserPatient->pid}}">
    <input type="hidden" name="id" value="{{$UserPatient->user->id}}">
    <!-- /.box -->
            </div>
            </form>

        </div>
    </div>
</div>


@push('specificJs')
    <script>
    //Date picker
    $('#{{$UserPatient->pid}}datepicker').datepicker({
        autoclose: true
    })
    </script>
@endpush