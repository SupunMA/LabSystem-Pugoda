<div class="modal fade" id="branchDeleteModal-{{$TestData->tid}}" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title text-danger" id="exampleModalCenterTitle">Delete Test <b>{{$TestData->AvailableTestName}}</b> </h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="test/delete/{{$TestData->tid}}" method="get">
                @csrf
                
                <div class="modal-body">
                  
                    <h4>Are you sure you want to Delete Test?.. </h4>
                        <h2 class="text-center text-warning"> <b>{{$TestData->name}}</b> Patient's Test</h2>
                    <i>Please confirm it again. you will not be able to recover this test data.</i>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger" >Delete Permanently</button>
                </div>
            </form>

        </div>
    </div>
</div>


