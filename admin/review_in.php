<?php
include 'conn.php';
session_start();

if(!isset($_SESSION['admin']) || empty($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}
// INSERT REVIEW
if (isset($_POST['btn_addData'])) {
    $name = $_POST['name'];
    $rating = $_POST['rating'];
    $review = $_POST['review'];

    $sql = "INSERT INTO tbl_reviews (reviewer_name, rating, review_text) 
            VALUES ('$name', '$rating', '$review')";
    mysqli_query($conn, $sql);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Services</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&family=Playfair+Display:wght@600&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="admin.css">
  <style>
    @media (max-width: 900px) {
      body {
        overflow-x: hidden;
      }
      
      .app {
        grid-template-columns: 1fr;
        padding: 0;
        overflow-x: hidden;
        margin: 0;
        width: 100vw;
      }
      
      .main {
        overflow-x: hidden;
        padding: 8px 0;
        width: 100%;
      }
      
      .sidebar {
        position: fixed;
        left: -280px;
        top: 0;
        width: 260px;
        height: 100vh;
        z-index: 1000;
        transition: left 0.3s ease;
        margin-left: 0;
        margin-top: 0;
        display: none;
        overflow: hidden;
      }
      
      .sidebar.show {
        display: block;
        left: 0;
      }
      
      .topbar {
        overflow-x: hidden;
        width: 100%;
        justify-content: flex-end;
      }
      
      .topbar .d-flex:first-child {
        display: none;
      }
      
      .profile-pill {
        flex-shrink: 0;
      }
      
      .profile-pill .text-end {
        display: none;
      }
      
      .form-container {
        overflow-x: hidden;
        margin: 10px;
        padding: 20px;
      }
      
      .table-wrap {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
      }
      
      .table {
        min-width: 700px;
        white-space: nowrap;
      }
      
      .table th,
      .table td {
        white-space: nowrap;
        min-width: 100px;
      }
      
      .btn {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        min-width: 0;
      }
      
      .form-grid {
        grid-template-columns: 1fr !important;
        gap: 15px !important;
      }
      
      .full {
        grid-column: 1 !important;
      }
      
      .btn-row {
        flex-direction: column;
        gap: 15px;
      }
    }
  </style>
</head>
<body>
   <?php include('./includes/header.php'); ?>
    <main class="main">
      
<div class="form-container">
    <h3>Your Review</h3>
    <form method="POST" action="" enctype="multipart/form-data">
        <div class="form-grid">
        <div>
            <label>Your Name</label>
            <input type="text" name="name" required>
        </div>
        <div>
            <label>Rating</label>
            <select name="rating" required>
                <option value="">Select Rating</option>
                <option value="5">★★★★★ - Excellent</option>
                <option value="4">★★★★☆ - Good</option>
                <option value="3">★★★☆☆ - Average</option>
                <option value="2">★★☆☆☆ - Poor</option>
                <option value="1">★☆☆☆☆ - Very Bad</option>
            </select>
        </div>
        <div class="full">
            <label>Your Review</label>
            <input type="text" name="review" required rows="4">
        </div>
        </div>
          <div class="btn-row">
              <input type="submit" value="submit" name="btn_addData">
              <a href="reviews.php" class="btn-dashboard">Dashboard</a>
          </div>
    </form>
</div>
</main>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    if (window.innerWidth <= 900) {
      const sidebar = document.querySelector('.sidebar');
      sidebar.classList.remove('show');
    }
  });
</script>

</body>
</html>
    <div class="footer-inner">

        <!-- ABOUT -->
        <div class="footer-column">
            <span class="logo-mark">GA</span><p>
                GlamourGlow Beauty Studio provides premium services including
                bridal makeup, hairstyling, nail art & mehendi — crafted to enhance your beauty.
                
            </p>

           
        </div>

        <!-- COMPANY -->
        <div class="footer-column footer-nav">
            <h3>Company</h3>
            <ul>
                <li><a href="about.php">About</a></li><br>
                <li><a href="faq.php">FAQ</a></li><br>
                <li><a href="services.php">Services</a></li><br>
                <li><a href="gallery.php">Gallery</a></li><br>
            </ul>
        </div>

        <!-- SERVICES -->
        <div class="footer-column footer-nav">
            <h3>Services</h3>
            <ul>
                <li><a href="bridal.php">Bridal Makeup</a></li>
                <li><a href="makeup.php">Party Makeup</a></li>
                <li><a href="nailart.php">Nail Art</a></li>
                <li><a href="hairstyling.php">Hairstyling</a></li>
                <li><a href="mehendi.php">Mehendi</a></li>
            </ul>
        </div>

        <!-- CONTACT -->
        <div class="footer-column">
            <h3>Get in Touch</h3>
            <p>
                GlamourGlow Beauty Studio<br>
                Adajan, Surat - 395009<br>
            </p>
            <p>Email: <a href="mailto:glamAura@gmail.com">glamAura@gmail.com</a></p>
            <p>Phone: <a href="tel:+919876543210">+91 98765 43210</a></p>
        </div>

    </div>
</footer>

  <script src="assets/js/main.js" defer></script>

  <script src="assets/js/main.js" defer></script>

  <!-- Instagram Floating Button -->
  <a href="https://instagram.com/shreyasiyer96" target="_blank" rel="noopener noreferrer" class="instagram-btn" aria-label="Follow us on Instagram">
    <img src="assets/images/insta.jpg" alt="Instagram" class="instagram-icon">
  </a>

  <!-- WhatsApp Floating Button -->
  <a href="https://wa.me/9879020573" target="_blank" rel="noopener noreferrer" class="whatsapp-btn" aria-label="Chat with us on WhatsApp">
    <img src="assets/images/w.jpg" alt="WhatsApp chat" class="whatsapp-icon">
  </a>

</body>
</html></div>
</div>
</main>
</body>
</html>
