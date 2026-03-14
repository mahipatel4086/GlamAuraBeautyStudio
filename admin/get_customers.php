<?php
include ('./conn.php');

session_start();

if(!isset($_SESSION['admin']) || empty($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}
/* 1. SEND WHATSAPP REMINDER (ADDED — DOES NOT CHANGE YOUR CODE) */
if (isset($_GET['send_reminder']) && isset($_GET['cs_id'])) {

    $cs_id = $_GET['cs_id'];

    // fetch customer+service info
    $row = mysqli_fetch_assoc(mysqli_query($conn,
        "SELECT cs.next_service_date, c.c_name, c.phone, s.name AS service_name
        FROM tbl_cs cs
        JOIN tbl_customer c ON cs.customer_id = c.customer_id
        JOIN tbl_services s ON cs.service_id = s.service_id
        WHERE cs.cs_id = $cs_id "
    ));

    if ($row) {
        $name  = $row['c_name'];
        $phone = $row['phone'];
        $date  = $row['next_service_date'];

        $msg = urlencode("Hello $name, this is a reminder for your $service_name appointment on $date. Please visit on time.");

        // mark reminder as sent
        mysqli_query($conn,
            "UPDATE tbl_cs SET reminder_sent = 1 WHERE cs_id = $cs_id"
        );

        // redirect to WhatsApp
        header("Location: https://wa.me/91$phone?text=$msg");
        exit();
    }
}

$type = $_GET['type'] ?? '';
$data = [];


/* -----------------------------------------
   REMINDERS — NEW BLOCK (ADDED)
------------------------------------------*/
if ($type == "reminder") {

    $q = mysqli_query($conn,
        "SELECT cs.cs_id, cs.next_service_date, 
                c.c_name AS name, c.phone,
                s.name AS service_name
         FROM tbl_cs cs
         JOIN tbl_customer c ON cs.customer_id = c.customer_id
         JOIN tbl_services s ON cs.service_id = s.service_id
         WHERE cs.next_service_date IS NOT NULL
           AND cs.reminder_sent = 0
           AND TIMESTAMPDIFF(HOUR, NOW(), cs.next_service_date) <= 24
         ORDER BY cs.next_service_date ASC"
    );

    while ($row = mysqli_fetch_assoc($q)) {

        $msg = "Hello " . $row['name'] . "! This is a reminder for your next appointment for " .
                $row['service_name'] . " on " . $row['next_service_date'] . " - Glam Aura.";

        $data[] = [
            "name" => $row['name'],
            "phone" => $row['phone'],
            "message" => $msg,
            "cs_id" => $row['cs_id'],  
            "url" => "get_customer.php?send_reminder=1&cs_id=" . $row['cs_id']
        ];
    }

    echo json_encode($data);
    exit();
}

/* -----------------------------------------
   TODAY APPOINTMENTS
------------------------------------------*/
if ($type == "today") {

    $q = mysqli_query($conn,
        "SELECT b.name, b.phone, s.name AS service_name
         FROM tbl_booking b
         LEFT JOIN tbl_services s ON b.service_id = s.service_id
         WHERE DATE(b.date) = CURDATE()
         ORDER BY b.date ASC"
    );

/* -----------------------------------------
   TOMORROW APPOINTMENTS
------------------------------------------*/
} elseif ($type == "tomorrow") {

    $q = mysqli_query($conn,
        "SELECT b.name, b.phone, s.name AS service_name
         FROM tbl_booking b
         LEFT JOIN tbl_services s ON b.service_id = s.service_id
         WHERE DATE(b.date) = DATE_ADD(CURDATE(), INTERVAL 1 DAY)
         ORDER BY b.date ASC"
    );

/* -----------------------------------------
   MERGED CUSTOMERS (BOOKING + WALK-IN)
------------------------------------------*/
} else {

    $q = mysqli_query($conn,
        "SELECT name, phone FROM (
             SELECT b.name, b.phone FROM tbl_booking b
             UNION
             SELECT c.c_name AS name, c.phone FROM tbl_customer c
         ) merged
         ORDER BY name ASC"
    );
}

/* -----------------------------------------
   BUILD JSON
------------------------------------------*/
while ($row = mysqli_fetch_assoc($q)) {
    
    $msg = "Hello " . $row['name'] . "! this is a reminder from Glam Aura.";

    $data[] = [
        "name" => $row['name'],
        "phone" => $row['phone'],
        "message" => $msg
    ];
}

echo json_encode($data);
exit;
?>
