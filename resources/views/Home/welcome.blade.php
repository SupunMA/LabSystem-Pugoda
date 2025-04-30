<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>HORIZON Lab</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  @include('Home.components.cssJs.style')

</head>

<body>



  <!-- ======= Header ======= -->
  @include('Home.components.header')

  <main id="main">


    @include('Home.components.intro')






  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  @include('Home.components.footer')

  <!-- End Footer -->

  <div id="preloader"></div>
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>


  @include('Home.components.cssJs.js')

</body>

</html>
