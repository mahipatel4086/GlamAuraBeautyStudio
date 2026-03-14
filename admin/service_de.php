<?php
include('./conn.php');

if (!isset($_GET['service_id']) || !is_numeric($_GET['service_id'])) {
    die("Invalid ID");
}

$id = intval($_GET['service_id']);   // Convert to integer (prevents SQL injection)
$sql = "DELETE FROM tbl_services WHERE service_id = $id";
$r = mysqli_query($conn, $sql);

if ($r) {
    header("Location: http://localhost/internship/cosmetic_website/admin/service.php");
    exit();
} else {
    echo "Deleting error: " . mysqli_error($conn);
}
?>
