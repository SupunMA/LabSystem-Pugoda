<!-- Edit Plan -->
<div class="modal fade" id="branchEditModal-{{$data->rid}}" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalCenterTitle">Update Report <b>{{$data->rid}}</b> </h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{ route('admin.updateReport') }}" method="post">
                @csrf
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label>Result Value</label>
                                    
                                    <input type="number"  name="result" class="form-control" value="{{$data->result}}" placeholder="Enter Result">
                                </div>
                            </div>
            
            
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label>Select Status</label>
                                    
                                    <select class="form-control select2" style="width: 100%;" name="status">
                                        @if ($data->status == "Normal")
                                            <option selected="selected" value="Normal">Normal</option>
                                            <option value="Abnormal">Abnormal</option>
                                        @else
                                            <option  value="Normal">Normal</option>
                                            <option value="Abnormal" selected="selected">Abnormal</option>
                                        @endif
            
                                    </select>
                                </div>
                            </div>
                        </div>
                        
        
                        <input type="hidden" name="rid" value="{{$data->rid}}">

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
