<?php
include('./conn.php');
session_start();

if(!isset($_SESSION['admin']) || empty($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

$id = $_GET['offer_id'];

// Fetch existing offer
$sql = "SELECT * FROM tbl_offer WHERE offer_id = $id";
$result = mysqli_query($conn, $sql);
$data = mysqli_fetch_assoc($result);

$offer_title = $data['offer_title'];
$offer_description = $data['offer_description'];
$discount_value = $data['discount_value'];
$start_date = $data['start_date'];
$end_date = $data['end_date'];
$image = $data['offer_image'];
$status = $data['status'];

if (isset($_POST['btn_update'])) {

    $up_title = $_POST['up_title'];
    $up_description = $_POST['up_description'];
    $up_discount = $_POST['up_discount'];
    $up_start = $_POST['up_start'];
    $up_end = $_POST['up_end'];
    $old_image = $image;

    // Handle image upload
    if (!empty($_FILES['up_image']['name'])) {
        $new_image = $_FILES['up_image']['name'];
        $tmp = $_FILES['up_image']['tmp_name'];

        $upload_path = "uploads/offer/";

        if (!file_exists($upload_path)) {
            mkdir($upload_path, 0777, true);
        }

        move_uploaded_file($tmp, $upload_path . $new_image);
    } else {
        $new_image = $old_image;
    }

    $up_status = $_POST['up_status'];

    // Update query
    $sql_update = "UPDATE tbl_offer SET
        offer_title = '$up_title',
        offer_description = '$up_description',
        discount_value = '$up_discount',
        start_date = '$up_start',
        end_date = '$up_end',
        offer_image = '$new_image',
        status = '$up_status'
        WHERE offer_id = $id";

    if (mysqli_query($conn, $sql_update)) {
        header("Location: offer.php");
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
    <title>Update Offer</title>
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
        <h3>Update Offer</h3>
        <form method="POST" action="" enctype="multipart/form-data">
            <div class="form-grid">

                <div>
                    <label>Offer Title:</label>
                    <input type="text" name="up_title" value="<?php echo htmlspecialchars($offer_title); ?>" required />
                </div>

                <div>
                    <label>Discount (%):</label>
                    <input type="number" step="0.01" name="up_discount" value="<?php echo $discount_value; ?>" required />
                </div>

                <div class="full">
                    <label>Description:</label>
                    <input type="text" name="up_description" value="<?php echo htmlspecialchars($offer_description); ?>" required />
                </div>

                <div>
                    <label>Start Date:</label>
                    <input type="date" name="up_start" value="<?php echo date('Y-m-d', strtotime($start_date)); ?>" required />
                </div>

                <div>
                    <label>End Date:</label>
                    <input type="date" name="up_end" value="<?php echo date('Y-m-d', strtotime($end_date)); ?>" required />
                </div>

                <div>
                    <label>Image:</label>
                    <input type="file" name="up_image" />
                    <?php if(!empty($image)) { ?>
                        <div style="margin-top:5px;">
                            <img src="uploads/offer/<?php echo htmlspecialchars($image); ?>" width="80" style="border-radius:8px;object-fit:cover;">
                        </div>
                    <?php } ?>
                </div>

                <div>
                    <label>Status:</label>
                    <select name="up_status" required>
                        <option value="1" <?php if($status == 1) echo "selected"; ?>>Active</option>
                        <option value="2" <?php if($status == 2) echo "selected"; ?>>Inactive</option>
                    </select>
                </div>

            </div>

            <div class="btn-row">
                <input type="submit" value="Update Offer" name="btn_update">
                <a href="offer.php" class="btn-dashboard">Dashboard</a>
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
