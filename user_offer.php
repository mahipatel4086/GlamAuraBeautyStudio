<?php
include("./conn.php");

// Fetch only active & valid offers
$sql = "SELECT *
        FROM tbl_offer
        WHERE status = 1
        AND start_date <= CURDATE()
        AND end_date >= CURDATE()
        ORDER BY end_date ASC";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Salon Offers</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Main Site CSS -->
    <link rel="stylesheet" href="assets/css/style.css">

    <!-- Offer CSS -->
    <link rel="stylesheet" href="assets/css/offers.css">
</head>
<body>
<style>
  /* ===== OFFERS PAGE ===== */

.offers-section {
    padding: 60px 0;
}

.page-title {
    text-align: center;
    margin-bottom: 40px;
    font-weight: 700;
    color: #4a1c40;
}

/* GRID */
.offers-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 24px;
}

/* CARD */
.offer-card {
    background: #fff;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 10px 25px rgba(0,0,0,0.08);
    transition: transform .3s ease, box-shadow .3s ease;
}

.offer-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 16px 40px rgba(0,0,0,0.12);
}

/* IMAGE */
.offer-image {
    position: relative;
    height: 200px;
}

.offer-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* DISCOUNT BADGE */
.discount-badge {
    position: absolute;
    top: 12px;
    right: 12px;
    background: #c2185b;
    color: #fff;
    font-size: 14px;
    font-weight: 600;
    padding: 6px 12px;
    border-radius: 20px;
}

/* CONTENT */
.offer-content {
    padding: 18px;
    text-align: center;
}

.offer-content h3 {
    font-size: 18px;
    margin-bottom: 8px;
    color: #3b0a30;
}

.offer-content p {
    font-size: 14px;
    color: #666;
    margin-bottom: 12px;
}

.expiry {
    display: block;
    font-size: 13px;
    color: #999;
    margin-bottom: 16px;
}


/* NO OFFER */
.no-offers {
    text-align: center;
    grid-column: 1/-1;
    color: #777;
    font-size: 16px;
}

/* MOBILE */
@media (max-width: 576px) {
    .offer-image {
        height: 180px;
    }
}
.btn-rose {
  background: var(--rose-gold);
  color: #fff;
  padding: 0.75rem 1.75rem;
  border-radius: 999px;
  text-decoration: none;
  font-weight: 600;
  display: inline-block;
  transition: all 0.3s ease;
  border: 2px solid transparent;
  box-shadow: 0 4px 12px rgba(207, 164, 106, 0.25);
}

.btn-rose:hover {
  transform: translateY(-3px);
  box-shadow: 0 8px 24px rgba(207, 164, 106, 0.35);
}

.btn-rose:active {
  transform: translateY(-1px);
}

  </style>
<?php include('layouts/header.php'); ?>

<main>
  <section class="offers-section">
      <div class="container">
          <h2 class="page-title text-center mb-5">Exclusive Salon Offers</h2>

          <div class="row g-4">

              <?php if (mysqli_num_rows($result) > 0) {
                  while ($row = mysqli_fetch_assoc($result)) { ?>

                  <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="offer-card h-100">

                        <div class="offer-image">
                            <img src="admin/uploads/offer/<?php echo htmlspecialchars($row['offer_image']); ?>" alt="" class="img-fluid">
                            <span class="discount-badge">
                                <?php echo (int)$row['discount_value']; ?>% OFF
                            </span>
                        </div>

                        <div class="offer-content">
                            <h3><?php echo htmlspecialchars($row['offer_title']); ?></h3>
                            <p><?php echo htmlspecialchars($row['offer_description']); ?></p>

                            <span class="expiry">
                                Valid till <?php echo date('d M Y', strtotime($row['end_date'])); ?>
                            </span>

                            <a href="booking.php?offer_id=<?php echo $row['offer_id']; ?>"
                               class="btn-rose">
                                Apply Offer
                            </a>
                        </div>

                    </div>
                  </div>

              <?php }
              } else { ?>
                  <div class="col-12">
                    <p class="no-offers text-center">No offers available right now.</p>
                  </div>
              <?php } ?>

          </div>
      </div>
  </section>
</main>

<?php include('layouts/footer.php'); ?>

</body>
</html>
