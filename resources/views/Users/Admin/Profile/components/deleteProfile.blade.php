<!-- Edit branch -->
<div class="modal fade" id="clientDeleteModal-{{$client->id}}" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title text-danger" id="exampleModalCenterTitle">Delete <b>{{$client->name}}</b> Account</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="admin/delete/{{$client->id}}" method="get">
                @csrf
                
                <div class="modal-body">
                  
                    <h5>{{$client->name}}, Do you want to Delete .. </h5>
                        <h2 class="text-center text-danger"> Your Account?</h2>
                    <i>Please confirm it again. you will not be able to recover this user data.</i>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger" >Delete Permanently</button>
                </div>
            </form>

        </div>
    </div>
</div>


