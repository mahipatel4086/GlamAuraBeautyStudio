<?php
  include("./conn.php");
  // Fetch category data
function getServices($conn, $cat_id) {
    $sql = "SELECT * FROM tbl_services WHERE category_id = $cat_id AND status = 1 ORDER BY id ASC";
    return mysqli_query($conn, $sql);
}
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
<body class="services-page">
<?php include('layouts/header.php'); ?>
  <main>
    <div class="container">
      <section class="page-intro text-center">
        <h1>Services</h1>
        <p class="muted">Tailored beauty services for every occasion — crafted with premium products and professional expertise.</p>
      </section>
    </div>

    <div class="services-zigzag">
      <div class="container">
        <?php
        // Fetch active categories
        $sql = "SELECT * FROM tbl_categories WHERE status = 1 ORDER BY id ASC";
        $res = mysqli_query($conn, $sql);
        $idx = 0;

        while ($cat = mysqli_fetch_assoc($res)) {
            $idx++;
            // Determine zigzag direction: even items will appear reversed
            $is_even = ($idx % 2 === 0);
            // image path - update if your images are elsewhere
            $imagePath = 'admin/uploads/category/' . htmlspecialchars($cat['image']);
            $title = htmlspecialchars($cat['name']);
            $description = htmlspecialchars($cat['description']);
            $catId = (int)$cat['id'];
        ?>
        <article class="row align-items-center g-4 mb-5 <?php echo $is_even ? 'flex-row-reverse' : ''; ?>">
          <div class="col-lg-6 col-md-12 service-image text-center">
            <!-- <a class="image-link" href="services.php?category=<?php echo $catId; ?>"> -->
              <img src="<?php echo $imagePath; ?>"
                 alt="<?php echo $title; ?>"
                 loading="lazy" class="img-fluid">
            <!-- </a> -->
          </div>

          <div class="col-lg-6 px-4 col-md-12 service-content">
            <h2 class="service-title"><?php echo $title; ?></h2>
            <p class="service-description"><?php echo $description; ?></p>

            <ul class="service-features">
              <?php 
                $features = explode("\n", $cat['features']);  // Split lines into array
                foreach ($features as $feature) {
                  $feature = trim($feature);
                  if (!empty($feature)) {
                    echo "<li>" . htmlspecialchars($feature) . "</li>";
                  }
                } 
              ?>
            </ul>

            <a href="category.php?id=<?php echo $catId; ?>" class="btn btn-rose">View Services</a>
          </div>
        </article>
        <?php } // end while ?>
      </div>
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
