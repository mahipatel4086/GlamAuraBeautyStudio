<?php
    include('./conn.php');

    if (!isset($_GET['offer_id']) || !is_numeric($_GET['offer_id'])) {
        die("Invalid ID");
    }

    $id = intval($_GET['offer_id']);   // Convert to integer (prevents SQL injection)

    $sql = "DELETE FROM tbl_offer WHERE offer_id = $id";
    $r = mysqli_query($conn, $sql);

    if ($r) {
        header("Location: offer.php");
        exit();
    } else {
        echo "Deleting error: " . mysqli_error($conn);
    }
?>
