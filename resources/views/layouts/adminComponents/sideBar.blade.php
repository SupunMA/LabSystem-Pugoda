<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{route('admin.home')}}" class="brand-link">
        <img src="https://media.istockphoto.com/id/1145254708/vector/portable-swimming-pool-vector-icon-illustration.jpg?s=612x612&w=0&k=20&c=lmIkgqOrzddXYqGZwWgClceUT5ZDK11MjKKarmXm90U="
            alt="Logo" class="brand-image img-circle elevation-3" style="opacity: 1">
        <span class="brand-text font-weight-light">Admin Panel</span>
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
                <a href="{{ route('admin.home') }}" class="nav-link {{ Route::currentRouteNamed('admin.home') ? 'active' : ' ' }}">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>Dashboard
                        <span class="right badge badge-danger">Live</span>
                    </p>
                </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.allPatient') }}" class="nav-link {{ Route::currentRouteNamed('admin.allPatient') ? 'active' : ' ' }}">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Request Test
                            <span class="right badge badge-danger">Live</span>
                        </p>
                    </a>
                </li>


                <li class="nav-item {{ Route::currentRouteNamed('admin.addPatient') || Route::currentRouteNamed('admin.allPatient') ? 'menu-open' : 'menu-close' }}">
                    <a href="#" class="nav-link {{ Route::currentRouteNamed('admin.addPatient') || Route::currentRouteNamed('admin.allPatient') ? 'active' : '' }} ">
                        <i class="fas fa-users"></i>
                        <p>
                            Patients
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.addPatient') }}" class="nav-link {{ Route::currentRouteNamed('admin.addPatient') ? 'active' : '' }} ">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Register Patient</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.allPatient') }}" class="nav-link {{ Route::currentRouteNamed('admin.allPatient') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>All Patients</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- <li class="nav-item {{ Route::currentRouteNamed('admin.addDoctor') || Route::currentRouteNamed('admin.allDoctor') ? 'menu-open' : 'menu-close' }}">
                    <a href="#" class="nav-link {{ Route::currentRouteNamed('admin.addDoctor') || Route::currentRouteNamed('admin.allDoctor') ? 'active' : '' }} ">
                        <i class="fas fa-users"></i>
                        <p>
                            Doctors
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.addDoctor') }}" class="nav-link {{ Route::currentRouteNamed('admin.addDoctor') ? 'active' : '' }} ">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Register Doctor</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.allDoctor') }}" class="nav-link {{ Route::currentRouteNamed('admin.allDoctor') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>All Doctors</p>
                            </a>
                        </li>
                    </ul>
                </li> --}}


                <li class="nav-item {{ Route::currentRouteNamed('admin.addTest') || Route::currentRouteNamed('admin.allTest') ? 'menu-open' : 'menu-close' }}">
                    <a href="#" class="nav-link {{ Route::currentRouteNamed('admin.addTest') || Route::currentRouteNamed('admin.allTest') ? 'active' : '' }} ">
                        <i class="fas fa-users"></i>
                        <p>
                            Requested Tests
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.addTest') }}" class="nav-link {{ Route::currentRouteNamed('admin.addTest') ? 'active' : '' }} ">
                                <i class="far fa-circle nav-icon"></i>
                                <p>OnSite Tests</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.allTest') }}" class="nav-link {{ Route::currentRouteNamed('admin.allTest') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>SendOut Tests</p>
                            </a>
                        </li>
                    </ul>
                </li>


                <li class="nav-item {{ Route::currentRouteNamed('admin.addReport') || Route::currentRouteNamed('admin.allReport') ? 'menu-open' : 'menu-close' }}">
                    <a href="#" class="nav-link {{ Route::currentRouteNamed('admin.addReport') || Route::currentRouteNamed('admin.allReport') ? 'active' : '' }} ">
                        <i class="fas fa-users"></i>
                        <p>
                            Reports
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.addReport') }}" class="nav-link {{ Route::currentRouteNamed('admin.addReport') ? 'active' : '' }} ">
                                <i class="far fa-circle nav-icon"></i>
                                <p>OnSite Reports</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.allReport') }}" class="nav-link {{ Route::currentRouteNamed('admin.allReport') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>SendOut Reports</p>
                            </a>
                        </li>
                    </ul>
                </li>


                <li class="nav-item {{ Route::currentRouteNamed('admin.addAvailableTest') || Route::currentRouteNamed('admin.allAvailableTest') || Route::currentRouteNamed('admin.addExternalAvailableTest') || Route::currentRouteNamed('admin.allExternalAvailableTest')? 'menu-open' : 'menu-close' }}">
                    <a href="#" class="nav-link {{ Route::currentRouteNamed('admin.addAvailableTest') || Route::currentRouteNamed('admin.allAvailableTest') || Route::currentRouteNamed('admin.addExternalAvailableTest') || Route::currentRouteNamed('admin.allExternalAvailableTest')? 'active' : '' }} ">
                        <i class="fas fa-users"></i>
                        <p>
                            Available Tests
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.addAvailableTest') }}" class="nav-link {{ Route::currentRouteNamed('admin.addAvailableTest') ? 'active' : '' }} ">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add OnSite Test</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.allAvailableTest') }}" class="nav-link {{ Route::currentRouteNamed('admin.allAvailableTest') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>All OnSite Tests</p>
                            </a>
                        </li>


                        <li class="nav-item">
                            <a href="{{ route('admin.addExternalAvailableTest') }}" class="nav-link {{ Route::currentRouteNamed('admin.addExternalAvailableTest') ? 'active' : '' }} ">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add onSite Test</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.allExternalAvailableTest') }}" class="nav-link {{ Route::currentRouteNamed('admin.allExternalAvailableTest') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>All SendOut Tests</p>
                            </a>
                        </li>
                    </ul>
                </li>


                <li class="nav-item">
                    <a href="{{ route('AdminViewUpdateProfile') }}" class="nav-link {{ Route::currentRouteNamed('AdminViewUpdateProfile') ? 'active' : ' ' }}">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>My Profile
                            <span class="right badge badge-danger">Update</span>
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

