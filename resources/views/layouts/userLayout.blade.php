<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>HORIZON | Admin</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

   <!-- Style -->
   @include('layouts.adminComponents.lib.Style')
</head>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
<!-- Main Header -->
    @include('layouts.userComponents.navBar')
<!-- /Main Header -->

  <!-- Left side column. contains the logo and sidebar -->
  @include('layouts.userComponents.sideBar')


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>

        @yield('header')
        <small>@yield('header')</small>

      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('admin.home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">@yield('header')</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">


        @yield('content')


    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
  @include('layouts.adminComponents.footer')



</div>
<!-- ./wrapper -->
<!-- Logout Modal and Form -->
@include('layouts.adminComponents.modal.logoutModal')
<!-- REQUIRED JS SCRIPTS -->
@include('layouts.adminComponents.lib.js')

</body>
</html>
