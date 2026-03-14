<?php
include ('./conn.php');

session_start();

if(!isset($_SESSION['admin']) || empty($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>WhatsApp Notifications</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&family=Playfair+Display:wght@600&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="admin.css" >
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
      
      .wn-cards {
        flex-direction: column;
        gap: 15px;
        overflow-x: hidden;
      }
      
      .wn-box {
        width: calc(100% - 20px);
        margin: 10px;
        padding: 20px;
        overflow-x: hidden;
      }
      
      .wn-box select {
        width: 100%;
      }
      
      .wn-modal-box {
        width: 90%;
        margin: 10% auto;
      }
      
      .btn {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        min-width: 0;
      }
    }

/* Page heading */
.wn-heading {
    font-size: 26px;
    font-weight: 700;
    color: var(--plum);
    margin-bottom: 25px;
    margin-top: 25px;
}

/* Cards Row Layout */
.wn-cards {
    display: flex;
    gap: 20px;
    margin-bottom: 35px;
}

.wn-card {
    flex: 1;
    background: #ffffff;
    border-radius: var(--card-radius);
    padding: 22px;
    box-shadow: 0 14px 34px rgba(71,38,52,0.06);
    border: 1px solid #f1dce1;
    transition: 0.25s ease;
}
.wn-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 26px 64px rgba(71,38,52,0.10);
}

.wn-card h3 {
    color: var(--plum);
    margin: 0 0 12px 0;
    font-size: 20px;
}

/* Buttons */
.wn-btn {
    background: var(--mauve);
    margin-top: 10px;
    color: white;
    padding: 10px 20px;
    border-radius: 10px;
    border: none;
    cursor: pointer;
    font-size: 15px;
    font-weight: 600;
    box-shadow: 0 4px 14px rgba(71, 38, 52, 0.12);
    transition: 0.25s ease;
}


/* Custom Message Section */
.wn-box {
    display: grid;
    width: 100%;
    background: #ffffff;
    padding: 25px;
    border-radius: var(--card-radius);
    box-shadow: 0 14px 34px rgba(71,38,52,0.06);
    border: 1px solid #f1dce1;
    margin-bottom: 40px;
}

.wn-box h2 {
    color: var(--plum);
    font-size: 22px;
    margin-bottom: 18px;
}

.wn-box textarea {
    width: 100%;
    border-radius: 12px;
    border: 1px solid #e5c8d0;
    background: var(--ivory);
    padding: 12px;
    font-size: 15px;
    outline: none;
}
.wn-box textarea:focus {
    border-color: var(--mauve);
}

.wn-box select {
    padding: 12px;
    width: 60%;
    border-radius: 10px;
    border: 1px solid #e5c8d0;
    background: var(--ivory);
    font-size: 15px;
    outline: none;
    color: var(--plum);
}
.wn-box select:focus {
    border-color: var(--mauve);
}

/* Modal Overlay */
#modal {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.45);
    backdrop-filter: blur(4px);
    z-index: 1000;
}

/* Modal Box */
.wn-modal-box {
    width: 60%;
    margin: 5% auto;
    background: white;
    padding: 25px;
    border-radius: 18px;
    box-shadow: 0 20px 50px rgba(71,38,52,0.20);
    border: 1px solid #e9d4d8;

    max-height: 80vh;     /* KEY: modal height limit */
    overflow-y: auto;     /* KEY: enable scrolling */
    position: relative;   /* required for close icon */
}

.wn-modal-box h2 {
    font-size: 22px;
    color: var(--plum);
    margin-bottom: 20px;
}

/* Customer list inside modal */
.wn-customer-item {
    padding: 15px 10px;
    border-bottom: 1px solid #f1dce1;
}

.wn-customer-item strong {
    color: var(--plum);
    font-size: 16px;
}

.wn-customer-item a {
    display: inline-block;
    margin-top: 8px;
    background: var(--mauve);
    color: white;
    padding: 6px 14px;
    border-radius: 8px;
    text-decoration: none;
    font-size: 14px;
    font-weight: 600;
}
.wn-customer-item a:hover {
    background: var(--plum);
}

/* Close Button */
.wn-close-btn {
    margin-top: 15px;
    background: var(--plum);
    color: white;
    padding: 10px 20px;
    border-radius: 10px;
    border: none;
    cursor: pointer;
    font-weight: 600;
    transition: 0.3s ease;
}
.wn-close-btn:hover {
    opacity: 0.85;
}

