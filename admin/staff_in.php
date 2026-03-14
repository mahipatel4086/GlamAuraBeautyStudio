<?php
    include('conn.php');
    session_start();

if(!isset($_SESSION['admin']) || empty($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}
$search = "";

if (isset($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);

    // search query
    $sql = "SELECT * FROM tbl_staff 
            WHERE name LIKE '%$search%' 
            OR role LIKE '%$search%' 
            OR services LIKE '%$search%'
            OR status LIKE '%$search%'
            OR experience LIKE '%$search%'
            ORDER BY id DESC";
} else {
    // default: show all
    $sql = "SELECT * FROM tbl_staff ORDER BY id DESC";
}

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Staff</title>
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
    <h3>Add New Staff</h3>
    <form method="POST" action="" enctype="multipart/form-data">
        <div class="form-grid">
            <div>
                <label>Name :</label>
                <input type="text" name="name" required />
            </div>
            <div>
                <label>Experience :</label>
                <input type="text" name="experience" required />
            </div>
            <div>
                <label>Role :</label>
                <input type="text" name="role" required />
            </div>
            <div>
                <label>Services :</label>
                <input type="text" name="services" required />
            </div>
            <div>
                <label>Image :</label>
                <input type="file" name="image" required />
            </div>
            <div>
                <label>Status :</label>
                <select name="status" required>
                    <option value="1">Active</option>
                    <option value="2">Inactive</option>
                </select>
            </div>
        </div>
          <div class="btn-row">
              <input type="submit" value="Add Staff" name="btn_addData">
              <a href="staff.php" class="btn-dashboard">Dashboard</a>
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

</body>
</html>


<?php
if (isset($_POST['btn_addData'])) {

    // Upload Image
    $image = $_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];

    $folder = "uploads/staff/";

     // Create the directory if it doesn't exist
    if(!is_dir($folder)) {
        mkdir($folder, 0777, true);
    }

    if(!empty($image)) {
        move_uploaded_file($tmp, $folder . $image);
    }

    $name = $_POST['name'];
    $experience = $_POST['experience'];
	$role = $_POST['role'];
    $services = $_POST['services'];
    $status = $_POST['status'];

    // Insert query for tbl_services
    $sql = "INSERT INTO tbl_staff 
            ( name,experience, role, services, image, status, created_at)
            VALUES 
            ('$name', '$experience', '$role', '$services', '$image', '$status', NOW())";

    $res = mysqli_query($conn, $sql);

    if ($res) {
        header("Location: staff.php");
        exit();
    } else {
        echo "Data not added... Error: " . mysqli_error($conn);
    }
}
?>
