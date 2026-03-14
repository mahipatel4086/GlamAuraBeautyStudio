<?php
include('./conn.php');
session_start();

if(!isset($_SESSION['admin']) || empty($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}
// ------------------------------
// Insert booking
// ------------------------------
if (isset($_POST['btn_addData'])) {

    $enrollment_no  = $_POST['enrollment_no'];
    $c_name   = $_POST['c_name'];
    $phone  = $_POST['phone'];
    if (!preg_match("/^[0-9]{10}$/", $phone)) {
    echo "<script>alert('Phone number must be exactly 10 digits'); history.back();</script>";
    exit;
}
    $email  = $_POST['email'];

    $insert = mysqli_query($conn,
    "INSERT INTO tbl_customer
    (enrollment_no,c_name, phone, email)
    VALUES ('$enrollment_no','$c_name','$phone','$email')");

    if ($insert) {
        echo "<p style='color:green'>Booking Successful</p>";
        header("Location: customer.php");
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
  <title>Add Appointment</title>
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
      
<br><div class="form-container">
  <h3>Add New Appointment</h3><br><br>
  <form method="POST" action="" enctype="multipart/form-data">
    <div class="form-grid">
       <div >
          <label>enrollment No:</label>
          <?php
          $enroll_no = rand(10000000, 99999999);
          ?>
          <input type="number" name="enrollment_no" value="<?= $enroll_no ?>" readonly><br><br>
        </div>

      <div>
        <label>customer Name :</label>
        <input type="text" name="c_name" required /><br><br><br>
      </div>
      <div>
        <label>Phone:</label>
        <input type="text" name="phone" required /><br><br>
      </div>
      <div>
        <label>Email:</label>
        <input type="email" name="email" required /><br><br>
      </div>
   <div class="btn-row">
              <input type="submit" value="Add customer" name="btn_addData">
              <a href="customer.php" class="btn-dashboard">Dashboard</a><br><br>
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
