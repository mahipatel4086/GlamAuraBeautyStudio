<?php
include 'conn.php';

// INSERT REVIEW
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $rating = $_POST['rating'];
    $review = $_POST['review'];

    $sql = "INSERT INTO tbl_reviews (reviewer_name, rating, review_text) 
            VALUES ('$name', '$rating', '$review')";
    mysqli_query($conn, $sql);
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
<head>
  <style>
        .btn-primary {
        background: #a96461 !important; /* <-- change this to your preferred color */
        color: white;
        border: none !important;
        box-shadow: 0 5px 12px rgba(71, 38, 52, 0.2);
        padding: 12px 20px;
        border-radius: 30px;
        display: inline-block;
        text-decoration: none;
    }
    .btn-primary:hover { opacity: 0.9; transform: translateY(-2px); }
    .review-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 25px;
    margin-top: 30px;
}

.review-card {
    padding: 20px;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.08);
}

@media (max-width: 992px) {
    .review-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 600px) {
    .review-grid {
        grid-template-columns: 1fr;
    }
}

  </style>
</head>
<body>
<?php include('layouts/header.php'); ?>
  <main>
    <div class="container">
      <section class="page-intro text-center">
        <h1>Reviews</h1>
        <p class="muted">Real reviews from our clients — bridal, events and salon services.</p>
      </section>

      <section class="testimonials">
        <div class="reviews-summary text-center mb-5">
          <div class="avg-rating d-flex justify-content-center align-items-center gap-3 mb-2">
            <div class="rating-number">4.9</div>
            <div class="rating" aria-hidden="true">
              <span class="star">★</span><span class="star">★</span><span class="star">★</span><span class="star">★</span><span class="star">☆</span>
            </div>
          </div>
          <div class="rating-count muted">Based on 128 reviews</div>
        </div>
        <div class="row g-4">
        <?php
      $sql = "SELECT * FROM tbl_reviews ORDER BY id DESC";
      $result = mysqli_query($conn, $sql);

      while ($row = mysqli_fetch_assoc($result)) { ?>
          <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="review-card h-100">
                <h3><?php echo $row['reviewer_name']; ?></h3>
                <div class="rating mb-2"><?php echo str_repeat("★", $row['rating']); ?></div>
                <p><?php echo $row['review_text']; ?></p>
            </div>
          </div>
      <?php } ?>
        </div>
      </section>
    </div>
<!--      <div class="center">
        <a href="contact.php" class="btn btn-primary">Book Your Appointment</a>
        <a href="review_in.php" class="btn btn-outline">Leave a Review</a>
      </div> -->
       
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
