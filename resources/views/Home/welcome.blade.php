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

  // Add ItemList for categories
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
      font-size: 30px; /* Reduce font size for smaller screens */
      line-height: 1.5; /* Increase line height for better readability */
    }
  }

    h2 {
    font-size: 40px;
    line-height: 1.2;
    text-shadow: 1px 1px 0 white, -1px -1px 0 white, 1px -1px 0 white, -1px 1px 0 white;
  }

  @media (max-width: 600px) {
    h2 {
      font-size: 30px; /* Reduce font size for smaller screens */
      line-height: 1.5; /* Increase line height for better readability */
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
</style>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('cardsContainer');
    const dotsContainer = document.getElementById('dotsContainer');
    const cards = document.querySelectorAll('.card-item');

    if (!container || !dotsContainer || cards.length === 0) return;

    // Calculate how many cards are visible at once
    const containerWidth = container.clientWidth;
    const cardWidth = 280 + 20; // card width + gap
    const visibleCards = Math.floor(containerWidth / cardWidth);
    const totalDots = Math.max(1, cards.length - visibleCards + 1);

    // Create dots
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

    // Update active dot on scroll
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

    // Touch/swipe support for mobile
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
</script>
