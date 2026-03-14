<?php
include ('./conn.php');
session_start();

if(!isset($_SESSION['admin']) || empty($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}


$search = "";

// If search is applied
if (isset($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);

    // FIXED SEARCH QUERY (WITH JOINS)
    $sql = "
    SELECT b.id, b.name, b.phone, b.email, b.date, b.time, b.message, b.price, b.created_at,
           c.name AS category_name,
           s.name AS service_name,
           ct.name AS city_name
    FROM tbl_booking b
    LEFT JOIN tbl_categories c ON b.category_id = c.id
    LEFT JOIN tbl_services s ON b.service_id = s.id
    LEFT JOIN tbl_city ct ON b.city_id = ct.city_id
    WHERE 
        b.name LIKE '%$search%' OR
        b.email LIKE '%$search%' OR
        b.phone LIKE '%$search%' OR
        b.date LIKE '%$search%' OR
        c.name LIKE '%$search%' OR
        s.name LIKE '%$search%' OR
        ct.name LIKE '%$search%'
    ORDER BY b.id DESC ";

} else {

    // DEFAULT VIEW (no search)
    $sql = "
    SELECT b.id, b.name, b.phone, b.email, b.date, b.time, b.message, b.price, b.created_at,
           c.name AS category_name,
           s.name AS service_name,
           ct.city_name AS city_name
    FROM tbl_booking b
    LEFT JOIN tbl_categories c ON b.category_id = c.id
    LEFT JOIN tbl_services s ON b.service_id = s.service_id
    LEFT JOIN tbl_city ct ON b.city_id = ct.city_id
    ORDER BY b.id DESC LIMIT 5";
}

$result = $conn->query($sql);

// Total bookings
$totalBookingsQuery = $conn->query("SELECT COUNT(*) AS total FROM tbl_booking");
$totalBookings = $totalBookingsQuery->fetch_assoc()['total'] ?? 0;

// Monthly revenue
$monthlyRevenueQuery = $conn->query("
    SELECT SUM(price) AS total 
    FROM tbl_booking 
    WHERE MONTH(created_at) = MONTH(CURDATE())
    AND YEAR(created_at) = YEAR(CURDATE())
");
$monthlyRevenue = $monthlyRevenueQuery->fetch_assoc()['total'] ?? 0;

// Active services
$activeServicesQuery = $conn->query("
    SELECT COUNT(*) AS total 
    FROM tbl_services 
    WHERE status = 1
");
$activeServices = $activeServicesQuery->fetch_assoc()['total'];

// New messages (no table yet)
$unreadMessages = 0;

// Get visitor IP
$ip = $_SERVER['REMOTE_ADDR'];

// Insert into table
$conn->query("INSERT INTO tbl_impressions (ip) VALUES ('$ip')");
$impressionsQuery = $conn->query("SELECT COUNT(*) AS total FROM tbl_impressions");
$impressions = $impressionsQuery->fetch_assoc()['total'];

?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Glam Studio — Admin Dashboard</title>

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&family=Playfair+Display:wght@600&display=swap" rel="stylesheet">

  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

  <link href="admin.css" rel="stylesheet">
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
      
      .cards-row {
        overflow-x: hidden;
      }
      
      .cards-row .card {
        flex: 0 0 calc(50% - 9px);
      }
      
      .table-wrap {
        overflow-x: hidden;
      }
      
      .table-scroll {
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
    }
  </style>
<body>

  
    <?php include('./includes/header.php'); ?>
    <main class="main">

      <!-- CARDS -->
      <section class="cards-row">
        <div class="card col-12 col-lg-12">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <div class="title">Total Bookings</div>
<div class="value"><span class="sparkle"><?php echo $totalBookings; ?></span></div>
              <div class="muted">All time bookings</div>
            </div>
            <div class="text-end">
              <div style="background:var(--blush);width:56px;height:56px;border-radius:12px;display:flex;align-items:center;justify-content:center">
                <i class="bi bi-calendar-check" style="font-size:22px;color:var(--plum)"></i>
              </div>
            </div>
          </div>
        </div>

        <div class="card col-12 col-lg-12">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <div class="title">Monthly Revenue</div>
                <div class="value">
                    ₹ <span class="sparkle"><?php echo number_format($monthlyRevenue); ?></span>
                </div>
                <div class="muted">Revenue this month</div>
            </div>
            <div class="text-end">
              <div style="background:var(--blush);width:56px;height:56px;border-radius:12px;display:flex;align-items:center;justify-content:center">
                <i class="bi bi-currency-rupee" style="font-size:22px;color:var(--plum)"></i>
              </div>
            </div>
          </div>
        </div>

        <div class="card col-12 col-lg-12">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <div class="title">Active Services</div>
              <div class="value"><?php echo $activeServices; ?></div>
              <div class="muted">Bridal · Makeup · Hair · Mehendi · Nail Art</div>
            </div>
            <div class="text-end">
              <div style="background:var(--blush);width:56px;height:56px;border-radius:12px;display:flex;align-items:center;justify-content:center">
                <i class="bi bi-scissors" style="font-size:22px;color:var(--plum)"></i>
              </div>
            </div>
          </div>
        </div>

        <div class="card col-12 col-lg-12">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <div class="title">Website Impressions</div>
              <div class="value"><span class="sparkle"><?php echo $impressions; ?></span></div>
              <div class="muted">Total site visits</div>
            </div>
            <div class="text-end">
              <div style="background:var(--blush);width:56px;height:56px;border-radius:12px;display:flex;align-items:center;justify-content:center">
                <i class="bi bi-eye" style="font-size:22px;color:var(--plum)"></i>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- RECENT APPOINTMENTS -->
      <section class="table-wrap">
        <div style="padding:18px 20px;display:flex;justify-content:space-between;align-items:center">
          <div>
            <h5 style="margin:20px;color:var(--plum);font-weight:700">Recent Appointments</h5>
            <div style="font-size:.9rem;color:#7a5f66">Latest bookings</div>
          </div>
          <div>
            <a href="booking_in.php">
            <button class="btn btn-sm" style="background:var(--mauve);color:#fff;border:0;border-radius:10px;height: 40px;"><i class="bi-plus"></i> Add Booking</button>
            </a>
          </div>
        </div>

        <div style="padding:0 18px 18px 18px;">
          <div class="table-scroll">
            <table class="table mb-0">
            <thead>
              <tr>
                <th>Id</th>
                <th>Client Name</th>
                <th>Email</th>
                <th>Category</th>
                <th>Service</th>
                <th>Date</th>
                <th>Amount</th>
              </tr>
            </thead>

    <?php
    if(mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
    ?>
        <tr>
            <td data-label="Id">
                <?php echo $row['id']; ?>
            </td>
            <td data-label="Client Name">
                <?php echo $row['name']; ?>
            </td>
            <td data-label="Email">
                <?php echo $row['email']; ?>
            </td>
            <td data-label="Category">
              <?php echo $row['category_name']; ?>
            </td>
            <td data-label="Service">
              <?php echo $row['service_name']; ?>
            </td>
            <td data-label="Date">
                <?php echo $row['date']; ?>
            </td>
            <td data-label="Amount">
                ₹ <?php echo $row['price']; ?>
            </td>
    <?php
        }
    } else {
        echo '<tr><td colspan="7" style="text-align:center">No Categories found</td></tr>';
    }
    ?>
            </tbody>
            </table>
          </div>
        </div>
      </section>

      <div class="bottom-space"></div>
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
