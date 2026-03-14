<?php
include('./conn.php');
session_start();

if(!isset($_SESSION['admin']) || empty($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}
$id = $_GET['id'];

// Fetch existing category first (so $image exists)
$sql = "SELECT * FROM tbl_categories WHERE id = $id";
$result = mysqli_query($conn, $sql);
$data = mysqli_fetch_assoc($result);

$name = $data['name'];
$description = $data['description'];
$features = $data['features'];
$image = $data['image'];
$status = $data['status'];

if (isset($_POST['btn_update'])) {

    $upname = $_POST['upname'];
    $updescription = $_POST['updescription'];
    $upfeatures = $_POST['upfeatures'];
    $old_image = $image;

    // If a new image is uploaded
    if (!empty($_FILES['upimage']['name'])) {
        $new_image = $_FILES['upimage']['name'];
        $tmp = $_FILES['upimage']['tmp_name'];

        // Upload folder
        $upload_path = "admin/uploads/category/";

        // Create folder if not exists
        if (!file_exists($upload_path)) {
            mkdir($upload_path, 0777, true);
        }

        move_uploaded_file($tmp, $upload_path . $new_image);

    } else {
        // Keep old image
        $new_image = $old_image;
    }

    $upstatus = $_POST['upstatus'];
    $upfeatures = $_POST['upfeatures'];
    // Correct update query
    $sql_update = "UPDATE tbl_categories SET  
        name = '$upname',
        description = '$updescription',
        features = '$upfeatures',
        image = '$new_image',
        status = '$upstatus'
        WHERE id = $id";

    // Correct mysqli_query()
    if (mysqli_query($conn, $sql_update)) {
        header("Location: category.php");
        exit();
    } else {
        echo "<p style='color:red;'>Error: " . mysqli_error($conn) . "</p>";
    }
}
?>

 <!DOCTYPE html>
 <html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
      <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&family=Playfair+Display:wght@600&display=swap" rel="stylesheet">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="admin.css">
    <title>Update Category</title>
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
        <h3>Update Category </h3>
        <form method="POST" action="" enctype="multipart/form-data">
          <div class="form-grid">
            <div>
              <label>Name :</label>
              <input type="text" name="upname" value="<?php echo $name;?>" required />
            </div>
            <div class="full">
                <label>Description :</label>
                <input type="text" name="updescription" value="<?php echo $description;?>" required />
            </div>
            <div class="full">
                <label>Features :</label>
                <input type="text" name="upfeatures" value="<?php echo $features;?>" required />
            </div>
            <div>
                <label>Image :</label>
                <input type="file" name="upimage" />
            </div>
            <div>
                <label>Status :</label>
                <select name="upstatus" required>
                    <option value="1" <?php if($status == 1) echo "selected"; ?>>Active</option>
                    <option value="2" <?php if($status == 2) echo "selected"; ?>>Inactive</option>
                </select>
            </div>
          </div>
          <div class="btn-row">
            <input type="submit" value="Update Category" name="btn_update">
            <a href="category.php" class="btn-dashboard">Dashboard</a>
          </div>
        </form>
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
