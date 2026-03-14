<!doctype html>
<html lang="en">
  <head>
    <style>
      :root {
    --rose-gold: #CFA46A; /* your logo color */
}

.instagram-btn,
.whatsapp-btn {
    position: fixed;
    right: 20px;
    width: 55px;
    height: 55px;
    border-radius: 50%;
    background: #ffffff;
    /*border: 1.5px solid #b76e79;  Soft rose gold border */
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
    cursor: pointer;
    transition: all 0.35s ease;
    box-shadow: var(--rose-gold); /* Soft rose gold shadow */
}

.instagram-btn { bottom: 110px; }
.whatsapp-btn { bottom: 45px; }

/* ICON COLOR */
.instagram-btn i,
.whatsapp-btn i {
    color: #b76e79;       /* Rose gold */
    font-size: 23px;
    transition: 0.35s ease;
}

/* HOVER EFFECT */
.instagram-btn:hover,
.whatsapp-btn:hover {
            /* Rose gold background */
    border-color: #b76e79;
    box-shadow: 0px 6px 18px rgba(183, 110, 121, 0.45);
    transform: translateY(-4px); /* Subtle lift */
}

/* ICON stays white on hover */
.instagram-btn:hover i,
.whatsapp-btn:hover i {
    color: #ffffff;
}

    </style>
  </head>
