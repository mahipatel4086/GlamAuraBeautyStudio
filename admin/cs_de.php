<?php
    include('./conn.php');

    if (!isset($_GET['cs_id']) || !is_numeric($_GET['cs_id'])) {
        die("Invalid ID");
    }

    $id = intval($_GET['cs_id']);   // Convert to integer (prevents SQL injection)
    $sql = "DELETE FROM tbl_cs WHERE cs_id = $id";
    $r = mysqli_query($conn, $sql);

    if ($r) {
         header("Location: cs.php");
        exit();
    } else {
        echo "Deleting error: " . mysqli_error($conn);
    }
?>
