<?php
include 'conn.php';
session_start();

if(!isset($_SESSION['admin']) || empty($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}
$sql = "SELECT * FROM tbl_reviews ORDER BY id DESC";
$result = $conn->query($sql);
?>
<!doctype html>
<html lang="en">
<head>
  <style>
  
 .cards-row{display:grid;grid-template-columns:repeat(4,1fr);gap:18px;margin-top:18px}
    .card {
      border-radius: var(--card-radius);
      padding:18px;
      background: #ffffff;
      box-shadow: 0 14px 34px rgba(71,38,52,0.06);
      transition:transform .28s ease,box-shadow .28s ease;
      position:relative;
      overflow:hidden;
      width:1160px;
    }
   
  .table td, .table th {
    vertical-align: middle;
}

.table td {
    font-size: 0.95rem;
}

.table th {
    font-weight: 600;
}

  </style>
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
   <link href="a.css" rel="stylesheet">
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
            <h4 style="margin:20px;color:var(--plum);font-weight:700">Recent Reviews</h4>
            <!-- <div style="font-size:.9rem;color:#7a5f66">Latest bookings & statuses</div> -->
          </div>
          <div>
            <a href="service_in.php">
            <button class="btn btn-sm" style="background:var(--mauve);color:#fff;border:0;border-radius:10px;height: 40px;"><i class="bi-plus"></i>Add Review</button>
            </a>
          </div>
        </div>

        <div style="padding:0 18px 18px 18px;">
          <div class="table-scroll">
            <table class="table mb-0">
  <thead>
            <tr>
                <th>ID</th>
                <th>Reviewer Name</th>
                <th>Rating</th>
                <th>Review</th>
                <th>Date</th>
            </tr>
        </thead>

  <tbody>
    <?php
    if(mysqli_num_rows($result) > 0) {
        while($details = mysqli_fetch_assoc($result)) {
    ?>
            <tr>
                <td><?php echo $details['id']; ?></td>
                <td><?php echo $details['reviewer_name']; ?></td>
                <td>
                    <?php echo str_repeat("★", $details['rating']); ?>
                    (<?php echo $details['rating']; ?>)
                </td>
                <td><?php echo $details['review_text']; ?></td>
                <td><?php echo $details['created_at'] ?? ""; ?></td>
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
  </body>
</html>
