<header id="header" class="fixed-top">
    <div class="container d-flex align-items-center">

      <h1 class="logo me-auto"><a href="/">HORIZON LAB</a></h1>

      <!-- Uncomment below if you prefer to use an image logo -->
      <!-- <a href="index.html" class="logo me-auto"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

      <nav id="navbar" class="navbar order-last order-lg-0">
        <ul>
          <li><a class="nav-link scrollto active" href="#hero">Home</a></li>
          <li><a class="nav-link scrollto" href="#about">Services</a></li>
          <li><a class="nav-link scrollto" href="#services">Available Tests</a></li>
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
        <a href="{{ route('login') }}" style="background-color: #e81a1a; color: white; padding: 10px 20px; text-decoration: none; border-radius: 30px; font-family: Arial, sans-serif; font-size: 16px; display: inline-block;" class="btn-get-started scrollto">Login</a>

        @if (Route::has('register2'))
        <a href="{{ route('register2') }}" class="btn-services scrollto">Register</a>
        @endif
        @endauth

    @endif
    <a href="https://wa.me/94776267627"  style="background-color: #07943b; color: white; padding: 10px 20px; text-decoration: none; border-radius: 30px; font-family: Arial, sans-serif; font-size: 16px; display: inline-block;" target="_blank">
        <i class="fab fa-whatsapp" style="margin-right: 8px;"></i>
        WhatsApp
    </a>
<br>
    <a href="https://maps.app.goo.gl/1wbjHTx3F93WNKm36"
        target="_blank"
        style="margin-top: 8px;background-color: #1a73e8; color: white; padding: 10px 20px; text-decoration: none; border-radius: 30px; font-family: Arial, sans-serif; font-size: 16px; display: inline-block;">
        <i class="fas fa-map-marker-alt" style="margin-right: 8px;"></i>
        Open Location
    </a>
    </div>
  </section><!-- End Hero -->




  <div>

</div>
