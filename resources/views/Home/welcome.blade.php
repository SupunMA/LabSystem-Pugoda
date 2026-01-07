<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>HORIZON Lab - Medical Laboratory Testing | Blood Tests, Urine Analysis & Health Diagnostics</title>
  <meta content="Professional medical laboratory services offering comprehensive blood tests, urine analysis, diabetes screening, and diagnostic testing. Fast, accurate results for all your health monitoring needs." name="description">
  <meta content="medical laboratory, blood test, urine analysis, diabetes test, lab testing, health diagnostics, medical screening, pathology lab, clinical laboratory, health checkup, blood sugar test, cholesterol test, hormone testing, specimen analysis" name="keywords">

  <!-- Favicons -->
  <link rel="icon" type="image/png" sizes="32x32" href="/img/fav.png">

  <link rel="manifest" href="/site.webmanifest">
  <meta name="msapplication-TileColor" content="#da532c">
  <meta name="theme-color" content="#ffffff">

  <!-- Additional SEO Meta Tags -->
  <meta name="robots" content="index, follow">
  <meta name="author" content="HORIZON Lab">
  <meta name="language" content="en">
  <meta name="revisit-after" content="7 days">
  <meta name="distribution" content="global">
  <meta name="rating" content="general">

  <!-- Open Graph Meta Tags for Social Media -->
  <meta property="og:title" content="HORIZON Lab - Medical Laboratory Testing Services">
  <meta property="og:description" content="Professional medical laboratory services offering comprehensive blood tests, urine analysis, diabetes screening, and diagnostic testing. Fast, accurate results for all your health monitoring needs.">
  <meta property="og:type" content="website">
  <meta property="og:url" content="https://www.horizonlab.lk">
  <meta property="og:image" content="https://www.horizonlab.lk/img/report-logo.png">
  <meta property="og:site_name" content="HORIZON Lab">
  <meta property="og:locale" content="en_US">

  <!-- Twitter Card Meta Tags -->
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="HORIZON Lab - Medical Laboratory Testing Services">
  <meta name="twitter:description" content="Professional medical laboratory services offering comprehensive blood tests, urine analysis, diabetes screening, and diagnostic testing.">
  <meta name="twitter:image" content="https://www.horizonlab.lk/img/report-logo.png">

  <!-- Schema.org Structured Data -->
  <script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "MedicalBusiness",
  "name": "HORIZON Lab",
  "description": "Professional medical laboratory services offering comprehensive blood tests, urine analysis, diabetes screening, and diagnostic testing.",
  "url": "{{ url('/') }}",
  "telephone": "+94-0776-267-627",
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "No. 148/A4, Infront of Hospital, Bangalawaththa",
    "addressLocality": "Pugoda",
    "addressRegion": "Gampaha",
    "postalCode": "110",
    "addressCountry": "Sri Lanka"
  },
  "openingHours": "Mo-Fr 08:00-18:00, Sa 08:00-14:00",
  "medicalSpecialty": ["Pathology", "Clinical Laboratory", "Diagnostic Testing"],
  "serviceType": ["Blood Testing", "Urine Analysis", "Diabetes Screening", "Health Diagnostics"],
  "hasOfferCatalog": {
    "@type": "OfferCatalog",
    "itemListElement": [
      {
        "@type": "ListItem",
        "position": 1,
        "name": "Login",
        "url": "{{ url('/Login') }}"
      },
      {
        "@type": "ListItem",
        "position": 2,
        "name": "Home",
        "url": "{{ url('/') }}"
      },
      {
        "@type": "ListItem",
        "position": 3,
        "name": "Privacy Policy",
        "url": "{{ url('/privacyPolicy') }}"
      }
    ]
  }
}
</script>

  @include('Home.components.cssJs.style')
  <style>
  h1 {
    font-size: 50px;
    line-height: 1.2;
    text-shadow: 1px 1px 0 white, -1px -1px 0 white, 1px -1px 0 white, -1px 1px 0 white;
  }

  @media (max-width: 600px) {
    h1 {
      font-size: 30px;
      line-height: 1.5;
    }
  }

    h2 {
    font-size: 40px;
    line-height: 1.2;
    text-shadow: 1px 1px 0 white, -1px -1px 0 white, 1px -1px 0 white, -1px 1px 0 white;
  }

  @media (max-width: 600px) {
    h2 {
      font-size: 30px;
      line-height: 1.5;
    }
  }

