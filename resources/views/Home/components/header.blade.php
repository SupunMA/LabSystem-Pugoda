<header id="header" class="fixed-top">
    <div class="container d-flex align-items-center">

      <h1 class="logo me-auto"><a href="/">HORIZON</a></h1>

      <!-- Uncomment below if you prefer to use an image logo -->
      <!-- <a href="index.html" class="logo me-auto"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

      <nav id="navbar" class="navbar order-last order-lg-0">
        <ul>
          <li><a class="nav-link scrollto active" href="#hero">Home</a></li>
          <li><a class="nav-link scrollto" href="#about">About</a></li>
          <li><a class="nav-link scrollto" href="#services">Services</a></li>
          <li><a class="nav-link" href="{{ route('privacy') }}" target="_blank">Privacy Policy</a></li>

        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->

  <!-- ======= Hero Section ======= -->
  <section id="hero" class="d-flex align-items-center">
    <div class="container">
<h1>Welcome to HORIZON-LAB</h1>
<h2><b>"Testing Today, Healthier Tomorrow"</b></h2>
      @if (Route::has('login'))

        @auth
        <a href="{{ route('admin.home') }}" class="btn-get-started scrollto">My Account</a>
        @else
        <a href="{{ route('login') }}" class="btn-get-started scrollto">Login</a>

        @if (Route::has('register2'))
        <a href="{{ route('register2') }}" class="btn-services scrollto">Register</a>
        @endif
        @endauth

    @endif
    </div>
  </section><!-- End Hero -->




  <div>

</div>
