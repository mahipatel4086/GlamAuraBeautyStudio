<?php
    include('./conn.php');

    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        die("Invalid ID");
    }

    $id = intval($_GET['id']);   // Convert to integer (prevents SQL injection)

    $sql = "DELETE FROM tbl_staff WHERE id = $id";
    $r = mysqli_query($conn, $sql);

    if ($r) {
        header("Location: staff.php");
        exit();
    } else {
        echo "Deleting error: " . mysqli_error($conn);
    }
?>
