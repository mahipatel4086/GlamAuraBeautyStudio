<?php
    include('./conn.php');

    if (!isset($_GET['branch_id']) || !is_numeric($_GET['branch_id'])) {
        die("Invalid ID");
    }

    $id = intval($_GET['branch_id']);   // Convert to integer (prevents SQL injection)

    $sql = "DELETE FROM branches WHERE branch_id = $id";
    $r = mysqli_query($conn, $sql);

    if ($r) {
        header("Location: branch.php");
        exit();
    } else {
        echo "Deleting error: " . mysqli_error($conn);
    }
?>
