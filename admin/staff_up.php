<?php
  include('./conn.php');
  session_start();

if(!isset($_SESSION['admin']) || empty($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}
  $id = $_GET['id'];
  if(isset($_POST['btn_update'])){
    $upname = $_POST['upname'];
    $upexperience = $_POST['upexperience'];
    $uprole = $_POST['uprole'];
    $upservices = $_POST['upservices'];
    // Get old image
    $old_image = $image;

    // Check if new image selected
    if (!empty($_FILES['upimage']['name'])) {

        // new image
        $new_image = $_FILES['upimage']['name'];
        $tmp = $_FILES['upimage']['tmp_name'];

        // upload new image
        move_uploaded_file($tmp, "uploads/staff/" . $new_image);

    } else {
        // No new image selected → keep old
        $new_image = $old_image;
    }
    $upstatus = $_POST['upstatus'];

    $sql_update = "UPDATE tbl_staff SET  
        name = '$upname',
        experience = '$upexperience',
        role = '$uprole',
        services = '$upservices',
        image = '$new_image',
        status= '$upstatus'
        WHERE id = $id";

    $result_update = mysqli_query($conn,$sql_update);

    if ($result_update) {
        header("Location: staff.php");
        exit();
    } else {
        echo "Insert Error";
        exit();
    }
  }

// Fetch existing data for the form
  $sql= "SELECT * FROM tbl_staff WHERE id = $id ";
  $result = mysqli_query($conn,$sql);

  while($data = mysqli_fetch_row($result)){
      $name = $data[1];      
      $experience = $data[2];
      $role = $data[3];
      $services = $data[4];
      $image = $data[5];
      $status = $data[6];
      $created_at = $data[7];
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
    <title>Update Services</title>
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
        <h3>Update Staff </h3>
        <form method="POST" action="" enctype="multipart/form-data">
          <div class="form-grid">
            <div>
              <label>Name :</label>
              <input type="text" name="upname" value="<?php echo $name;?>" required />
            </div>
            <div>
                <label>Experience :</label>
                <input type="text" name="upexperience" value="<?php echo $experience;?>" required />
            </div>
            <div>
                <label>Role :</label>
                <input type="text" name="uprole" value="<?php echo $role;?>" required />
            </div>
            <div>
                <label>Services :</label>
                <input type="text" name="upservices" value="<?php echo $services;?>" required />
            </div>
            <div>
                <label>Image :</label>
                <input type="file" name="upimage" required />
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
            <input type="submit" value="Update Staff" name="btn_update">
            <a href="staff.php" class="btn-dashboard">Dashboard</a>
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
