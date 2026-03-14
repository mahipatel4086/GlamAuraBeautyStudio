<?php
include ('./conn.php');
session_start();

if(!isset($_SESSION['admin']) || empty($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

$search = "";

if (isset($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);

    $sql = "SELECT *
            FROM tbl_offer
            WHERE status = 1
            AND DATE(end_date) >= CURDATE()
            AND offer_title LIKE '%$search%'
            ORDER BY offer_id DESC";
} else {
    $sql = "SELECT *
            FROM tbl_offer
            WHERE status = 1
            AND DATE(end_date) >= CURDATE()
            ORDER BY offer_id DESC";
}

$result = $conn->query($sql);
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Glam Studio — Admin Dashboard</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&family=Playfair+Display:wght@600&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link href="admin.css" rel="stylesheet">

  <style>
     .sidebar { margin-top: 7.9px; }

    td { vertical-align: middle; }

    td a.update-btn,
    td a.delete-btn {
      display: inline-block;
      margin-right: 6px;
    }

    td:last-child { white-space: nowrap; }

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

<section class="table-wrap">

  <div style="padding:18px 20px;display:flex;justify-content:space-between;align-items:center">
      <div>
        <h4 style="margin:20px;color:var(--plum);font-weight:700">All Offers Records</h4>
      </div>

      <div>
        <a href="offer_in.php">
        <button class="btn btn-sm" style="background:var(--mauve);color:#fff;border:0;border-radius:10px;height: 40px;">
          <i class="bi-plus"></i>Add Offer
        </button>
        </a>
      </div>
  </div>

  <div style="padding:0 18px 18px 18px;">
    <div class="table-scroll">
      <table class="table mb-0">
  <thead>
    <tr>
      <th>Offer Name</th>
      <th>Starting Date</th>
      <th>Ending Date</th>
      <th>Offer Value</th>
      <th>Status</th>
      <th>Action</th>
    </tr>
  </thead>

  <tbody>
    <?php
    if(mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {

            // auto-expire logic
            $today = date('Y-m-d H:i:s');
            if ($today > $row['end_date'] && $row['status'] == 1) {
                $conn->query("UPDATE tbl_offer SET status = 2 WHERE offer_id = ".$row['offer_id']);
                $row['status'] = 2;
            }
    ?>
        <tr>

            <!-- Image + Offer Name -->
            <td>
                <div style="display:flex;gap:10px;align-items:center">
                    <img src="uploads/offer/<?php echo htmlspecialchars($row['offer_image']); ?>" 
                         width="44" height="44"
                         style="border-radius:8px;object-fit:cover">
                    <div>
                        <div style="font-weight:700;color:var(--plum)">
                            <?php echo $row['offer_title']; ?>
                        </div>
                    </div>
                </div>
            </td>
            <!-- Starting Date -->
            <td><?php echo date('d M Y', strtotime($row['start_date'])); ?></td>
            <!-- Ending Date -->
            <td><?php echo date('d M Y', strtotime($row['end_date'])); ?></td>
            <!-- Offer Value -->
            <td>
                <?php 
                    if ($row['discount_type'] == 'per') {
                        echo $row['discount_value'] . '%';
                    } else {
                        echo '$' . number_format($row['discount_value'], 2);
                    }
                ?>

            <!-- Status -->
            <td>
                <?php if($row['status'] == 1) { ?>
                    <span class="badge-status bs-completed">Active</span>
                <?php } else { ?>
                    <span class="badge-status bs-pending">Inactive</span>
                <?php } ?>
            </td>

            <!-- Action Buttons -->
            <td>
                <a class="update-btn" href="offer_up.php?offer_id=<?php echo $row['offer_id']; ?>">
                    <i class="bi-pencil"></i>
                </a>
                <a class="delete-btn" 
                   href="offer_de.php?offer_id=<?php echo $row['offer_id']; ?>" 
                   onclick="return confirm('Are you sure you want to delete this offer?');">
                   <i class="bi-trash"></i>
                </a>
            </td>

        </tr>
    <?php
        }
    } else {
        echo '<tr><td colspan="6" style="text-align:center">No Offers Found</td></tr>';
    }
    ?>
  </tbody>
      </table>
    </div>
  </div>

</section>

<div class="bottom-space"></div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
