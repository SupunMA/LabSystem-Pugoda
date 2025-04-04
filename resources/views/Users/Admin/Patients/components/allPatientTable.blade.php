<div class="box">
  <div class="box-header">
    <h3 class="box-title">List of Patients</h3>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
        
        @include('Users.Admin.messages.addMsg')


        
        <table  id="example1" class="table table-bordered table-striped">
            
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Date of Birth</th>
                    <th>Gender</th>
                    <th>Mobile</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($usersWithPatients as $UserPatient)

                    <tr>
                        <td>{{$UserPatient->pid}}</td>
                        <td>{{$UserPatient->user->name}}</td>
                        <td>{{$UserPatient->dob}}</td>
                        <td>
                            @if ($UserPatient->gender == 'M')
                                Male
                            @elseif ($UserPatient->gender == 'F')
                                Female
                            @elseif ($UserPatient->gender == 'O')
                                Other
                            @endif
                        </td>
                    
                        <td>{{$UserPatient->mobile}}</td>
                        <td>{{$UserPatient->user->email}}</td>
                        <td>{{$UserPatient->address}}</td>
                        
                        
                        
                        
                        <td>
                            <a class="btn btn-warning" type="button" data-toggle="modal" data-target="#ClientEditModal-{{$UserPatient->pid}}" >
                                <i class="fa fa-pencil" aria-hidden="true"></i>
                            </a>
                            <a class="btn btn-danger" type="button" data-toggle="modal" data-target="#clientDeleteModal-{{$UserPatient->pid}}"  >
                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                            </a>
                        </td>
                    </tr>

                    {{-- delete modal --}}
                    @include('Users.Admin.Patients.components.deletePatient')
                    {{-- update modal --}}
                    @include('Users.Admin.Patients.components.updatePatient')
                    
                    
                    
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Date of Birth</th>
                    <th>Gender</th>
                    <th>Mobile</th>
                    <th>Email</th>
                    <th>Address</th>
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


<script>
    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    })
  </script>

@endpush