<?php
include('./conn.php');
session_start();

if (!isset($_SESSION['admin']) || empty($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}
$search = "";

// SEARCH
if (isset($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);

    $sql = "
        SELECT branch_id, location, city_name, phone, email, 
        FROM branches
        WHERE 
            location LIKE '%$search%' OR
            email LIKE '%$search%' OR
            status LIKE '%$search%' OR
            city_name LIKE '%$search%'
        ORDER BY branch_id DESC
    ";
} else {
    // DEFAULT VIEW
    $sql = "
        SELECT branch_id,image, location, city_name, phone, email, opening_time, closing_time, status
        FROM branches
        ORDER BY branch_id DESC
    ";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Glam Studio — Branches</title>
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&family=Playfair+Display:wght@600&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="admin.css">

  <style>
    .sidebar {
      background: #9F6771;
      color:#fff;
      border-radius: 16px;
      padding: 22px;
      height: calc(100vh - 56px);
      position: sticky;
      top: 20px;
      margin-left: -30px;
      margin-top: 9px;
      padding-bottom: 70px;  
      min-height: calc(100vh - 30px); 
      box-shadow: 0 20px 50px rgba(71,38,52,0.28);
    }
    td { vertical-align: middle; }
    td:last-child { white-space: nowrap; }

    .update-btn {
      background: var(--mauve);
      color: white;
      padding: 4px 16px;
      border-radius: 9px;
      text-decoration: none;
      margin-right: 8px;
    }
    .delete-btn {
      background: #d9534f;
      color: white;
      padding: 4px 16px;
      border-radius: 9px;
      text-decoration: none;
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
      <h4 style="margin:20px;color:var(--plum);font-weight:700">BRANCH LIST</h4>

      <a href="branch_in.php">
        <button class="btn btn-sm" style="background:var(--mauve);color:#fff;border:0;border-radius:10px;height:40px;">
          <i class="bi-plus"></i> Add Branch
        </button>
      </a>
  </div>

  <div style="padding:0 18px 18px 18px;">
    <div class="table-scroll">
      <table class="table mb-0">
      <thead>
        <tr>
          <th>ID</th>
          <th>Branch Image</th>
          <th>Address</th>
          <th>City</th>
          <th>Phone</th>
          <th>Email</th>
          <th>Open</th>
          <th>Close</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>

      <tbody>
        <?php
         if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
          ?>
          <tr>
            <td><?php echo $row['branch_id']; ?></td>
            <td data-label="branch">
                <div style="display:flex;gap:10px;align-items:center">                    
                    <img src="uploads/branch/<?php echo $row['image']; ?>" 
                         width="44" height="44" 
                         style="border-radius:8px;object-fit:cover">
                    <div>
                        <div style="font-weight:700;color:var(--plum)">
                           
                        </div>
                    </div>
                </div>
            </td>
            <td><?php echo $row['location']; ?></td>
            <td><?php echo $row['city_name']; ?></td>
            <td><?php echo $row['phone']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['opening_time']; ?></td>
            <td><?php echo $row['closing_time']; ?></td>
             <td data-label="Status">
                <?php if($row['status'] == 1) { ?>
                    <span class="badge-status bs-completed">Active</span>
                <?php } else { ?>
                    <span class="badge-status bs-pending">Inactive</span>
                <?php } ?>
            </td>
          
            <td>
              <a class="update-btn" href="branch_up.php?branch_id=<?php echo $row['branch_id']; ?>">
                <i class="bi-pencil"></i>
              </a>

              <a class="delete-btn" 
                onclick="return confirm('Are you sure to delete?');"
                href="branch_de.php?branch_id=<?php echo $row['branch_id']; ?>">
                <i class="bi-trash"></i>
              </a>
            </td>
          </tr>
        <?php
          }
        } else {
          echo '<tr><td colspan="10" style="text-align:center;">No branches found</td></tr>';
        }
        ?>
      </tbody>
      </table>
    </div>
  </div>

</section>

<div class="bottom-space"></div>
</main>

</body>
</html>
