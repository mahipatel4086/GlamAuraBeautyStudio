<?php
include 'conn.php';
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
<?php include('layouts/header.php'); ?>
<main>
    <div class="container">
      <section class="page-intro text-center">
        <h1>About GlamAura</h1>
        <p class="muted">A boutique beauty studio created to celebrate style, ritual and the art of beautification.</p>
      </section>
    </div>

    <section class="hero">
      <div class="container">
        <div class="row hero-inner align-items-center g-4">
          <div class="col-lg-6 col-md-12 hero-content order-2 order-lg-1">
            <h1 class="hero-title">Our Story</h1>
            <p class="hero-sub">From discovering her love for colors at a young age to becoming a certified professional makeup artist, her journey has been shaped by passion, creativity, and dedication. Trained under top industry mentors, she has completed over 2000+ makeovers ranging from bridal and party looks to editorial shoots and brand collaborations. With years of experience and a commitment to using premium products, she focuses on enhancing natural beauty while creating personalized, flawless, and long-lasting looks. Her work has been featured in fashion events and magazine shoots, and she continues to grow by learning new techniques and delivering exceptional results to every client.</p>
          </div>
          <div class="col-lg-6 col-md-12 hero-image text-center order-1 order-lg-2">
            <div class="slideshow">
              <img src="assets/images/staff/s3.jpg" class="slide active img-fluid">
              <img src="assets/images/staff/s4.jpg" class="slide img-fluid">
              <img src="assets/images/staff/s5.jpg" class="slide img-fluid">       
              <img src="assets/images/staff/s7.jpg" class="slide img-fluid">
              <img src="assets/images/staff/s8.jpg" class="slide img-fluid">
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="featured">
      <div class="container">
        <h2 class="section-title text-center">Our Staff Details</h2>
        <p class="section-sub text-center">Meet the talented team that brings GlamAura to life.</p>
        <div class="row g-4">
            <?php
                $query = "SELECT * FROM tbl_staff WHERE status = 1 ORDER BY id DESC";
                $result = mysqli_query($conn, $query);

                if(mysqli_num_rows($result) > 0){
                    while($row = mysqli_fetch_assoc($result)){
            ?>
                <div class="col-6 col-md-6 col-lg-4">
                  <article class="service-card h-100">
                      <img src="assets/images/staff/<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>" class="img-fluid">
                      <div class="staff-info p-3">
                          <strong class="staff-name"><?php echo $row['name']; ?></strong>
                          <div class="staff-meta">
                              Experience: <?php echo $row['experience']; ?> <br>
                              Role: <?php echo ucfirst($row['role']); ?>
                          </div>
                          <div class="staff-services">
                              Services: <?php echo $row['services']; ?>
                          </div>
                      </div>
                  </article>
                </div>
            <?php
                    }
                } else {
                    echo "<div class='col-12'><p class='text-center'>No staff members found.</p></div>";
                }
            ?>
        </div>
      </div>
    </section>

    <!-- Our Studio Section -->
    <section class="about-preview">
      <div class="container">
        <div class="row about-card align-items-center g-4">
          <div class="col-lg-6 col-md-12 text-center">
            <img src="assets/images/s1.jpg" alt="Salon interior" loading="lazy" class="img-fluid" style="max-width: 75%;">
          </div>
          <div class="col-lg-6 col-md-12">
            <h2>Our Studio</h2>
            <p>Our studio is thoughtfully designed to give you a luxurious and personalized experience. From well-lit makeup stations to hygienic workspaces and premium beauty equipment, every corner reflects our commitment to quality. Whether you're here for a simple service or a full makeover, we make sure you feel relaxed, pampered, and confident.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Our Values Section -->
    <section class="values">
      <div class="container">
        <h2 class="section-title text-center">Our Values</h2>
        <div class="row">
          <div class="col-12">
            <ul class="values-list">
              <li><strong>Artistry</strong> — Continuous training and refined techniques.</li>
              <li><strong>Care</strong> — Cleanliness, comfort and client-first approach.</li>
              <li><strong>Quality</strong> — Only premium products and curated services.</li>
            </ul>
          </div>
        </div>
      </div>
    </section>

  </main>
<?php include('layouts/footer.php'); ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<a href="https://instagram.com/shreyasiyer96" target="_blank" class="instagram-btn d-flex align-items-center justify-content-center">
    <i class="bi bi-instagram"></i>
</a>

<a href="https://wa.me/9879020573" target="_blank" class="whatsapp-btn d-flex align-items-center justify-content-center">
    <i class="bi bi-whatsapp"></i>
</a>

</body>
</html>
