<?php
include ("conn.php");

$sql = "SELECT * FROM branches";
$result = $conn->query($sql);
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
.section-title {
  text-align: center;
  width: 100%;
  display: block;
  margin-bottom: 10px;
}

.branch-info.container {
  width: 80%;
  margin-top: 50px;
  box-sizing: border-box;
}

.branch-card {
  background: var(--ivory);
  border-radius: 12px;
  padding: 1.5rem;
  margin: 1.5rem 0;
  display: flex;
  gap: 1.5rem;
  align-items: flex-start;
  border-left: 4px solid var(--rose-gold);
  box-shadow: 0 6px 16px rgba(71,38,52,0.05);
}

.branch-image {
  width: 200px;
  height: 220px;
  object-fit: cover;
  border-radius: 10px;
}

.branch-details {
  flex: 1;
}

.branch-name {
  margin: 0 0 .5rem 0;
  font-size: 1.3rem;
  color: var(--plum);
}

.branch-details p {
  margin: 0.25rem 0;
  line-height: 1.4rem;
}

.branch-details a {
  color: var(--plum);
  text-decoration: none;
}

.status {
  display: inline-block;
  margin-top: 1rem;
  padding: 6px 12px;
  border-radius: 8px;
  font-weight: 600;
  font-size: 0.9rem;
}

/* Status Colors */
.status.open {
  background: #d4f8d4;
  color: #2e8b57;
}

.status.closed {
  background: #ffd6d6;
  color: #b10000;
}
.branch-card {
  background: var(--ivory);
  border-radius: 12px;
  padding: 1.5rem;
  border-left: 4px solid var(--rose-gold);
  box-shadow: 0 6px 16px rgba(71,38,52,0.05);
}

@media (min-width: 992px) {
  .branch-card {
    display: flex;
    flex-wrap: nowrap;
    align-items: flex-start;
    gap: 1rem;
  }
  .branch-card .col-lg-3,
  .branch-card .col-lg-5,
  .branch-card .col-lg-4 {
    flex: none;
  }
}

/* Left side (image + details) */
.branch-left {
  flex: 1;
  display: flex;
  gap: 1.2rem;
}

/* Right side map */
.branch-map {
  width: 30%;
  min-width: 200px;
}

.branch-map iframe {
  width: 90%;
  height: 90%;
  min-height: 200px;
  border: 0;
  border-radius: 12px;
}

/* Image */
.branch-image {
  width: 200px;
  height: 200px;
  object-fit: cover;
  border-radius: 10px;
}

/* Title Centering */
.section-title {
  text-align: center;
  width: 100%;
}

    </style>
  </head>
<body>
<?php include('layouts/header.php'); ?>

<main>
  <div class="container">
    <section class="page-intro text-center">
      <h2 class="section-title">Our Branch</h2>
    </section>

    <?php while($row = $result->fetch_assoc()): 

     // Build full address
      $address_only = trim($row['location']);
      $city         = trim($row['city_name']);
      $full_address = $address_only . ", " . $city;

      // Google Maps embed
      $encoded = urlencode($full_address);
      $map_url = "https://www.google.com/maps?q={$encoded}&output=embed";
    ?>

      <div class="row branch-card align-items-start g-4 mb-4">
        <div class="col-lg-3 col-md-4 col-sm-12 text-center">
          <img src="admin/uploads/branch/<?php echo $row['image']; ?>" alt="<?php echo $row['location']; ?>" class="branch-image img-fluid">
        </div>
        <div class="col-lg-5 col-md-8 col-sm-12">
          <div class="branch-details">
            <h3 class="branch-name"><?= $address_only ?></h3>
            <p><strong>City:</strong> <?= $row['city_name'] ?></p>
            <p><strong>Phone:</strong> <a href="tel:<?= $row['phone'] ?>"><?= $row['phone'] ?></a></p>
            <p><strong>Email:</strong> <a href="mailto:<?= $row['email'] ?>"><?= $row['email'] ?></a></p>
            <p><strong>Hours:</strong> <?= $row['opening_time'] ?> - <?= $row['closing_time'] ?></p>
            <?php
              // Determine if branch is open or closed based on current time
              date_default_timezone_set('Asia/Kolkata'); // Set your timezone
              $current_time = date('H:i:s');

              if ($current_time >= $row['opening_time'] && $current_time <= $row['closing_time']) {
                  echo '<span class="status open">Open Now</span>';
              } else {
                  echo '<span class="status closed">Closed</span>';
              }
            ?>
          </div>
        </div>
        <div class="col-lg-4 col-md-12">
          <div class="branch-map">
            <iframe 
              src="<?= $map_url ?>"
              class="w-100"
              style="height: 180px; border-radius: 12px;"
              loading="lazy">
            </iframe>
          </div>
        </div>
      </div>

    <?php endwhile; ?>
  </div>
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
