<div class="modal fade" id="branchDeleteModal-{{$data->rid}}" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title text-danger" id="exampleModalCenterTitle">Delete Report <b>{{$data->rid}}</b> </h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="report/delete/{{$data->rid}}" method="get">
                @csrf
                
                <div class="modal-body">
                  
                    <h4>Are you sure you want to Delete ?.. </h4>
                        <h2 class="text-center text-warning">Report <b>{{$data->rid}}</b> </h2>
                    <i>Please confirm it again. you will not be able to recover this Report data.</i>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger" >Delete Permanently</button>
                </div>
            </form>

        </div>
    </div>
</div>


