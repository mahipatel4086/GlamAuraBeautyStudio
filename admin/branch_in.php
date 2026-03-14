<?php
include('./conn.php');

session_start();

if(!isset($_SESSION['admin']) || empty($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

$city_id     = $_POST['city_id'] ?? "";

// ------------------------------
// Insert booking
// ------------------------------
if (isset($_POST['btn_addData'])) {

    $image  = $_POST['image'];
    $location  = $_POST['location'];
    $city  = $_POST['city_name'];
    $phone  = $_POST['phone'];
    if (!preg_match("/^[0-9]{10}$/", $phone)) {
    echo "<script>alert('Phone number must be exactly 10 digits'); history.back();</script>";
    exit;
}
    $email  = $_POST['email'];
    $op_time   = $_POST['opening_time'];
    $co_time  = $_POST['closing_time'];
    $status = $_POST['status'];

    $insert = mysqli_query($conn,
    "INSERT INTO branches
    (image, location, city_name, phone, email, opening_time, closing_time, status)
    VALUES ('$image','$location','$city','$phone','$email','$op_time','$co_time','$status')");

    if ($insert) {
        echo "<p style='color:green'>Booking Successful</p>";
        header("Location: branch.php");
        exit();
    } else {
        echo "<p style='color:red'>Error: " . mysqli_error($conn) . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Branch</title>
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
  <h3>Add New Branch</h3>
  <form method="POST" action="" enctype="multipart/form-data">
    <div class="form-grid">
      <div>
            <label>Image:</label> 
            <input type="file" name="image" required>
      </div> 
        <div>
            <label>Location:</label> 
            <input type="text" name="location" required>
      </div>    
        <div>
        <label>Phone:</label> <input type="text" name="phone" required>
      </div>  
      <div>
        <label>Email:</label> <input type="email" name="email">
      </div>
      <div>
        <label>City:</label>
          <select name="city_name" required>
          <option value="">Select City</option>
          <?php
          $city = mysqli_query($conn, "SELECT * FROM tbl_city WHERE status=1");
          while ($r = mysqli_fetch_assoc($city)) {
              $sel = ($city_name == $r['city_name']) ? "selected" : "";
              echo "<option value='{$r['city_name']}' $sel>{$r['city_name']}</option>";
          }
          ?>
        </select>
      </div>
        <div>
            <label>Opening Time:</label>
             <input type="time" name="opening_time" required>
        </div>
        <div>
            <label>Closing Time:</label> 
            <input type="time" name="closing_time" required>
        </div>
        <div>
            <label>Status:</label>
            <select name="status" required>
                <option value="1">Active</option>
                <option value="0">Inactive</option>
            </select>
        </div>
      </div>
      <div class="btn-row">
        <input type="submit" value="Add Branch" name="btn_addData">
        <a href="branch.php" class="btn-dashboard">Dashboard</a>
      </div>
      </form>
  </div>
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
