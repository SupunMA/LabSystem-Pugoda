<div class="box">
    <div class="box-header">
      <h3 class="box-title">List of Doctors</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
          
          @include('Users.Admin.messages.addMsg')
  
  
          
          <table  id="example1" class="table table-bordered table-striped">
              
              <thead>
                  <tr>
                      <th>ID</th>
                      <th>Name</th>
                      <th>Gender</th>
                      <th>Mobile</th>
                      <th>Clinic Name</th>
                      <th>Clinic Address</th>
                      <th>Actions</th>
                  </tr>
              </thead>
              <tbody>
                  @foreach ($usersWithDoctors as $UserDoctor)
  
                    <tr>
                        <td>{{$UserDoctor->did}}</td>
                        <td>{{$UserDoctor->user->name}}</td>
                        <td>
                            @if ($UserDoctor->gender == 'M')
                                Male
                            @elseif ($UserDoctor->gender == 'F')
                                Female
                            @elseif ($UserDoctor->gender == 'O')
                                Other
                            @endif
                        </td>
                    
                        <td>{{$UserDoctor->mobile}}</td>
                        <td>{{$UserDoctor->clinicName}}</td>
                        <td>{{$UserDoctor->clinicAddress}}</td>
                        
                        
                        
                        
                        <td>
                            <a class="btn btn-warning" type="button" data-toggle="modal" data-target="#ClientEditModal-{{$UserDoctor->did}}" >
                                <i class="fa fa-pencil" aria-hidden="true"></i>
                            </a>
                            <a class="btn btn-danger" type="button" data-toggle="modal" data-target="#clientDeleteModal-{{$UserDoctor->did}}"  >
                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                            </a>
                        </td>
                    </tr>
  
                      {{-- delete modal --}}
                      @include('Users.Admin.Doctors.components.deleteDoctor')
                      {{-- update modal --}}
                      @include('Users.Admin.Doctors.components.updateDoctor')
  
  
                  @endforeach
              </tbody>
              <tfoot>
                  <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Gender</th>
                    <th>Mobile</th>
                    <th>Clinic Name</th>
                    <th>Clinic Address</th>
                    <th>Actions</th>
                  </tr>
              </tfoot>
          </table>
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.box -->

  
  @push('specificJs')
  {{-- toastr msg --}}
  
  <script>
      $(function () {
        $('#example1').DataTable()
      })
    </script>


  
  @endpush