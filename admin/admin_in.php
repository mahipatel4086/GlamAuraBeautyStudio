<?php
include('./conn.php');
session_start();

if(!isset($_SESSION['admin']) || empty($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

if (isset($_POST['btn_addAdmin'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];
    $status   = $_POST['status'];
    $created  = date("Y-m-d H:i:s");

    $insert = mysqli_query($conn,
        "INSERT INTO tbl_admin (username, password, status, created_at)
         VALUES ('$username', '$password', '$status', '$created')"
    );

    if ($insert) {
        header("Location: admin.php");
        exit();
    } else {
        echo "<p style='color:red'>Error: " . mysqli_error($conn) . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Admin</title>
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
    <!-- FORM -->
    <div class="form-container">
      <h3>Add New Admin</h3>

      <form method="POST" action="">
        <div class="form-grid">

          <div>
            <label>Username:</label>
            <input type="text" name="username" required />
          </div>

          <div>
            <label>Password:</label>
            <input type="text" name="password" required />
          </div>

          <div>
            <label>Status:</label>
            <select name="status" required>
                <option value="1">Active</option>
                <option value="0">Inactive</option>
            </select>
          </div>

        </div>

        <div class="btn-row">
          <input type="submit" value="Add Admin" name="btn_addAdmin">
          <a href="admin.php" class="btn-dashboard">Dashboard</a>
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
