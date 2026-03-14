<?php
include("./conn.php");

// Check if a category is selected via GET
$category_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Fetch category name
$category_name = '';
if($category_id > 0){
    $cat_sql = "SELECT name FROM tbl_categories WHERE id = $category_id AND status = 1";
    $cat_res = mysqli_query($conn, $cat_sql);
    if($cat_res && mysqli_num_rows($cat_res) > 0){
        $cat_row = mysqli_fetch_assoc($cat_res);
        $category_name = $cat_row['name'];
    } else {
        $category_id = 0; // Invalid category
    }
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
<body>
<?php 
  include ('layouts/header.php');  
?>
<main>
    <div class="container">
      <section class="page-intro text-center">
          <h1><?php echo $category_name ? $category_name : "All"; ?> Services</h1>
          <p class="muted">Explore our premium beauty services tailored for every occasion.</p>
      </section>

      <div class="category-content">
          <div class="row g-4">
          <?php
          if($category_id > 0){
              // Fetch services of selected category
              $sql = "SELECT * FROM tbl_services WHERE category_id = $category_id AND status = 1 ORDER BY service_id ASC";
          } else {
              // Fetch all services
              $sql = "SELECT * FROM tbl_services WHERE status = 1 ORDER BY category_id ASC, service_id ASC";
          }

          $res = mysqli_query($conn, $sql);

          if($res && mysqli_num_rows($res) > 0){
              while($service = mysqli_fetch_assoc($res)){
                  // Fetch category name for each service if needed
                  if(!$category_name){
                      $cat_id = (int)$service['category_id'];
                      $cat_query = "SELECT name FROM tbl_categories WHERE id = $cat_id";
                      $cat_res2 = mysqli_query($conn, $cat_query);
                      $cat_row2 = mysqli_fetch_assoc($cat_res2);
                      $service_cat_name = $cat_row2['name'];
                  } else {
                      $service_cat_name = '';
                  }

                  $imagePath = $service['image'] ? 'admin/uploads/services/'.$service['image'] : 'assets/images/default-service.jpg';

                  echo '<div class="col-lg-4 col-md-6 col-sm-12">';
                  echo '<div class="service-card h-100">';
                  echo $service_cat_name ? "<h4 class='service-category text-center p-2'>$service_cat_name</h4>" : '';
                  echo "<a class='card-image d-block' href='#'><img src='".htmlspecialchars($imagePath)."' alt='".htmlspecialchars($service['name'])."' loading='lazy' class='img-fluid'></a>";
                  echo "<div class='card-body p-3'>";
                  echo "<h3 class='text-center'>".htmlspecialchars($service['name'])."</h3>";
                  echo "<p class='text-center'>".htmlspecialchars($service['description'])."</p>";
                  echo "<div class='price text-center'>₹".$service['price']."</div>";
                  echo "</div></div></div>";
              }
          } else {
              echo "<div class='col-12'><p class='text-center'>No services found.</p></div>";
          }
          ?>
          </div>
      </div>
    </div>
</main>
<?php include ('layouts/footer.php'); ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<a href="https://instagram.com/shreyasiyer96" target="_blank" class="instagram-btn d-flex align-items-center justify-content-center">
    <i class="bi bi-instagram"></i>
</a>

<a href="https://wa.me/9879020573" target="_blank" class="whatsapp-btn d-flex align-items-center justify-content-center">
    <i class="bi bi-whatsapp"></i>
</a>

</body>
</html>