</style>
</head>
<body>
<?php include('./includes/header.php'); ?>
<main class="main">
<?php

    $todayQ = mysqli_query($conn,
        "SELECT id FROM tbl_booking WHERE DATE(date) = CURDATE()"
    );
    $todayCount = mysqli_num_rows($todayQ);


    $tomorrowQ = mysqli_query($conn,
    "SELECT id FROM tbl_booking WHERE DATE(date) = DATE_ADD(CURDATE(), INTERVAL 1 DAY)"
);
$tomorrowCount = mysqli_num_rows($tomorrowQ);


$remQ = mysqli_query($conn,
    "SELECT cs.cs_id, cs.next_service_date, c.c_name, c.phone
     FROM tbl_cs cs
     JOIN tbl_customer c ON cs.customer_id = c.customer_id
     WHERE cs.next_service_date IS NOT NULL
       AND cs.reminder_sent = 0
       AND TIMESTAMPDIFF(HOUR, NOW(), cs.next_service_date) <= 24"
);
$remCount = mysqli_num_rows($remQ);


$allQ = mysqli_query($conn,
    "SELECT phone FROM tbl_booking
     UNION
     SELECT phone FROM tbl_customer"
);
$allCount = mysqli_num_rows($allQ);
?>

<!-- Today -->
<h1 class="wn-heading">WhatsApp Notifications</h1>

<div class="wn-cards">
    <div class="wn-card">
        <h3>Today's Appointments: <?php echo $todayCount; ?></h3>
        <button class="wn-btn" onclick="showCustomers('today')">View List</button>
    </div>

    <div class="wn-card">
        <h3>Tomorrow's Appointments: <?php echo $tomorrowCount; ?></h3>
        <button class="wn-btn" onclick="showCustomers('tomorrow')">View List</button>
    </div>

    <div class="wn-card">
        <h3>Upcoming Reminders (24H): <?php echo $remCount; ?></h3>
        <button class="wn-btn" onclick="showCustomers('reminder')">View List</button>
    </div>

    <div class="wn-card">
        <h3>All Customers: <?php echo $allCount; ?></h3>
        <button class="wn-btn" onclick="showCustomers('all')">View List</button>
    </div>
</div>

<div class="wn-box">
    <h2>Send Custom Message</h2>
    <textarea id="customMessage" rows="5">Hello! We have exciting offers waiting for you.</textarea>
    <button class="wn-btn" onclick="sendCustomMessage()">Send Custom Message</button>
</div>

<div id="modal">
    <div class="wn-modal-box">

        <h2 id="modalTitle"></h2>

        <div id="customerList"></div>

        <button class="wn-close-btn" onclick="closeModal()">Close</button>
    </div>
</div>

<script>
function showCustomers(type) {

    document.getElementById('modal').style.display = 'block';

    let title = "";
    if (type === "today") title = "Today's Appointments";
    else if (type === "tomorrow") title = "Tomorrow's Appointments";
    else title = "All Customers";

    document.getElementById('modalTitle').innerText = title;

    fetch("get_customers.php?type=" + type)
        .then(res => res.json())
        .then(data => {
            let html = "";

            if (data.length === 0) {
                html = "<p>No customers found</p>";
            } else {
                data.forEach(c => {
                    let url = "https://web.whatsapp.com/send?phone=91"
                              + c.phone
                              + "&text=" + encodeURIComponent(c.message);

                    html += `
                        <div style="border-bottom:1px solid #ccc; padding:10px 0;">
                            <strong>${c.name}</strong><br>
                            ${c.phone}<br>
                            <a href="${url}" target="_blank">Send WhatsApp</a>
                        </div>
                    `;
                });
            }

            document.getElementById('customerList').innerHTML = html;
        });
}

function closeModal() {
    document.getElementById('modal').style.display = 'none';
}

function sendCustomMessage() {
    let msg = document.getElementById('customMessage').value;

    if (msg.trim() === "") {
        alert("Please enter a message");
        return;
    }

    let url = "https://web.whatsapp.com/send?text=" + encodeURIComponent(msg);
    window.open(url, "_blank");
}
</script>


<script>
  document.addEventListener('DOMContentLoaded', function() {
    if (window.innerWidth <= 900) {
      const sidebar = document.querySelector('.sidebar');
      sidebar.classList.remove('show');
    }
  });
</script>

</main>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    if (window.innerWidth <= 900) {
      const sidebar = document.querySelector('.sidebar');
      if (sidebar) sidebar.classList.remove('show');
    }
  });
</script>

</body>
</html>
