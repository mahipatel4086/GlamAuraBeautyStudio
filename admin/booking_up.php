<?php
include("./conn.php");
session_start();

if(!isset($_SESSION['admin']) || empty($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

$id = $_GET['id'];
$old = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM tbl_booking WHERE id='$id'"));

//  STICKY VALUES (with old values default)
$name        = $_POST['upname']        ?? $old['name'];
$phone       = $_POST['uphone']        ?? $old['phone'];
if (!preg_match("/^[0-9]{10}$/", $phone)) {
    echo "<script>alert('Phone number must be exactly 10 digits'); history.back();</script>";
    exit;
}
$email       = $_POST['upemail']       ?? $old['email'];
$city_id     = $_POST['upcity_id']     ?? $old['city_id'];
$category_id = $_POST['upcategory_id'] ?? $old['category_id'];
$service_id  = $_POST['upservice_id']  ?? $old['service_id'];
$date        = $_POST['date']          ?? $old['date'];
$time        = $_POST['time']          ?? $old['time'];
$message     = $_POST['message']       ?? $old['message'];

//  GET PRICE OF SELECTED SERVICE
$price = $old['price'];
if ($service_id) {
    $p = mysqli_fetch_assoc(mysqli_query($conn, "SELECT price FROM tbl_services WHERE service_id='$service_id'"));
    if ($p) $price = $p['price'];
}

//  UPDATE QUERY
if (isset($_POST['btn_update'])) {

    $query = "UPDATE tbl_booking SET
        name='$name',
        phone='$phone',
        email='$email',
        city_id='$city_id',
        category_id='$category_id',
        service_id='$service_id',
        date='$date',
        time='$time',
        message='$message',
        price='$price'
    WHERE id='$id'";

    if (mysqli_query($conn, $query)) {
        echo "<p style='color:green;'>Booking Updated Successfully!</p>";
        header("Location: booking.php");
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
    <title>Update Booking</title>
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
        <h3>Update Booking</h3>
        <form method="POST" action="">
          <div class="form-grid">
            <div>
                <label>Name :</label>
                <input type="text" name="upname" value="<?= $name ?>" required />
            </div>
            <div>
                <label>Phone :</label>
                <input type="text" name="uphone" value="<?= $phone ?>" required />
            </div>
            <div>
                <label>Email :</label>
                <input type="email" name="upemail" value="<?= $email ?>" required />
            </div>
            <div>
                <label>City:</label>
                <select name="upcity_id" required>
                    <option value="">Select City</option>
                    <option value="1"<?php if($city_id == 1) echo "selected"; ?>>Surat</option>
                    <option value="2"<?php if($city_id == 2) echo "selected"; ?>>Rajkot</option>
                    <option value="3"<?php if($city_id == 3) echo "selected"; ?>>Ahemdabad</option>
                    <option value="4"<?php if($city_id == 4) echo "selected"; ?>>Bharuch</option>
                    <option value="5"<?php if($city_id == 5) echo "selected"; ?>>Valsad</option>
                    <option value="6"<?php if($city_id == 6) echo "selected"; ?>>Vadodara</option>
                    <option value="7"<?php if($city_id == 7) echo "selected"; ?>>Gandhinagar</option>                
                    <option value="8"<?php if($city_id == 8) echo "selected"; ?>>Bhavnagar</option>
                  </select>
            </div>
            <div>
                <label>Category:</label>
                <select name="upcategory_id" required>
                    <option value="">Select Category</option>
                    <?php
                    $categoryList = mysqli_query($conn, "SELECT * FROM tbl_categories WHERE status=1");
                    while ($r = mysqli_fetch_assoc($categoryList)) {
                        $sel = ($category_id == $r['id']) ? "selected" : "";
                        echo "<option value='{$r['id']}' $sel>{$r['name']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div>
                <label>Service:</label>
                <select name="upservice_id" required>
                    <option value="">Select Service</option>
                    <?php
                    if ($category_id) {
                        $serviceList = mysqli_query($conn, "SELECT * FROM tbl_services WHERE category_id='$category_id' AND status=1");
                        while ($s = mysqli_fetch_assoc($serviceList)) {
                            $sel = ($service_id == $s['service_id']) ? "selected" : "";
                            echo "<option value='{$s['service_id']}' $sel>{$s['name']}</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <div>
                <label>Price:</label>
                <input type="text" name="price" value="<?= $price ?>" readonly>
            </div>
            <div>
                <label>Date:</label>
                <input type="date" name="date" value="<?= $date ?>" required>
            </div>
            <div>
                <label>Time:</label>
                <input type="time" name="time" value="<?= $time ?>" required>
            </div>
            <div class="full">
                <label>Message:</label>
                <input type="text" name="message" value="<?= $message ?>">
            </div>
        </div>
          <div class="btn-row">
            <input type="submit" value="Update Booking" name="btn_update">
            <a href="booking.php" class="btn-dashboard">Dashboard</a>
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




