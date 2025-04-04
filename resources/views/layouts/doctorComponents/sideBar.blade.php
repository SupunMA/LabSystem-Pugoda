
{{-- v2 admin --}}

<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      <!-- Sidebar user panel (optional) -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src={{ URL::asset('adminPages/v2/dist/img/doctor.png'); }} class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>Dr.{{ Auth::user()->name }}</p>
          <!-- Status -->
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>

      <!-- search form (Optional) -->
      {{-- <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
              <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
              </button>
            </span>
        </div>
      </form> --}}
      <!-- /.search form -->

      <!-- Sidebar Menu -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">Menu List</li>
        <!-- Optionally, you can add icons to the links -->

        <li class="{{ Route::currentRouteNamed('doctor.home') ? 'active' : ' ' }}"><a href="{{ route('doctor.home') }}"><i class="fa fa-tachometer"></i> <span>Dashboard</span></a></li>


        <li class="{{ Route::currentRouteNamed('DoctorProfileUpdate') ? 'active' : '' }}"><a href="{{ route('DoctorProfileUpdate') }}"><i class="fa fa-tachometer"></i> <span>My Profile
          <span class="right badge badge-warning">Update</span></span></a></li>



      {{-- Logout --}}
      <li>
          <!-- Logout modal trigger Button -->
          <a href="#" class="nav-link btn btn-primary btn-lg" data-toggle="modal" data-target="#staticBackdrop">
          <span>Logout</span>
          </a>
      </li>




      </ul>
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>
