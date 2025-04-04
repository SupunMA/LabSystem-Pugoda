 <!-- ======= Why Us Section ======= -->
 <section id="why-us" class="why-us">
    <div class="container">

      <div class="row">
        <div class="col-lg-4 d-flex align-items-stretch">
          <div class="content">
            <h3>Why Choose Medilab?</h3>
            <p>
            Choose Medihelp for unmatched diagnostic precision and personalized care. 
            Our advanced technology, expert team, and commitment to accuracy ensure reliable results you can trust. 
            Your health journey deserves our unwavering excellence.
            </p>
            <div class="text-center">
              <a href="#" class="more-btn">Learn More <i class="bx bx-chevron-right"></i></a>
            </div>
          </div>
        </div>
        <div class="col-lg-8 d-flex align-items-stretch">
          <div class="icon-boxes d-flex flex-column justify-content-center">
            <div class="row">
              <div class="col-xl-4 d-flex align-items-stretch">
                <div class="icon-box mt-4 mt-xl-0">
                  <i class="bx bx-receipt"></i>
                  <h4>Precision:</h4>
                  <p>We prioritize utmost accuracy and reliability in all our tests, 
                    ensuring that the information we provide is trustworthy and valuable for your health decisions.</p>
                </div>
              </div>
              <div class="col-xl-4 d-flex align-items-stretch">
                <div class="icon-box mt-4 mt-xl-0">
                  <i class="bx bx-cube-alt"></i>
                  <h4>Compassion:</h4>
                  <p>Our team approaches every individual with empathy and understanding, 
                    recognizing the importance of addressing not just the medical aspects.</p>
                </div>
              </div>
              <div class="col-xl-4 d-flex align-items-stretch">
                <div class="icon-box mt-4 mt-xl-0">
                  <i class="bx bx-images"></i>
                  <h4>Innovation: </h4>
                  <p>We continuously seek out and incorporate the latest technological advancements to elevate the quality of our services.</p>
                </div>
              </div>
            </div>
          </div><!-- End .content-->
        </div>
      </div>

    </div>
  </section><!-- End Why Us Section -->

  <!-- ======= About Section ======= -->
  <section id="about" class="about">
    <div class="container-fluid">

      <div class="row">
        <div class="col-xl-5 col-lg-6 video-box d-flex justify-content-center align-items-stretch position-relative">
        </div>

        <div class="col-xl-7 col-lg-6 icon-boxes d-flex flex-column align-items-stretch justify-content-center py-5 px-lg-5">
          <h3>Pathology Services:</h3>
          <p>Our comprehensive pathology services encompass a range of diagnostic techniques that analyze bodily samples, aiding in the accurate detection, diagnosis, and monitoring of diseases. 
            From routine tests to complex analyses, our pathology expertise contributes to informed medical decisions and personalized patient care.</p>

          <div class="icon-box">
            <div class="icon"><i class="bx bx-fingerprint"></i></div>
            <h4 class="title"><a href="">Chemical Pathology</a></h4>
            <p class="description">The Clinical Biochemistry section carries the largest workload in any medical laboratory. 
              It performs chemical analysis of blood, urine and body fluids for a wide range of chemical constituents, selected and requested by a medical practitioner.</p>
          </div>

          <div class="icon-box">
            <div class="icon"><i class="bx bx-gift"></i></div>
            <h4 class="title"><a href="">Haematology</a></h4>
            <p class="description">Haematology is the study of disorders of blood and the blood forming organs, lymphomas and the lymphoreticular system.</p>
          </div>

          <div class="icon-box">
            <div class="icon"><i class="bx bx-atom"></i></div>
            <h4 class="title"><a href="">Flow Cytometry</a></h4>
            <p class="description">Flow cytometry is a technology that utilises identification of known carbohydrate and or protein molecules on the surface of cells to identify them very specifically.</p>
          </div>

        </div>
      </div>

    </div>
  </section><!-- End About Section -->

  <!-- ======= Counts Section ======= -->
  <section id="counts" class="counts">
    <div class="container">

      <div class="row">

        <div class="col-lg-4 col-md-6">
          <div class="count-box">
            <i class="fas fa-user-md"></i>
            <span data-purecounter-start="0" data-purecounter-end="{{$Dcount}}" data-purecounter-duration="1" class="purecounter"></span>
            <p>Doctors</p>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 mt-5 mt-md-0">
          <div class="count-box">
            <i class="far fa-hospital"></i>
            <span data-purecounter-start="0" data-purecounter-end="{{$Pcount}}" data-purecounter-duration="1" class="purecounter"></span>
            <p>Registered Patients</p>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 mt-5 mt-lg-0">
          <div class="count-box">
            <i class="fas fa-flask"></i>
            <span data-purecounter-start="0" data-purecounter-end="{{$availableTcount}}" data-purecounter-duration="1" class="purecounter"></span>
            <p>Available Tests</p>
          </div>
        </div>
      

      </div>
    
    </div>
  </section><!-- End Counts Section -->

  <!-- ======= Services Section ======= -->
  <section id="services" class="services">
    <div class="container">

      <div class="section-title">
        <h2>Available Tests</h2>
        <p>Medihelp's pathology services offer a wide array of diagnostic tests that analyze bodily samples, 
          providing insights into various health aspects and aiding in accurate diagnosis and informed medical decisions.</p>
      </div>

      <div class="row">
        @foreach ($allAvialableTest as $oneAT)
            <div class="col-lg-4 col-md-6 d-flex align-items-stretch">
                <div class="icon-box">
                    <div class="icon"><i class="fas fa-heartbeat"></i></div>
                    <h4>{{$oneAT->AvailableTestName}}</h4>
                    
                </div>
                </div>
        @endforeach
                

      </div>
    </div>
  </section><!-- End Services Section -->

  