<?php
    include('./conn.php');

    if (!isset($_GET['customer_id']) || !is_numeric($_GET['customer_id'])) {
        die("Invalid ID");
    }

    $id = intval($_GET['customer_id']);   // Convert to integer (prevents SQL injection)
    $sql = "DELETE FROM tbl_customer WHERE customer_id = $id";
    $r = mysqli_query($conn, $sql);

    if ($r) {
         header("Location: customer.php");
        exit();
    } else {
        echo "Deleting error: " . mysqli_error($conn);
    }
?>
