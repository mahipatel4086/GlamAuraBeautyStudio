<?php
include('./conn.php');
session_start();

if(!isset($_SESSION['admin']) || empty($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['btn_addData'])) {

    $name   = $_POST['name'];
    $phone  = $_POST['phone'];
    $email  = $_POST['email'];
    $city   = $_POST['city_id'];
    $cat    = $_POST['category_id'];
    $srv    = $_POST['service_id'];
    $date   = $_POST['date'];
    $time   = $_POST['time'];
    $msg    = $_POST['message'];
    $price  = $_POST['price'];

    // Phone validation
    if (!preg_match("/^[0-9]{10}$/", $phone)) {
        echo "<script>alert('Phone must be exactly 10 digits'); history.back();</script>";
        exit();
    }

    // Insert query
    $insert = mysqli_query($conn, 
    "INSERT INTO tbl_booking
    (name, phone, email, city_id, category_id, service_id, date, time, message, price)
    VALUES 
    ('$name','$phone','$email','$city','$cat','$srv','$date','$time','$msg','$price')");

    if ($insert) {

        // WhatsApp message
        $message_text = urlencode("Hello $name, your appointment is confirmed for $date at $time. Thank you for choosing our salon.");

        // WhatsApp URL
        $whatsapp_url = "https://wa.me/91$phone?text=$message_text";

        // Redirect using JavaScript (always works)
        echo "<script>
            window.location.href='$whatsapp_url';
        </script>";

        exit();
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

<div class="form-container">
  <h3>Add New Appointment</h3>
  <form method="POST" action="" enctype="multipart/form-data">
    <div class="form-grid">
      <div>
        <label>Name :</label>
        <input type="text" name="name" required />
      </div>
      <div>
        <label>Phone:</label> <input type="text" name="phone" required>
      </div>  
      <div>
        <label>Email:</label> <input type="email" name="email">
      </div>
      <!-- <div>
        <label>City:</label>
          <select name="city_id" required>
          <option value="">Select City</option>
          <?php
          $city = mysqli_query($conn, "SELECT * FROM tbl_city WHERE status=1");
          while ($r = mysqli_fetch_assoc($city)) {
              $sel = ($city_id == $r['city_id']) ? "selected" : "";
              echo "<option value='{$r['city_id']}' $sel>{$r['city_name']}</option>";
          }
          ?>
        </select>
      </div> -->
      <div>
<label>Category:</label>
<select name="category_id" id="categoryDropdown" onchange="filterServices(this.value)">
    <option value="">Select Category</option>
    <?php
    $cat = mysqli_query($conn, "SELECT * FROM tbl_categories WHERE status=1");
    while ($r = mysqli_fetch_assoc($cat)) {
        echo "<option value='{$r['id']}'>{$r['name']}</option>";
    }
    ?>
</select>
      </div>
<div>
    <label>Service:</label>
    <select name="service_id" id="serviceDropdown">
        <option value="">Select Service</option>
        <?php
            if ($category_id > 0) {
              $services = mysqli_query($conn, "SELECT id, name FROM tbl_services WHERE status=1 AND category_id = {$category_id} ORDER BY name");
              while ($s = mysqli_fetch_assoc($services)) {
                  $sel = ($service_id == $s['id']) ? "selected" : "";
                  echo "<option value='{$s['id']}' $sel>" . htmlspecialchars($s['name']) . "</option>";
              }
            }
          ?>
    </select>
</div>
      <div>
        <label>Price:</label> <input type="text" name="price" readonly required>
      </div>
      <div>
        <label>Date:</label> <input type="date" name="date" required>
      </div>
      <div>
        <label>Time:</label> <input type="time" name="time" required>
      </div>
      <div class="full">
        <label>Message:</label> <input type="text" name="message">
      </div>
    </div>
      <div class="btn-row">
        <input type="submit" value="Add Appointment" name="btn_addData">
        <a href="booking.php" class="btn-dashboard">Dashboard</a>
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

<script>
    // Load all services from PHP into JavaScript
    const allServices = [
        <?php
        $srvAll = mysqli_query($conn, "SELECT * FROM tbl_services WHERE status=1");
        while ($s = mysqli_fetch_assoc($srvAll)) {
            echo "{id: {$s['service_id']}, category_id: {$s['category_id']}, name: '" . addslashes($s['name']) . "', price: {$s['price']}},";
        }
        ?>
    ];

    function filterServices(catId) {
        const dropdown = document.getElementById("serviceDropdown");
        dropdown.innerHTML = "<option value=''>Select Service</option>";

        allServices.forEach(service => {
            if (service.category_id == catId) {
                dropdown.innerHTML += `<option value="${service.id}">${service.name}</option>`;
            }
        });
    }

    // ---- STEP 2: Auto-fill price when service is selected ----
    document.getElementById("serviceDropdown").addEventListener("change", function() {
        const selectedId = this.value;

        const priceInput = document.querySelector("input[name='price']");
        priceInput.value = ""; // clear first

        const selectedService = allServices.find(s => s.id == selectedId);

        if (selectedService) {
            priceInput.value = selectedService.price;  // Auto-fill price
        }
    });
</script>
</body>
</html>
