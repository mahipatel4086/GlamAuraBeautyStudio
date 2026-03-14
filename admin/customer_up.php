<?php
include("./conn.php");

session_start();

if(!isset($_SESSION['admin']) || empty($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

$id = $_GET['customer_id'];
$old = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM tbl_customer WHERE customer_id='$id'"));

//  STICKY VALUES (with old values default)
$name        = $_POST['upc_name']        ?? $old['c_name'];
$enrollment  = $_POST['upenrollment_no']  ?? $old['enrollment_no'];
$phone       = $_POST['uphone']        ?? $old['phone'];
$email       = $_POST['upemail']       ?? $old['email'];

if (!preg_match("/^[0-9]{10}$/", $phone)) {
    echo "<script>alert('Phone number must be exactly 10 digits'); history.back();</script>";
    exit;
}

//  UPDATE QUERY
if (isset($_POST['btn_update'])) {

    $query = "UPDATE tbl_customer SET
        c_name='$name',
        enrollment_no='$enrollment',
        phone='$phone',
        email='$email' 
    WHERE customer_id='$id'";

    if (mysqli_query($conn, $query)) {
        echo "<p style='color:green;'>Booking Updated Successfully!</p>";
        header("Location: customer.php");
        exit();
    } else {
        echo "<p style='color:red;'>Error: " . mysqli_error($conn) . "</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
      <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&family=Playfair+Display:wght@600&display=swap" rel="stylesheet">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="admin.css">
    <title>Update Customer Record</title>
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
        <h3>Update Customer Record</h3>
        <form method="POST" action="">
          <div class="form-grid">
            <div class="full">
                <label>Name :</label>
                <input type="text" name="upc_name" value="<?= $name ?>" required />
            </div><br>
            
            <div class="full">
                <label>Phone :</label>
                <input type="text" name="uphone" value="<?= $phone ?>" required />
            </div><br>
            <div class="full">
                <label>Email :</label>
                <input type="email" name="upemail" value="<?= $email ?>" required />
            </div><br>
          <div class="btn-row">
            <input type="submit" value="Update Customer" name="btn_update">
            <a href="customer.php" class="btn-dashboard">Dashboard</a>
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