/* Hide scrollbar for Webkit browsers */
.scrollable-container::-webkit-scrollbar {
    display: none;
}

/* Card hover effects */
.card-item:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
    border-color: #1977cc;
}

.card-item:hover div {
    transform: scale(1.1);
}

/* Dot styles */
.dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background-color: #d0d0d0;
    cursor: pointer;
    transition: all 0.3s ease;
    border: none;
    padding: 0;
}

.dot.active {
    background-color: #1977cc;
    transform: scale(1.2);
}

.dot:hover {
    background-color: #1977cc;
    opacity: 0.7;
}

/* Smooth scrolling animation */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.card-item {
    animation: fadeIn 0.6s ease forwards;
}

/* Snow Effect Styles */
#winterSnowCanvas {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
    z-index: 9999;
}

#snowAccumulationBar {
    position: fixed;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 40px;
    pointer-events: none;
    z-index: 9998;
    background: linear-gradient(to top, rgba(255, 255, 255, 0.9), rgba(255, 255, 255, 0));
}

@keyframes snowflakeDrift {
    0%, 100% {
        transform: translateX(0);
    }
    50% {
        transform: translateX(20px);
    }
}






    /* Announcement Banner */
    .announcement-banner {
      background: linear-gradient(135deg, #1977cc 0%, #0d5fa6 100%);
      color: white;
      padding: 15px 20px;
      text-align: center;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
      position: relative;
      overflow: hidden;
      animation: slideDown 0.5s ease-out;
    }

    .announcement-banner::before {
      content: '';
      position: absolute;
      top: -50%;
      left: -50%;
      width: 200%;
      height: 200%;
      background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
      animation: pulse 3s ease-in-out infinite;
    }

    .announcement-content {
      position: relative;
      z-index: 1;
      max-width: 1200px;
      margin: 0 auto;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 15px;
      flex-wrap: wrap;
    }

    .announcement-icon {
      font-size: 24px;
      animation: bounce 2s infinite;
    }

    .announcement-text {
      font-size: 16px;
      font-weight: 500;
      line-height: 1.5;
    }

    .announcement-text strong {
      font-weight: 700;
      font-size: 18px;
    }

    .learn-more-btn {
      background: white;
      color: #1977cc;
      padding: 8px 20px;
      border-radius: 25px;
      text-decoration: none;
      font-weight: 600;
      transition: all 0.3s ease;
      display: inline-block;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
    }

    .learn-more-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
      background: #f8f9fa;
    }

    .close-banner {
      position: absolute;
      top: 10px;
      right: 15px;
      background: transparent;
      border: none;
      color: white;
      font-size: 24px;
      cursor: pointer;
      opacity: 0.7;
      transition: opacity 0.3s;
      z-index: 2;
    }

    .close-banner:hover {
      opacity: 1;
    }

    /* Partnership Section */
    .partnership-section {
      max-width: 1200px;
      margin: 40px auto;
      background: white;
      border-radius: 15px;
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
      overflow: hidden;
    }

    .partnership-header {
      background: linear-gradient(135deg, #1977cc 0%, #0d5fa6 100%);
      color: white;
      padding: 40px;
      text-align: center;
    }

    .partnership-header h2 {
      font-size: 36px;
      margin-bottom: 10px;
      font-weight: 700;
    }

    .partnership-date {
      font-size: 18px;
      opacity: 0.95;
      font-weight: 500;
    }

    .partnership-content {
      padding: 40px;
    }

    .partnership-intro {
      text-align: center;
      font-size: 18px;
      color: #333;
      line-height: 1.8;
      margin-bottom: 40px;
    }

    .partners-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 30px;
      margin-bottom: 40px;
    }

    .partner-card {
      background: #f8f9fa;
      padding: 30px;
      border-radius: 12px;
      border: 2px solid #e9ecef;
      transition: all 0.3s ease;
    }

    .partner-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
      border-color: #1977cc;
    }

    .partner-card h3 {
      color: #1977cc;
      font-size: 24px;
      margin-bottom: 15px;
      font-weight: 700;
    }

    .partner-card p {
      color: #555;
      line-height: 1.7;
      font-size: 15px;
    }

    .benefits-section {
      background: linear-gradient(to right, #f8f9fa, #e9ecef);
      padding: 30px;
      border-radius: 12px;
      margin-top: 30px;
    }

    .benefits-section h3 {
      color: #1977cc;
      font-size: 28px;
      margin-bottom: 25px;
      text-align: center;
      font-weight: 700;
    }

    .benefits-list {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 20px;
    }

    .benefit-item {
      background: white;
      padding: 20px;
      border-radius: 10px;
      border-left: 4px solid #1977cc;
      transition: all 0.3s ease;
    }

    .benefit-item:hover {
      transform: translateX(5px);
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .benefit-item h4 {
      color: #333;
      font-size: 18px;
      margin-bottom: 10px;
      font-weight: 600;
    }

    .benefit-item p {
      color: #666;
      line-height: 1.6;
      font-size: 14px;
    }

    @keyframes slideDown {
      from {
        transform: translateY(-100%);
        opacity: 0;
      }
      to {
        transform: translateY(0);
        opacity: 1;
      }
    }

    @keyframes bounce {
      0%, 100% {
        transform: translateY(0);
      }
      50% {
        transform: translateY(-10px);
      }
    }

    @keyframes pulse {
      0%, 100% {
        opacity: 0.3;
      }
      50% {
        opacity: 0.5;
      }
    }

    @media (max-width: 768px) {
      .announcement-banner {
        padding: 12px 15px;
      }

      .announcement-text {
        font-size: 14px;
      }

      .announcement-text strong {
        font-size: 16px;
      }

      .partnership-header h2 {
        font-size: 28px;
      }

      .partnership-content {
        padding: 25px;
      }

      .partners-grid {
        grid-template-columns: 1fr;
      }
    }

</style>
</head>
<body>


  <!-- Snow Canvas -->
  <canvas id="winterSnowCanvas"></canvas>
  <div id="snowAccumulationBar"></div>

  <!-- ======= Header ======= -->
  @include('Home.components.header')

  <main id="main">
    @include('Home.components.intro')
    <!-- Detailed Partnership Section -->
  <div class="partnership-section" id="partnership-details">
    <br><br>
    <div class="partnership-header">
      <h2>🤝 A New Era in Diagnostic Excellence</h2>
      <p class="partnership-date">Partnership Effective: December 1st, 2025</p>
    </div>

    <div class="partnership-content">
      <p class="partnership-intro">
        We're thrilled to announce a transformative collaboration between Horizon Laboratory and Neuberg Diagnostics,
        bringing world-class diagnostic capabilities to Sri Lanka with global quality and local accessibility.
      </p>

      <div class="partners-grid">
        <div class="partner-card">
          <h3>🔬 Horizon Laboratory</h3>
          <p>
            Your trusted local partner committed to "Testing Today, Healthier Tomorrow."
            With comprehensive pathology services including chemical pathology, hematology,
            and flow cytometry, we've built our reputation on precision, compassion, and
            advanced technology.
          </p>
        </div>

        <div class="partner-card">
          <h3>🌍 Neuberg Diagnostics</h3>
          <p>
            A global diagnostic consortium spanning India, Sri Lanka, South Africa, and the UAE.
            With over two centuries of combined expertise, Neuberg leads the movement toward
            early, accurate diagnosis through cutting-edge genomics, proteomics, and molecular testing.
          </p>
        </div>
      </div>

      <div class="benefits-section">
        <h3>What This Means For You</h3>
        <div class="benefits-list">
          <div class="benefit-item">
            <h4>🎯 Enhanced Diagnostic Capabilities</h4>
            <p>Access to expanded test portfolios with improved turnaround times and accuracy through Neuberg's world-class reference lab network.</p>
          </div>

          <div class="benefit-item">
            <h4>🌟 Global Quality, Local Access</h4>
            <p>International standards of diagnostics right here in Sri Lanka - no need to travel abroad for advanced testing.</p>
          </div>

          <div class="benefit-item">
            <h4>🔬 Advanced Testing Options</h4>
            <p>New avenues for molecular biology, digital pathology, and genomics - bringing next-generation diagnostics to your doorstep.</p>
          </div>

          <div class="benefit-item">
            <h4>💰 Affordable Excellence</h4>
            <p>Committed to making advanced diagnostics accessible and affordable, consistent with Neuberg's founding vision.</p>
          </div>

          <div class="benefit-item">
            <h4>👨‍⚕️ Better Healthcare Decisions</h4>
            <p>Empowering doctors and clinicians with deeper diagnostic insights for more informed clinical decision-making.</p>
          </div>

          <div class="benefit-item">
            <h4>🚀 Continuous Innovation</h4>
            <p>A seamless continuum of care from routine health checks to the most specialized testing available.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  @include('Home.components.footer')
  <!-- End Footer -->

  <div id="preloader"></div>
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  @include('Home.components.cssJs.js')
</body>
</html>

<script>
// Card scrolling functionality
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('cardsContainer');
    const dotsContainer = document.getElementById('dotsContainer');
    const cards = document.querySelectorAll('.card-item');

    if (!container || !dotsContainer || cards.length === 0) return;

    const containerWidth = container.clientWidth;
    const cardWidth = 280 + 20;
    const visibleCards = Math.floor(containerWidth / cardWidth);
    const totalDots = Math.max(1, cards.length - visibleCards + 1);

    for (let i = 0; i < totalDots; i++) {
        const dot = document.createElement('button');
        dot.className = 'dot';
        dot.setAttribute('data-index', i);
        if (i === 0) dot.classList.add('active');

        dot.addEventListener('click', function() {
            const index = parseInt(this.getAttribute('data-index'));
            const scrollPosition = index * cardWidth;
            container.scrollTo({
                left: scrollPosition,
                behavior: 'smooth'
            });
        });

        dotsContainer.appendChild(dot);
    }

    container.addEventListener('scroll', function() {
        const scrollLeft = container.scrollLeft;
        const activeIndex = Math.round(scrollLeft / cardWidth);

        document.querySelectorAll('.dot').forEach((dot, index) => {
            if (index === activeIndex) {
                dot.classList.add('active');
            } else {
                dot.classList.remove('active');
            }
        });
    });

    let isDown = false;
    let startX;
    let scrollLeftStart;

    container.addEventListener('mousedown', (e) => {
        isDown = true;
        startX = e.pageX - container.offsetLeft;
        scrollLeftStart = container.scrollLeft;
        container.style.cursor = 'grabbing';
    });

    container.addEventListener('mouseleave', () => {
        isDown = false;
        container.style.cursor = 'grab';
    });

    container.addEventListener('mouseup', () => {
        isDown = false;
        container.style.cursor = 'grab';
    });

    container.addEventListener('mousemove', (e) => {
        if (!isDown) return;
        e.preventDefault();
        const x = e.pageX - container.offsetLeft;
        const walk = (x - startX) * 2;
        container.scrollLeft = scrollLeftStart - walk;
    });
});

