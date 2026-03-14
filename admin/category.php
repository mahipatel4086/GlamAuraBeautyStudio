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

    // search query
    $sql = "SELECT * FROM tbl_categories 
            WHERE name LIKE '%$search%' 
            OR status LIKE '%$search%' 
            ORDER BY id DESC";
} else {
    // default: show all
    $sql = "SELECT * FROM tbl_categories ORDER BY id DESC";
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
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
  <link href="admin.css" rel="stylesheet">
  <style>
     .sidebar {
      margin-top: 7.9px;
      }

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

      <section class="table-wrap">
        <div style="padding:18px 20px;display:flex;justify-content:space-between;align-items:center">
          <div>
            <h4 style="margin:20px;color:var(--plum);font-weight:700">All Categories Records</h4>
            <!-- <div style="font-size:.9rem;color:#7a5f66">Latest bookings & statuses</div> -->
          </div>
          <div>
            <a href="category_in.php">
            <button class="btn btn-sm" style="background:var(--mauve);color:#fff;border:0;border-radius:10px;height: 40px;"><i class="bi-plus"></i>Add Category</button>
            </a>
          </div>
        </div>

        <div style="padding:0 18px 18px 18px;">
          <div class="table-scroll">
            <table class="table mb-0">
  <thead>
    <tr>
      <th>Category Name</th>
      <th>Description</th>
      <th>Status</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    <?php
    if(mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
    ?>
        <tr>
            <td data-label="Category">
                <div style="display:flex;gap:10px;align-items:center">                    
                    <img src="uploads/category/<?php echo htmlspecialchars($row['image'], ENT_QUOTES, 'UTF-8'); ?>" 
                        width="44" height="44" 
                        style="border-radius:8px;object-fit:cover">
                    <div>
                        <div style="font-weight:700;color:var(--plum)">
                            <?php echo $row['name']; ?>
                        </div>
                    </div>
                </div>
            </td>
            <td data-label="Description">
                <?php echo $row['description']; ?>
            </td>
            <td data-label="Status">
                <?php if($row['status'] == 1) { ?>
                    <span class="badge-status bs-completed">Active</span>
                <?php } else { ?>
                    <span class="badge-status bs-pending">Inactive</span>
                <?php } ?>
            </td>
          <td>
            <a class="update-btn" href="category_up.php?id=<?php echo $row['id']; ?>"><i class="bi-pencil"></i></a>
            <a class="delete-btn" href="category_de.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this record?');"><i class="bi-trash"></i></a>

          </td>
        </tr>
    <?php
        }
    } else {
        echo '<tr><td colspan="4" style="text-align:center">No Categories found</td></tr>';
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

  <!-- Chart script -->
  <script>
    document.getElementById("searchBox").addEventListener("keydown", function(e) {
    if (e.key === "Enter") {
        if (this.value.trim() === "") {
            // Empty search → redirect to page without ?search=
            window.location = "category.php";
            e.preventDefault();
        }
    }
});
  </script>
</body>
</html>
