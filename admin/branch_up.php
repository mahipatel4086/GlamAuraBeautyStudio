<?php
include("./conn.php");
session_start();

if (!isset($_SESSION['admin']) || empty($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

$id = $_GET['branch_id'];

// Fetch old data
$old = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM branches WHERE branch_id='$id'"));

if (!$old) {
    die("Invalid Branch ID");
}
$location    = $_POST['uplocation']      ?? $old['location'];
$city_name   = $_POST['upcity_name']     ?? $old['city_name'];
$phone       = $_POST['uphone']          ?? $old['phone'];
if (!preg_match("/^[0-9]{10}$/", $phone)) {
    echo "<script>alert('Phone number must be exactly 10 digits'); history.back();</script>";
    exit;
}
$email       = $_POST['upemail']         ?? $old['email'];
$op_time     = $_POST['upopening_time']  ?? $old['opening_time'];
$co_time     = $_POST['upclosing_time']  ?? $old['closing_time'];
$status      = $_POST['upstatus']        ?? $old['status'];
$image       = $_POST['upimage']         ?? $old['image'];

if (isset($_POST['btn_update'])) {

    $query = "UPDATE branches SET
        image='$image',
        location='$location',
        city_name='$city_name',
        phone='$phone',
        email='$email',
        opening_time='$op_time',
        closing_time='$co_time',
        status='$status'
        WHERE branch_id='$id'";

    if (mysqli_query($conn, $query)) {
        header("Location: branch.php");
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
    <title>Update Branch</title>

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
       .btn-row {
    display: flex;
    justify-content: space-between;
    gap: 35px;
    margin-top: 30px;
}

/* SAME styling for both */
.btn-row input[type="submit"],
.btn-row .btn-dashboard {
    width: 100%;
    padding: 12px;
    background: #a96461;
    color: white;
    border: none;
    font-size: 16px;
    font-weight: 700;
    border-radius: 10px;
    box-shadow: 0 5px 12px rgba(71, 38, 52, 0.2);
    transition: 0.3s ease;
    text-align: center;
    cursor: pointer;
    display: block;
    text-decoration: none; /* underline hatane ke liye */
}

/* Hover effect for both */
.btn-row input[type="submit"]:hover,
.btn-row .btn-dashboard:hover {
    opacity: 0.9;
    transform: translateY(-2px);
}

        
    </style>
</head>
<body>

<?php include('./includes/header.php'); ?>

<main class="main">
    <div class="form-container">
        <h3 style="color:var(--plum);font-weight:700;">Update Branch</h3>

        <form method="POST" action="">
            <div class="form-grid">

                 <div>
                    <label>Image:</label>
                    <input type="file" name="upimage" value="<?= $image ?>" required>
                </div>

                <div>
                    <label>Location :</label>
                    <input type="text" name="uplocation" value="<?= $location ?>" required>
                </div>

                <div>
                <label>City:</label>
                <select name="upcity_name" required>
                    <option value="">Select City</option>
                    <option value="Surat"<?php if($city_name == "Surat") echo "selected"; ?>>Surat</option>
                    <option value="Rajkot"<?php if($city_name == "Rajkot") echo "selected"; ?>>Rajkot</option>
                    <option value="Ahemdabad"<?php if($city_name == "Ahemdabad") echo "selected"; ?>>Ahemdabad</option>
                    <option value="Bharuch"<?php if($city_name == "Bharuch") echo "selected"; ?>>Bharuch</option>
                    <option value="Valsad"<?php if($city_name == "Valsad") echo "selected"; ?>>Valsad</option>
                    <option value="Vadodara"<?php if($city_name == "Vadodara"   ) echo "selected"; ?>>Vadodara</option>
                    <option value="Gandhinagar"<?php if($city_name == "Gandhinagar") echo "selected"; ?>>Gandhinagar</option>                
                    <option value="Bhavnagar"<?php if($city_name == "Bhavnagar") echo "selected"; ?>>Bhavnagar</option>
                  </select>
            </div>

                <div>
                    <label>Phone :</label>
                    <input type="text" name="uphone" value="<?= $phone ?>" required>
                </div>

                <div>
                    <label>Email :</label>
                    <input type="email" name="upemail" value="<?= $email ?>" required>
                </div>

                <div>
            <label>Opening Time:</label>
            <input type="time" name="upopening_time" value="<?= $old['opening_time']; ?>" required>
        </div>

        <div>
            <label>Closing Time:</label>
            <input type="time" name="upclosing_time" value="<?= $old['closing_time']; ?>" required>
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
            <input type="submit" value="Update Branch" name="btn_update">
            <a href="branch.php" class="btn-dashboard">Dashboard</a>
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
