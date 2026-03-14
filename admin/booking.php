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
           ct.city_name AS city_name
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
    ORDER BY b.id DESC";

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
    ORDER BY b.id DESC";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Glam Studio — Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&family=Playfair+Display:wght@600&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="admin.css" >
  <style>
        
    td {
    vertical-align: middle;
    }

    td a.update-btn,
    td a.delete-btn {
    display: inline-block;   /* already okay */
    margin-right: 6px;       /* spacing */
    }

    td:last-child {
    white-space: nowrap;     /* buttons ko wrap hone se roke */
    }

    .update-btn {
      background: var(--mauve);
      color: white;
      padding: 4px 16px;
      text-decoration: none !important;
      display: inline-block;
      margin-right: 8px;
      border-radius: 9px;
    }
    .delete-btn {
      background: #d9534f;
      color: white;
      padding: 4px 16px;
      text-decoration: none !important;
      display: inline-block;
      border-radius: 9px;
    }
    
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
</head>
<body>
 <?php include('./includes/header.php'); ?>
    <main class="main">
      <!-- RECENT APPOINTMENTS -->
      <section class="table-wrap">
        <div style="padding:18px 20px;display:flex;justify-content:space-between;align-items:center">
          <div>
            <h4 style="margin:20px;color:var(--plum);font-weight:700">RECENT APPOINTMENTS</h4>
          </div>
          <div>
            <a href="booking_in.php">
            <button class="btn btn-sm" style="background:var(--mauve);color:#fff;border:0;border-radius:10px;height: 40px;"><i class="bi-plus"></i>Add Appointment</button>
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
      <th>Contact Number</th>
      
      <th>Category</th>
      <th>Service</th>
      <th>Date</th>
      <th>Time</th>
      <th>Price</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
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
            <td data-label="Contact Number">
                <?php echo $row['phone']; ?>
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
            <td data-label="Time">
                <?php echo $row['time']; ?>
            </td>
            <td data-label="Price">
                <?php echo $row['price']; ?>
            </td>
          <td>
            <a class="update-btn" href="booking_up.php?id=<?php echo $row['id']; ?>"><i class="bi-pencil"></i></a>
            <a class="delete-btn" href="booking_de.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this record?');"><i class="bi-trash"></i></a>

          </td>
        </tr>
    <?php
        }
    } else {
        echo '<tr><td colspan="10" style="text-align:center">No Appointments found</td></tr>';
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
</body>
</html>
