<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{route('admin.home')}}" class="brand-link">
        <img src="/img/fav.png" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: 1">
        <span class="brand-text font-weight-light">Patient Account</span>
    </a>

        <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="https://icon-library.com/images/admin-user-icon/admin-user-icon-4.jpg"
                    class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ Auth::user()->name }}</a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        {{-- <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                    aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div> --}}

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                with font-awesome or any other icon font library -->
                <li class="nav-item">
                <a href="{{ route('user.home') }}" class="nav-link {{ Route::currentRouteNamed('user.home') ? 'active' : ' ' }}">
                    <i class="fa-solid fa-file-pdf"></i>
                    <p>My Reports
                        {{-- <span class="right badge badge-danger">Live</span> --}}
                    </p>
                </a>
                </li>


                <li class="nav-item">
                    <a href="{{ route('PatientProfileUpdate') }}" class="nav-link {{ Route::currentRouteNamed('PatientProfileUpdate') ? 'active' : ' ' }}">
                    <i class="fa fa-user" aria-hidden="true"></i>
                        <p>My Profile
                            {{-- <span class="right badge badge-danger">Update</span> --}}
                        </p>
                    </a>
                </li>


                <li class="nav-item">
                    <!-- Logout modal trigger Button -->
                    <a href="#" class="nav-link btn btn-danger" data-toggle="modal" data-target="#staticBackdrop">
                    <i class="fas fa-sign-out-alt"></i>
                        <p>Logout</p>
                    </a>
                </li>


            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>

