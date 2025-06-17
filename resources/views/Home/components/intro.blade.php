 <!-- ======= Why Us Section ======= -->
 <section id="why-us" class="why-us">
    <div class="container">

      <div class="row">
        <div class="col-lg-4 d-flex align-items-stretch">
          <div class="content">
            <h3>Why Choose HORIZON?</h3>
            <p>
            Choose HORIZON for unmatched diagnostic precision and personalized care.
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
            <i class="fas fa-file"></i>
            <span data-purecounter-start="0" data-purecounter-end="{{$reports}}" data-purecounter-duration="1" class="purecounter"></span>
            <p>Reports</p>
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
        <p>HORIZON's pathology services offer a wide array of diagnostic tests that analyze bodily samples,
          providing insights into various health aspects and aiding in accurate diagnosis and informed medical decisions.</p>
      </div>

<div class="modern-carousel-container" style="position: relative; width: 100%; max-width: 100%;">
    <!-- Cards Container -->
    <div class="scrollable-container" id="cardsContainer" style="
        overflow-x: auto;
        scroll-behavior: smooth;
        scrollbar-width: none; /* Firefox */
        -ms-overflow-style: none; /* IE and Edge */
        padding: 20px 0 40px 0;
        position: relative;
    ">
        <div class="cards-wrapper" style="
            display: flex;
            gap: 20px;
            padding: 0 20px;
            width: max-content;
        ">
            @foreach ($allAvialableTest as $index => $oneAT)
                <div class="card-item" data-index="{{$index}}" style="
                    flex: 0 0 280px;
                    min-width: 280px;
                    border: 1px solid #e0e0e0;
                    border-radius: 12px;
                    padding: 30px 20px;
                    text-align: center;
                    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
                    background: white;
                    transition: all 0.3s ease;
                    cursor: pointer;
                ">
                    <div style="
                        font-size: 45px;
                        color: #1977cc;
                        margin-bottom: 20px;
                        transition: transform 0.3s ease;
                    ">
                        <i class="fas fa-heartbeat"></i>
                    </div>
                    <h4 style="
                        font-size: 18px;
                        font-weight: 600;
                        color: #333;
                        margin: 0;
                        line-height: 1.4;
                        overflow: hidden;
                        text-overflow: ellipsis;
                        white-space: nowrap;
                        max-width: 100%;
                    " title="{{$oneAT->name}}">{{$oneAT->name}}</h4>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Dot Indicators -->
    <div class="dots-container" id="dotsContainer" style="
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 8px;
        margin-top: 20px;
        padding: 0 20px;
    ">
        <!-- Dots will be generated by JavaScript -->
    </div>
</div>

    </div>
  </section><!-- End Services Section -->

