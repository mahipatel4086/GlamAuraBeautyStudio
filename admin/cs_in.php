<?php
include('./conn.php');

session_start();

if(!isset($_SESSION['admin']) || empty($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}


/* -----------------------------------------
   1. FETCH CUSTOMER INFO (Auto-fill)
-----------------------------------------*/
$customer_id = isset($_GET['customer_id']) ? intval($_GET['customer_id']) : 0;

$customer = null;
if ($customer_id > 0) {
    $sql = "SELECT customer_id, enrollment_no, c_name FROM tbl_customer WHERE customer_id = $customer_id";
    $res = $conn->query($sql);
    $customer = $res->fetch_assoc();
}

/* -----------------------------------------
   2. HANDLE AJAX: Get Services by Category
-----------------------------------------*/
if (isset($_POST['action']) && $_POST['action'] == 'get_services') {
    $cat_id = intval($_POST['category_id']);

    $q = "SELECT service_id, name FROM tbl_services WHERE category_id = $cat_id";
    $r = $conn->query($q);

    echo '<option value="">Select Service</option>';
    while ($row = $r->fetch_assoc()) {
        echo '<option value="'.$row['service_id'].'">'.$row['name'].'</option>';
    }
    exit;
}

/* -----------------------------------------
   3. HANDLE AJAX: Get Price by Service ID
-----------------------------------------*/
if (isset($_POST['action']) && $_POST['action'] == 'get_price') {
    $sid = intval($_POST['service_id']);

    $q = "SELECT price FROM tbl_services WHERE service_id = $sid";
    $r = $conn->query($q);
    $row = $r->fetch_assoc();

    echo $row['price'];
    exit;
}

/* -----------------------------------------
   4. INSERT FORM DATA INTO tbl_customer_services
-----------------------------------------*/
if (isset($_POST['btn_addData'])) {

    $cust_id       = intval($_POST['customer_id']);
    $enroll_id     = intval($_POST['enrollment_no']);
    $category_id   = intval($_POST['category_id']);
    $service_id    = intval($_POST['service_id']);
    $price         = $_POST['price'];
    $date          = $_POST['date'];
    $next_service_date = $_POST['next_service_date'];
    $time          = $_POST['time'];

$sql_insert = "
    INSERT INTO tbl_cs
    (customer_id, enrollment_no, category_id, service_id, price, date, time, next_service_date)
    VALUES ($cust_id, $enroll_id, $category_id, $service_id, '$price', '$date', '$time', '$next_service_date')
";

    if ($conn->query($sql_insert)) {
        echo "<script>alert('Service Added Successfully!'); window.location='cs.php?customer_id=$cust_id';</script>";
    } else {
        echo "<script>alert('Error Adding Service');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Appointment</title>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
  <h3>Add Customer Service</h3>
  <form method="POST" action="">
    <div class="form-grid">
    <div>
        <label>Customer Name</label>
        <input type="text" class="form-control" value="<?php echo $customer['c_name']; ?>" disabled><br>
    </div>

    <input type="hidden" name="customer_id" value="<?php echo $customer['customer_id']; ?>">
    <input type="hidden" name="enrollment_no" value="<?php echo $customer['enrollment_no']; ?>">

    <!-- CATEGORY -->
    <div>
        <label>Category</label>
        <select name="category_id" id="category" class="form-control" required>
            <option value="">Select Category</option>

            <?php
            $q = "SELECT id, name FROM tbl_categories";
            $r = $conn->query($q);
            while ($row = $r->fetch_assoc()) {
                echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
            }
            ?>
        </select><br>
    </div>

    <!-- SERVICE -->
    <div>
        <label>Service</label>
        <select name="service_id" id="service" class="form-control" required>
            <option value="">Select Service</option>
        </select><br>
    </div>

    <!-- PRICE -->
    <div>
        <label>Price</label>
        <input type="text" name="price" id="price" class="form-control" readonly required><br>
    </div>

    <!-- DATE -->
    <div>
        <label>Date</label>
        <input type="date" name="date" class="form-control" required><br>
    </div>

    <div>
        <label>Next Appointment Date</label>
        <input type="date" name="next_service_date" class="form-control">
    </div>

    <!-- TIME -->
    <div>
        <label>Time</label>
        <input type="time" name="time" class="form-control" required><br>
    </div>
      <div class="btn-row">
              <input type="submit" value="Add Service" name="btn_addData">
              <a href="cs.php" class="btn-dashboard">Dashboard</a>
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

<!-- JS for Dynamic Dropdown -->
<script>
$(document).ready(function(){

    // GET SERVICES BY CATEGORY
    $('#category').change(function(){
        var category_id = $(this).val();

        $.post("cs_in.php", {action:"get_services", category_id:category_id}, function(data){
            $('#service').html(data);
            $('#price').val("");
        });
    });

    // GET PRICE BY SERVICE
    $('#service').change(function(){
        var service_id = $(this).val();

        $.post("cs_in.php", {action:"get_price", service_id:service_id}, function(data){
            $('#price').val(data);
        });
    });

});
</script>

</body>
</html>
