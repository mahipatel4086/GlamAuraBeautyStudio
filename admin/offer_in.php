<?php
include('conn.php');
session_start();

if(!isset($_SESSION['admin']) || empty($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Offer</title>

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
    <h3>Add New Offer</h3>

    <form method="POST" action="" enctype="multipart/form-data">
        <div class="form-grid">

            <div>
                <label>Offer Title :</label>
                <input type="text" name="offer_title" required />
            </div>

            <div>
                <label>Discount (%) :</label>
                <input type="number" step="0.01" name="discount_value" required />
            </div>

            <div class="full">
                <label>Description :</label>
                <input type="text" name="offer_description" required />
            </div>

            <div>
                <label>Start Date :</label>
                <input type="date" name="start_date" required />
            </div>

            <div>
                <label>End Date :</label>
                <input type="date" name="end_date" required />
            </div>

            <div>
                <label>Image :</label>
                <input type="file" name="offer_image" required />
            </div>

            <div>
                <label>Status :</label>
                <select name="status" required>
                    <option value="1">Active</option>
                    <option value="2">Inactive</option>
                </select>
            </div>

        </div>

        <div class="btn-row">
            <input type="submit" value="Add Offer" name="btn_add_offer">
            <a href="offer.php" class="btn-dashboard">Dashboard</a>
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

<?php
if (isset($_POST['btn_add_offer'])) {

    // Image upload
    $image = $_FILES['offer_image']['name'];
    $tmp = $_FILES['offer_image']['tmp_name'];

    $folder = "uploads/offer/";
    if(!is_dir($folder)) {
        mkdir($folder, 0777, true);
    }

    if (!empty($image)) {
        move_uploaded_file($tmp, $folder . $image);
    }

    // Form data
    $offer_title = $_POST['offer_title'];
    $offer_description = $_POST['offer_description'];
    $discount_value = $_POST['discount_value'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $status = $_POST['status'];

    // Insert into tbl_offer
    $sql = "INSERT INTO tbl_offer 
            (offer_title, offer_description, offer_image, discount_type, discount_value, start_date, end_date, status, created_at)
            VALUES 
            ('$offer_title', '$offer_description', '$image', 'per', '$discount_value', '$start_date', '$end_date', '$status', NOW())";

    if (mysqli_query($conn, $sql)) {
        echo "<p style='color:green;'>Offer Added Successfully!</p>";
        header("Location: offer.php");
        exit();
    } else {
        echo "<p style='color:red;'>Error: " . mysqli_error($conn) . "</p>";
    }
}
?>