<body>
<?php include ('layouts/header.php');?>
<main>
    <div class="container">
      <section class="page-intro text-center">
        <h1>Gallery</h1>
        <p class="muted">A curated selection of our recent works — click to view larger. Browse by category below.</p>
      </section>

      <!-- Category filter buttons -->
      <div class="category-filters d-flex flex-wrap justify-content-center" role="tablist" aria-label="Gallery categories">
        <button class="category-filter-btn active" data-target="#bridal" aria-pressed="true">Bridal</button>
        <button class="category-filter-btn" data-target="#makeup" aria-pressed="false">Makeup</button>
        <button class="category-filter-btn" data-target="#mehendi" aria-pressed="false">Mehendi</button>
        <button class="category-filter-btn" data-target="#hairstyling" aria-pressed="false">Hairstyling</button>
        <button class="category-filter-btn" data-target="#nail-art" aria-pressed="false">Nail Art</button>
      </div>
    </div>

    <!-- Gallery categories: each category shows 10 images (placeholders / paths). Add actual images to the corresponding folders in assets/images/ -->

    <div class="container">
      <section class="gallery-category" id="bridal">
        <h2 class="gallery-title text-center mb-3">Bridal</h2>
        <p class="muted text-center mb-4">Complete bridal looks</p>
        <div class="row g-4">
          <div class="col-6 col-sm-6 col-md-6 col-lg-4 col-xl-3">
            <button class="gallery-item" data-src="assets/images/bridal/b10.jpg"><img src="assets/images/bridal/b10.jpg" alt="Bridal 10" loading="lazy"></button>
          </div>
          <div class="col-6 col-sm-6 col-md-6 col-lg-4 col-xl-3">
            <button class="gallery-item" data-src="assets/images/bridal/b11.jpg"><img src="assets/images/bridal/b11.jpg" alt="Bridal 1" loading="lazy"></button>
          </div>
          <div class="col-6 col-sm-6 col-md-6 col-lg-4 col-xl-3">
            <button class="gallery-item" data-src="assets/images/bridal/b12.jpg"><img src="assets/images/bridal/b12.jpg" alt="Bridal 2" loading="lazy"></button>
          </div>
          <div class="col-6 col-sm-6 col-md-6 col-lg-4 col-xl-3">
            <button class="gallery-item" data-src="assets/images/bridal/b7.jpg"><img src="assets/images/bridal/b7.jpg" alt="Bridal 7" loading="lazy"></button>
          </div>
          <div class="col-6 col-sm-6 col-md-6 col-lg-4 col-xl-3">
            <button class="gallery-item" data-src="assets/images/bridal/b8.jpg"><img src="assets/images/bridal/b8.jpg" alt="Bridal 8" loading="lazy"></button>
          </div>
          <div class="col-6 col-sm-6 col-md-6 col-lg-4 col-xl-3">
            <button class="gallery-item" data-src="assets/images/bridal/b9.jpg"><img src="assets/images/bridal/b9.jpg" alt="Bridal 9" loading="lazy"></button>
          </div>
          <div class="col-6 col-sm-6 col-md-6 col-lg-4 col-xl-3">
            <button class="gallery-item" data-src="assets/images/bridal/b1.jpg"><img src="assets/images/bridal/b1.jpg" alt="Bridal 1" loading="lazy"></button>
          </div>
          <div class="col-6 col-sm-6 col-md-6 col-lg-4 col-xl-3">
            <button class="gallery-item" data-src="assets/images/bridal/b2.jpg"><img src="assets/images/bridal/b2.jpg" alt="Bridal 2" loading="lazy"></button>
          </div>
          <div class="col-6 col-sm-6 col-md-6 col-lg-4 col-xl-3">
            <button class="gallery-item" data-src="assets/images/bridal/b3.jpg"><img src="assets/images/bridal/b3.jpg" alt="Bridal 3" loading="lazy"></button>
          </div>
          <div class="col-6 col-sm-6 col-md-6 col-lg-4 col-xl-3">
            <button class="gallery-item" data-src="assets/images/bridal/b4.jpg"><img src="assets/images/bridal/b4.jpg" alt="Bridal 4" loading="lazy"></button>
          </div>
          <div class="col-6 col-sm-6 col-md-6 col-lg-4 col-xl-3">
            <button class="gallery-item" data-src="assets/images/bridal/b5.jpg"><img src="assets/images/bridal/b5.jpg" alt="Bridal 5" loading="lazy"></button>
          </div>
          <div class="col-6 col-sm-6 col-md-6 col-lg-4 col-xl-3">
            <button class="gallery-item" data-src="assets/images/bridal/b6.jpg"><img src="assets/images/bridal/b6.jpg" alt="Bridal 6" loading="lazy"></button>
          </div>
        </div>
      </section>
    </div>

    <div class="container">
      <section class="gallery-category" id="makeup">
        <h2 class="gallery-title text-center mb-3">Makeup</h2>
        <p class="muted text-center mb-4">Different makeup styles and events</p>
        <div class="row g-4">
          <div class="col-6 col-sm-6 col-md-6 col-lg-4 col-xl-3">
            <button class="gallery-item" data-src="assets/images/makeup/makeup1.jpg"><img src="assets/images/makeup/makeup1.jpg" alt="Makeup 1" loading="lazy"></button>
          </div>
          <div class="col-6 col-sm-6 col-md-6 col-lg-4 col-xl-3">
            <button class="gallery-item" data-src="assets/images/makeup/makeup2.jpg"><img src="assets/images/makeup/makeup2.jpg" alt="Makeup 2" loading="lazy"></button>
          </div>
          <div class="col-6 col-sm-6 col-md-6 col-lg-4 col-xl-3">
            <button class="gallery-item" data-src="assets/images/makeup/makeup3.jpg"><img src="assets/images/makeup/makeup3.jpg" alt="Makeup 3" loading="lazy"></button>
          </div>
          <div class="col-6 col-sm-6 col-md-6 col-lg-4 col-xl-3">
            <button class="gallery-item" data-src="assets/images/makeup/makeup4.jpg"><img src="assets/images/makeup/makeup4.jpg" alt="Makeup 4" loading="lazy"></button>
          </div>
          <div class="col-6 col-sm-6 col-md-6 col-lg-4 col-xl-3">
            <button class="gallery-item" data-src="assets/images/makeup/makeup5.jpg"><img src="assets/images/makeup/makeup5.jpg" alt="Makeup 5" loading="lazy"></button>
          </div>
          <div class="col-6 col-sm-6 col-md-6 col-lg-4 col-xl-3">
            <button class="gallery-item" data-src="assets/images/makeup/makeup6.jpg"><img src="assets/images/makeup/makeup6.jpg" alt="Makeup 6" loading="lazy"></button>
          </div>
          <div class="col-6 col-sm-6 col-md-6 col-lg-4 col-xl-3">
            <button class="gallery-item" data-src="assets/images/makeup/makeup7.jpg"><img src="assets/images/makeup/makeup7.jpg" alt="Makeup 7" loading="lazy"></button>
          </div>
          <div class="col-6 col-sm-6 col-md-6 col-lg-4 col-xl-3">
            <button class="gallery-item" data-src="assets/images/makeup/makeup8.jpg"><img src="assets/images/makeup/makeup8.jpg" alt="Makeup 8" loading="lazy"></button>
          </div>
          <div class="col-6 col-sm-6 col-md-6 col-lg-4 col-xl-3">
            <button class="gallery-item" data-src="assets/images/makeup/makeup9.jpg"><img src="assets/images/makeup/makeup9.jpg" alt="Makeup 9" loading="lazy"></button>
          </div>
          <div class="col-6 col-sm-6 col-md-6 col-lg-4 col-xl-3">
            <button class="gallery-item" data-src="assets/images/makeup/makeup10.jpg"><img src="assets/images/makeup/makeup10.jpg" alt="Makeup 10" loading="lazy"></button>
          </div>
        </div>
      </section>
    </div>

    <div class="container">
      <section class="gallery-category" id="nail-art">
        <h2 class="gallery-title text-center mb-3">Nail Art</h2>
        <p class="muted text-center mb-4">Creative and trendy nail designs</p>
        <div class="row g-4">
          <div class="col-6 col-sm-6 col-md-6 col-lg-4 col-xl-3">
            <button class="gallery-item" data-src="assets/images/nailart/n1.jpg"><img src="assets/images/nailart/n1.jpg" alt="Nail Art 1" loading="lazy"></button>
          </div>
          <div class="col-6 col-sm-6 col-md-6 col-lg-4 col-xl-3">
            <button class="gallery-item" data-src="assets/images/nailart/n2.jpg"><img src="assets/images/nailart/n2.jpg" alt="Nail Art 2" loading="lazy"></button>
          </div>
          <div class="col-6 col-sm-6 col-md-6 col-lg-4 col-xl-3">
            <button class="gallery-item" data-src="assets/images/nailart/n3.jpg"><img src="assets/images/nailart/n3.jpg" alt="Nail Art 3" loading="lazy"></button>
          </div>
          <div class="col-6 col-sm-6 col-md-6 col-lg-4 col-xl-3">
            <button class="gallery-item" data-src="assets/images/nailart/n4.jpg"><img src="assets/images/nailart/n4.jpg" alt="Nail Art 4" loading="lazy"></button>
          </div>
          <div class="col-6 col-sm-6 col-md-6 col-lg-4 col-xl-3">
            <button class="gallery-item" data-src="assets/images/nailart/n5.jpg"><img src="assets/images/nailart/n5.jpg" alt="Nail Art 5" loading="lazy"></button>
          </div>
          <div class="col-6 col-sm-6 col-md-6 col-lg-4 col-xl-3">
            <button class="gallery-item" data-src="assets/images/nailart/n6.jpg"><img src="assets/images/nailart/n6.jpg" alt="Nail Art 6" loading="lazy"></button>
          </div>
          <div class="col-6 col-sm-6 col-md-6 col-lg-4 col-xl-3">
            <button class="gallery-item" data-src="assets/images/nailart/n7.jpg"><img src="assets/images/nailart/n7.jpg" alt="Nail Art 7" loading="lazy"></button>
          </div>
          <div class="col-6 col-sm-6 col-md-6 col-lg-4 col-xl-3">
            <button class="gallery-item" data-src="assets/images/nailart/n8.jpg"><img src="assets/images/nailart/n8.jpg" alt="Nail Art 8" loading="lazy"></button>
          </div>
          <div class="col-6 col-sm-6 col-md-6 col-lg-4 col-xl-3">
            <button class="gallery-item" data-src="assets/images/nailart/n9.jpg"><img src="assets/images/nailart/n9.jpg" alt="Nail Art 9" loading="lazy"></button>
          </div>
          <div class="col-6 col-sm-6 col-md-6 col-lg-4 col-xl-3">
            <button class="gallery-item" data-src="assets/images/nailart/n10.jpg"><img src="assets/images/nailart/n10.jpg" alt="Nail Art 10" loading="lazy"></button>
          </div>
        </div>
      </section>
    </div>

    <div class="container">
      <section class="gallery-category" id="hairstyling">
        <h2 class="gallery-title text-center mb-3">Hairstyling</h2>
        <p class="muted text-center mb-4">Various hairstyles (bridal, party, casual)</p>
        <div class="row g-4">
          <div class="col-6 col-sm-6 col-md-6 col-lg-4 col-xl-3">
            <button class="gallery-item" data-src="assets/images/hairstyling/h1.jpg"><img src="assets/images/hairstyling/h1.jpg" alt="Hairstyling 1" loading="lazy"></button>
          </div>
          <div class="col-6 col-sm-6 col-md-6 col-lg-4 col-xl-3">
            <button class="gallery-item" data-src="assets/images/hairstyling/h2.jpg"><img src="assets/images/hairstyling/h2.jpg" alt="Hairstyling 2" loading="lazy"></button>
          </div>
          <div class="col-6 col-sm-6 col-md-6 col-lg-4 col-xl-3">
            <button class="gallery-item" data-src="assets/images/hairstyling/h3.jpg"><img src="assets/images/hairstyling/h3.jpg" alt="Hairstyling 3" loading="lazy"></button>
          </div>
          <div class="col-6 col-sm-6 col-md-6 col-lg-4 col-xl-3">
            <button class="gallery-item" data-src="assets/images/hairstyling/h4.jpg"><img src="assets/images/hairstyling/h4.jpg" alt="Hairstyling 4" loading="lazy"></button>
          </div>
          <div class="col-6 col-sm-6 col-md-6 col-lg-4 col-xl-3">
            <button class="gallery-item" data-src="assets/images/hairstyling/h5.jpg"><img src="assets/images/hairstyling/h5.jpg" alt="Hairstyling 5" loading="lazy"></button>
          </div>
          <div class="col-6 col-sm-6 col-md-6 col-lg-4 col-xl-3">
            <button class="gallery-item" data-src="assets/images/hairstyling/h6.jpg"><img src="assets/images/hairstyling/h6.jpg" alt="Hairstyling 6" loading="lazy"></button>
          </div>
          <div class="col-6 col-sm-6 col-md-6 col-lg-4 col-xl-3">
            <button class="gallery-item" data-src="assets/images/hairstyling/h7.jpg"><img src="assets/images/hairstyling/h7.jpg" alt="Hairstyling 7" loading="lazy"></button>
          </div>
          <div class="col-6 col-sm-6 col-md-6 col-lg-4 col-xl-3">
            <button class="gallery-item" data-src="assets/images/hairstyling/h8.jpg"><img src="assets/images/hairstyling/h8.jpg" alt="Hairstyling 8" loading="lazy"></button>
          </div>
          <div class="col-6 col-sm-6 col-md-6 col-lg-4 col-xl-3">
            <button class="gallery-item" data-src="assets/images/hairstyling/h9.jpg"><img src="assets/images/hairstyling/h9.jpg" alt="Hairstyling 9" loading="lazy"></button>
          </div>
          <div class="col-6 col-sm-6 col-md-6 col-lg-4 col-xl-3">
            <button class="gallery-item" data-src="assets/images/hairstyling/h10.jpg"><img src="assets/images/hairstyling/h10.jpg" alt="Hairstyling 10" loading="lazy"></button>
          </div>
          <div class="col-6 col-sm-6 col-md-6 col-lg-4 col-xl-3">
            <button class="gallery-item" data-src="assets/images/hairstyling/h11.jpg"><img src="assets/images/hairstyling/h11.jpg" alt="Hairstyling 11" loading="lazy"></button>
          </div>
          <div class="col-6 col-sm-6 col-md-6 col-lg-4 col-xl-3">
            <button class="gallery-item" data-src="assets/images/hairstyling/h12.jpg"><img src="assets/images/hairstyling/h12.jpg" alt="Hairstyling 12" loading="lazy"></button>
          </div>
        </div>
      </section>
    </div>

    <div class="container">
      <section class="gallery-category" id="mehendi">
        <h2 class="gallery-title text-center mb-3">Mehendi</h2>
        <p class="muted text-center mb-4">Traditional and modern mehendi designs with names</p>
        <div class="row g-4">
          <div class="col-6 col-sm-6 col-md-6 col-lg-4 col-xl-3">
            <button class="gallery-item" data-src="assets/images/mehendi/m1.jpg"><img src="assets/images/mehendi/m1.jpg" alt="Mehendi 1" loading="lazy"></button>
          </div>
          <div class="col-6 col-sm-6 col-md-6 col-lg-4 col-xl-3">
            <button class="gallery-item" data-src="assets/images/mehendi/m2.jpg"><img src="assets/images/mehendi/m2.jpg" alt="Mehendi 2" loading="lazy"></button>
          </div>
          <div class="col-6 col-sm-6 col-md-6 col-lg-4 col-xl-3">
            <button class="gallery-item" data-src="assets/images/mehendi/m3.jpg"><img src="assets/images/mehendi/m3.jpg" alt="Mehendi 3" loading="lazy"></button>
          </div>
          <div class="col-6 col-sm-6 col-md-6 col-lg-4 col-xl-3">
            <button class="gallery-item" data-src="assets/images/mehendi/m4.jpg"><img src="assets/images/mehendi/m4.jpg" alt="Mehendi 4" loading="lazy"></button>
          </div>
          <div class="col-6 col-sm-6 col-md-6 col-lg-4 col-xl-3">
            <button class="gallery-item" data-src="assets/images/mehendi/m5.jpg"><img src="assets/images/mehendi/m5.jpg" alt="Mehendi 5" loading="lazy"></button>
          </div>
          <div class="col-6 col-sm-6 col-md-6 col-lg-4 col-xl-3">
            <button class="gallery-item" data-src="assets/images/mehendi/m6.jpg"><img src="assets/images/mehendi/m6.jpg" alt="Mehendi 6" loading="lazy"></button>
          </div>
          <div class="col-6 col-sm-6 col-md-6 col-lg-4 col-xl-3">
            <button class="gallery-item" data-src="assets/images/mehendi/m7.jpg"><img src="assets/images/mehendi/m7.jpg" alt="Mehendi 7" loading="lazy"></button>
          </div>
          <div class="col-6 col-sm-6 col-md-6 col-lg-4 col-xl-3">
            <button class="gallery-item" data-src="assets/images/mehendi/m8.jpg"><img src="assets/images/mehendi/m8.jpg" alt="Mehendi 8" loading="lazy"></button>
          </div>
          <div class="col-6 col-sm-6 col-md-6 col-lg-4 col-xl-3">
            <button class="gallery-item" data-src="assets/images/mehendi/m9.jpg"><img src="assets/images/mehendi/m9.jpg" alt="Mehendi 9" loading="lazy"></button>
          </div>
          <div class="col-6 col-sm-6 col-md-6 col-lg-4 col-xl-3">
            <button class="gallery-item" data-src="assets/images/mehendi/m10.jpg"><img src="assets/images/mehendi/m10.jpg" alt="Mehendi 10" loading="lazy" class="img-fluid"></button>
          </div>
        </div>
      </section>
    </div>
    <div class="container">
      <div id="lightbox" class="lightbox" aria-hidden="true">
        <button class="lightbox-close" aria-label="Close">✕</button>
        <img src="" alt="Expanded gallery image">
      </div>
    </div>

  </main>

<?php include ('layouts/footer.php');?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<a href="https://instagram.com/shreyasiyer96" target="_blank" class="instagram-btn d-flex align-items-center justify-content-center">
    <i class="bi bi-instagram"></i>
</a>

<a href="https://wa.me/9879020573" target="_blank" class="whatsapp-btn d-flex align-items-center justify-content-center">
    <i class="bi bi-whatsapp"></i>
</a>

</body>
</html>