// Realistic Snow Effect with Accumulation
(function() {
    // --- DATE CHECK LOGIC ---
    function shouldShowSnow() {
        const now = new Date();
        const month = now.getMonth(); // 0 = Jan, 10 = Nov, 11 = Dec
        const date = now.getDate();

        // 1. Check for January (Up to Jan 7th)
        const isEarlyJanuary = (month === 0 && date <= 7);

        // 2. Check for December (All month)
        const isDecember = (month === 11);

        // 3. Check for November (Last week, starting Nov 24th)
        const isLateNovember = (month === 10 && date >= 24);

        return isEarlyJanuary || isDecember || isLateNovember;
    }

    // If it's not the right time of year, stop here and hide the canvas
    const snowfallCanvas = document.getElementById('winterSnowCanvas');
    const snowBar = document.getElementById('snowAccumulationBar');

    if (!shouldShowSnow()) {
        if (snowfallCanvas) snowfallCanvas.style.display = 'none';
        if (snowBar) snowBar.style.display = 'none';
        return;
    }
    // --- END DATE CHECK LOGIC ---

    const snowfallContext = snowfallCanvas.getContext('2d');
    let canvasWidthSnow = window.innerWidth;
    let canvasHeightSnow = window.innerHeight;

    snowfallCanvas.width = canvasWidthSnow;
    snowfallCanvas.height = canvasHeightSnow;

    const snowflakeParticles = [];
    const totalSnowflakes = 30;
    const accumulatedSnowPile = [];
    const maxAccumulatedSnow = 100;
    const accumulationZoneHeight = 40;

    function SnowflakeEntity() {
        this.xPositionSnow = Math.random() * canvasWidthSnow;
        this.yPositionSnow = Math.random() * canvasHeightSnow;
        this.radiusSizeSnow = Math.random() * 3 + 1;
        this.velocityYSnow = Math.random() * 1 + 0.5;
        this.velocityXSnow = Math.random() * 0.5 - 0.25;
        this.opacitySnow = Math.random() * 0.6 + 0.4;
        this.swingAmplitude = Math.random() * 0.5 + 0.2;
        this.swingPhase = Math.random() * Math.PI * 2;
    }

    function AccumulatedSnowEntity(xPos, yPos, radius, opacity) {
        this.xPosAccum = xPos;
        this.yPosAccum = yPos;
        this.radiusAccum = radius;
        this.opacityAccum = opacity;
        this.lifetimeAccum = 3000 + Math.random() * 2000;
        this.creationTimeAccum = Date.now();
    }

    SnowflakeEntity.prototype.updatePositionSnow = function() {
        this.yPositionSnow += this.velocityYSnow;
        this.swingPhase += 0.01;
        this.xPositionSnow += Math.sin(this.swingPhase) * this.swingAmplitude;

        if (this.yPositionSnow > canvasHeightSnow - accumulationZoneHeight) {
            if (accumulatedSnowPile.length < maxAccumulatedSnow) {
                accumulatedSnowPile.push(new AccumulatedSnowEntity(
                    this.xPositionSnow,
                    canvasHeightSnow - Math.random() * accumulationZoneHeight,
                    this.radiusSizeSnow,
                    this.opacitySnow
                ));
            }
            this.yPositionSnow = -10;
            this.xPositionSnow = Math.random() * canvasWidthSnow;
        }

        if (this.xPositionSnow > canvasWidthSnow) this.xPositionSnow = 0;
        else if (this.xPositionSnow < 0) this.xPositionSnow = canvasWidthSnow;
    };

    SnowflakeEntity.prototype.renderSnowflake = function() {
        snowfallContext.beginPath();
        snowfallContext.arc(this.xPositionSnow, this.yPositionSnow, this.radiusSizeSnow, 0, Math.PI * 2);
        snowfallContext.fillStyle = `rgba(255, 255, 255, ${this.opacitySnow})`;
        snowfallContext.fill();
    };

    function updateAccumulatedSnow() {
        const currentTimeStamp = Date.now();
        for (let i = accumulatedSnowPile.length - 1; i >= 0; i--) {
            const snowPiece = accumulatedSnowPile[i];
            const ageOfSnow = currentTimeStamp - snowPiece.creationTimeAccum;

            if (ageOfSnow > snowPiece.lifetimeAccum) {
                const fadeProgress = (ageOfSnow - snowPiece.lifetimeAccum) / 1000;
                snowPiece.opacityAccum = Math.max(0, snowPiece.opacityAccum - fadeProgress * 0.1);
                if (snowPiece.opacityAccum <= 0) {
                    accumulatedSnowPile.splice(i, 1);
                    continue;
                }
            }

            snowfallContext.beginPath();
            snowfallContext.arc(snowPiece.xPosAccum, snowPiece.yPosAccum, snowPiece.radiusAccum, 0, Math.PI * 2);
            snowfallContext.fillStyle = `rgba(255, 255, 255, ${snowPiece.opacityAccum})`;
            snowfallContext.fill();
        }
    }

    function animateSnowfall() {
        snowfallContext.clearRect(0, 0, canvasWidthSnow, canvasHeightSnow);
        for (let idx = 0; idx < snowflakeParticles.length; idx++) {
            snowflakeParticles[idx].updatePositionSnow();
            snowflakeParticles[idx].renderSnowflake();
        }
        updateAccumulatedSnow();
        requestAnimationFrame(animateSnowfall);
    }

    window.addEventListener('resize', function() {
        canvasWidthSnow = window.innerWidth;
        canvasHeightSnow = window.innerHeight;
        snowfallCanvas.width = canvasWidthSnow;
        snowfallCanvas.height = canvasHeightSnow;
    });

    // Initialize only if date check passed
    for (let idx = 0; idx < totalSnowflakes; idx++) {
        snowflakeParticles.push(new SnowflakeEntity());
    }
    animateSnowfall();
})();
</script>

  <script>
    function closeBanner() {
      const banner = document.getElementById('announcementBanner');
      banner.style.animation = 'slideDown 0.3s ease-out reverse';
      setTimeout(() => {
        banner.style.display = 'none';
      }, 300);
    }

    // Smooth scroll to partnership details
    document.querySelector('.learn-more-btn').addEventListener('click', function(e) {
      e.preventDefault();
      document.getElementById('partnership-details').scrollIntoView({
        behavior: 'smooth',
        block: 'start'
      });
    });
  </script>
