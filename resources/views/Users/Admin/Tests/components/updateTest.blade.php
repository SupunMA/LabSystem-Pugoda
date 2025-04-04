<!-- Edit Plan -->
<div class="modal fade" id="branchEditModal-{{$TestData->tid}}" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalCenterTitle">Update Test <b>{{$TestData->tid}}</b> </h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{ route('admin.updateTest') }}" method="post">
                @csrf
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
            
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label>Select The Test</label>
                                    
                                    <select class="form-control select2" style="width: 100%;" name="tlid">
                                        {{-- <option selected="selected">Alabama</option> --}}
                                        @foreach ($availableTests as $availableTest)
                                            @if ($availableTest->tlid == $TestData->tlid)
                                                <option value="{{$availableTest->tlid}}" selected="selected">{{$availableTest->AvailableTestName}} - Rs.{{$availableTest->AvailableTestCost}}</option>
                                                @else
                                                <option value="{{$availableTest->tlid}}">{{$availableTest->AvailableTestName}} - Rs.{{$availableTest->AvailableTestCost}}</option>
                                            @endif
                                            
                                        @endforeach
                                        
                                    </select>
                                </div>
                            </div>
            
                        
                    
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label>Name of the Doctor</label>
                                    
                                    <input type="text" name="doctorName" value="{{$TestData->doctorName}}" class="form-control" placeholder="Name of the Doctor">
                                </div>
                            </div>
            
                        </div>
                    
                        <input type="hidden" name="tid" value="{{$TestData->tid}}">

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Save changes</button>
                    </div>
                </div>
        </div>
                
            </form>

       
    </div>
</div>
