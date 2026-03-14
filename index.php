<?php
include ('./conn.php');

// Get visitor IP
$ip = $_SERVER['REMOTE_ADDR'];

// Insert into table
$conn->query("INSERT INTO tbl_impressions (ip) VALUES ('$ip')");
$impressionsQuery = $conn->query("SELECT COUNT(*) AS total FROM tbl_impressions");
$impressions = $impressionsQuery->fetch_assoc()['total'];


?>


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
    width: 50px;
    height: 50px;
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
.whatsapp-btn { bottom: 40px; }

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
<?php
  include ('layouts/header.php');
?>
  <main>
    <section class="hero">
      <div class="container">
        <div class="row hero-inner align-items-center">
          <div class="col-lg-6 col-12 hero-content mb-4 mb-lg-0 text-center text-lg-start order-2 order-lg-1">
            <h1 class="hero-title">Where Beauty Meets Art</h1>
            <p class="hero-sub">Experience luxury beauty services crafted for your special moments. Bridal makeup, bespoke nail art, intricate mehendi, and more.</p>
            <div class="hero-cta">
              <a href="services.php" class="btn btn-primary">Explore Services</a>
            </div>
          </div>
          <div class="col-lg-6 col-12 hero-image text-center order-1 order-lg-2 mb-4 mb-lg-0">
            <img src="assets/images/bridal/br1.jpg" alt="Bridal beauty portrait" loading="lazy" class="img-fluid">
          </div>
        </div>
      </div>
    </section>

    <section class="featured">
      <div class="container">
        <h2 class="section-title text-center">Featured Services</h2>
        <p class="section-sub text-center">Luxury treatments designed to make you look and feel your best.</p>
        <div class="row services-grid g-4">
          <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="service-card h-100">
              <img src="assets/images/bridal/bridal10.jpg" alt="Bridal and event makeup application" loading="lazy" class="img-fluid">
              <div class="p-3">
                <h3>Bridal & Event Makeup</h3>
                <p>Personalized looks using premium products for long-lasting, camera-ready finishes.</p>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="service-card h-100">
              <img src="assets/images/nailart/n.jpg" alt="Luxury nail art and manicure" loading="lazy" class="img-fluid">
              <div class="p-3">
                <h3>Luxury Nail Art</h3>
                <p>Hand-painted designs, gel manicures and nail extensions with a couture touch.</p>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-12 col-sm-12">
            <div class="service-card h-100">
              <img src="assets/images/mehendi/m.jpg" alt="Intricate mehendi design" loading="lazy" class="img-fluid">
              <div class="p-3">
                <h3>Mehendi & Henna</h3>
                <p>Intricate bridal mehendi and contemporary henna art for all celebrations.</p>
              </div>
            </div>
          </div>
        </div>
        <div class="text-center mt-4"><a href="services.php" class="btn btn-rose">View All Services</a></div>
      </div>
    </section>

    <section class="about-preview">
      <div class="container">
        <div class="row about-card align-items-center g-4">
          <div class="col-lg-6 col-12 text-center order-1 order-lg-1">
            <img src="assets/images/s1.jpg" alt="Salon interior" loading="lazy" class="img-fluid studio-image">
          </div>
          <div class="col-lg-6 col-12 order-2 order-lg-2">
            <h2>Our Studio</h2>
            <p>GlamAura is a boutique beauty studio where elegance and comfort meet expert artistry. We prioritize hygiene, professionalism and a tailored client experience.</p>
            <div class="d-flex flex-wrap gap-2">
              <a href="about.php" class="btn btn-rose">Learn more about us →</a>
              <a href="user_branch.php" class="btn btn-rose">Our Branch</a>
            </div>
          </div>
        </div>
      </div>
    </section>

  </main>

<?php
  include ('layouts/footer.php');
?>
<!-- Floating Icons (Place them here OUTSIDE footer) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<a href="https://instagram.com/shreyasiyer96" target="_blank" class="instagram-btn d-flex align-items-center justify-content-center">
    <i class="bi bi-instagram"></i>
</a>

<a href="https://wa.me/9879020573" target="_blank" class="whatsapp-btn d-flex align-items-center justify-content-center">
    <i class="bi bi-whatsapp"></i>
</a>

</body>
</html>