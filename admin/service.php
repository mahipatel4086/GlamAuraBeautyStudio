<?php
  include ('./conn.php');
  session_start();

if(!isset($_SESSION['admin']) || empty($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}
$search = isset($_GET['search']) ? $_GET['search'] : '';
$search = $conn->real_escape_string($search);

// Base query
$sql = "SELECT 
            s.service_id, 
            s.name, 
            c.name AS category_name, 
            s.price, 
            s.description,
            s.duration_minutes,
            s.image,
            s.status
        FROM tbl_services s
        LEFT JOIN tbl_categories c 
            ON s.category_id = c.id";

// Add search condition only if user typed something
if (!empty($search)) {
    $sql .= " WHERE 
                s.name LIKE '%$search%' 
                OR c.name LIKE '%$search%' 
                OR s.description LIKE '%$search%' ";
}

$sql .= " ORDER BY s.service_id DESC";

$result = $conn->query($sql);
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
      
      <!-- RECENT APPOINTMENTS -->
      <section class="table-wrap">
        <div style="padding:18px 20px;display:flex;justify-content:space-between;align-items:center">
          <div>
            <h4 style="margin:20px;color:var(--plum);font-weight:700">Recent Services</h4>
            <!-- <div style="font-size:.9rem;color:#7a5f66">Latest bookings & statuses</div> -->
          </div>
          <div>
            <a href="service_in.php">
            <button class="btn btn-sm" style="background:var(--mauve);color:#fff;border:0;border-radius:10px;height: 40px;"> <i class="bi-plus"></i> Add services</button>
            </a>
          </div>
        </div>

        <div style="padding:0 18px 18px 18px;">
          <div class="table-scroll">
            <table class="table mb-0">
  <thead>
    <tr>
      <th>Service Name</th>
      <th>Category Name</th>
      <th>Price</th>
      <th>status</th>
      <th>Duration</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    <?php
    if(mysqli_num_rows($result) > 0) {
        while($details = mysqli_fetch_assoc($result)) {
    ?>
    <tr>
            <td data-label="Service Name">
                <div style="display:flex;gap:10px;align-items:center">                    
                    <img src="uploads/services/<?php echo $details['image']; ?>" 
                        width="44" height="44" 
                        style="border-radius:8px;object-fit:cover">
                    <div>
                        <div style="font-weight:700;color:var(--plum)">
                            <?php echo $details['name']; ?>
                        </div>
                    </div>
                </div>
            </td>
            <td data-label="Category Name">
                <?php echo $details['category_name']; ?>
            </td>
            <td data-label="Price">
                rs. <?php echo number_format($details['price'], 2); ?>
            </td>
            <td data-label="Status">
                <?php if($details['status'] == 1) { ?>
                    <span class="badge-status bs-completed">Active</span>
                <?php } else { ?>
                    <span class="badge-status bs-pending">Inactive</span>
                <?php } ?>
            </td>
            <td data-label="Duration">
                <?php echo $details['duration_minutes']; ?> mins
            </td>
      <td>
        <a class="update-btn" href="service_up.php?service_id=<?php echo $details['service_id']; ?>"><i class="bi-pencil"></i></a>
        <a class="delete-btn" href="service_de.php?service_id=<?php echo $details['service_id']; ?>" onclick="return confirm('Are you sure you want to delete this record?');"><i class="bi-trash"></i></a>
                  
      </td>
    </tr>
    <?php
        }
    } else {
        echo '<tr><td colspan="6" style="text-align:center">No services found</td></tr>';
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

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <script>
        document.getElementById("serviceSearchBox").addEventListener("keydown", function(e) {
    if (e.key === "Enter") {
        if (this.value.trim() === "") {
            // Empty search → redirect to page without ?search=
            window.location = "service.php";
            e.preventDefault();
        }
    }
});

  </script>
</body>
</html>
