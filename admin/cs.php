<?php
include ('./conn.php');

session_start();

if(!isset($_SESSION['admin']) || empty($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

$customer_id = isset($_GET['customer_id']) ? intval($_GET['customer_id']) : 0;
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : "";

/* SELECTED CUSTOMER NAME */
$selected_customer = null;
if ($customer_id > 0) {
    $sql_cust = "SELECT customer_id, enrollment_no, c_name FROM tbl_customer WHERE customer_id = $customer_id";
    $res_cust = $conn->query($sql_cust);
    $selected_customer = $res_cust->fetch_assoc();
}

/* MAIN QUERY */
if ($customer_id > 0) {

    $sql = "
        SELECT 
            cs.cs_id,
            cs.customer_id,
            cs.enrollment_no,
            c.c_name AS customer_name,
            cat.name AS category_name,
            s.name AS service_name,
            cs.date AS service_date,
            cs.next_service_date,
            cs.price,
            cs.time
        FROM tbl_cs cs
        JOIN tbl_customer c ON cs.customer_id = c.customer_id
        JOIN tbl_services s ON cs.service_id = s.service_id
        JOIN tbl_categories cat ON cs.category_id = cat.id
        WHERE cs.customer_id = $customer_id
        ORDER BY cs.cs_id DESC
    ";

} else if ($search != "") {

    $sql = "
        SELECT 
            cs.cs_id,
            cs.customer_id,
            cs.enrollment_no,
            c.c_name AS customer_name,
            cat.name AS category_name,
            s.name AS service_name,
            cs.date AS service_date,
            cs.next_service_date,
            cs.price,
            cs.time
        FROM tbl_cs cs
        JOIN tbl_customer c ON cs.customer_id = c.customer_id
        JOIN tbl_services s ON cs.service_id = s.service_id
        JOIN tbl_categories cat ON cs.category_id = cat.id
        WHERE 
            c.c_name LIKE '%$search%' OR
            c.enrollment_no LIKE '%$search%' OR
            s.name LIKE '%$search%' OR
            cs.date LIKE '%$search%' OR
            cs.price LIKE '%$search%' OR
            cs.time LIKE '%$search%' OR
            cat.name LIKE '%$search%'
        ORDER BY cs.cs_id DESC
    ";

} else {

    $sql = "
        SELECT 
            cs.cs_id,
            cs.customer_id,
            cs.enrollment_no,
            c.c_name AS customer_name,
            cat.name AS category_name,
            s.name AS service_name,
            cs.date AS service_date,
            cs.next_service_date,
            cs.price,
            cs.time
        FROM tbl_cs cs
        JOIN tbl_customer c ON cs.customer_id = c.customer_id
        JOIN tbl_services s ON cs.service_id = s.service_id
        JOIN tbl_categories cat ON cs.category_id = cat.id
        ORDER BY cs.cs_id DESC
    ";
}

$result = $conn->query($sql);

/* RECENT APPOINTMENT */
$sql_recent = "
    SELECT 
        cs.cs_id,
        cs.customer_id,
        cs.enrollment_no,
        c.c_name AS customer_name,
        cat.name AS category_name,
        s.name AS service_name,
        cs.date AS service_date,
        cs.next_service_date,
        cs.price,
        cs.time
    FROM tbl_cs cs
    JOIN tbl_customer c ON cs.customer_id = c.customer_id
    JOIN tbl_services s ON cs.service_id = s.service_id
    JOIN tbl_categories cat ON cs.category_id = cat.id
    ORDER BY cs.cs_id DESC
    LIMIT 1
";

$result_recent = $conn->query($sql_recent);
$row_recent = $result_recent->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Glam Studio — Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&family=Playfair+Display:wght@600&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="admin.css" >
  <style>
       

    td {
    vertical-align: middle;
    }

    td a.update-btn,
    td a.delete-btn {
    display: inline-block;   /* already okay */
    margin-right: 6px;       /* spacing */
    }

    td:last-child {
    white-space: nowrap;     /* buttons ko wrap hone se roke */
    }

    .update-btn {
      background: var(--mauve);
      color: white;
      padding: 4px 16px;
      text-decoration: none !important;
      display: inline-block;
      margin-right: 8px;
      border-radius: 9px;
    }
    .delete-btn {
      background: #d9534f;
      color: white;
      padding: 4px 16px;
      text-decoration: none !important;
      display: inline-block;
      border-radius: 9px;
    }
  </style>
</head>
<body>
  
<?php include('./includes/header.php'); ?>
    <main class="main">

      <!-- RECENT APPOINTMENTS -->
<section class="table-wrap">

    <!-- TOP HEADING + CUSTOMER NAME + BUTTON -->
    <div style="
        padding:18px 20px;
        display:flex;
        justify-content:space-between;
        align-items:center;
    ">
        <div>
            <h4 style="margin:0;color:var(--plum);font-weight:700;">
                RECENT SERVICES APPOINTMENTS
            </h4>

            <!-- Selected Customer Name -->
              <div style="margin-top:6px;font-size:0.95rem;color:#7d6770;font-weight:400;opacity:0.85;">
                  <?php 
                  if ($selected_customer) {
                      echo $selected_customer['c_name'];
                  } else {
                      echo "Select a customer";
                  }
                  ?>
              </div>
        </div>

        <!-- ADD CUSTOMER BUTTON -->
        <div>
            <a href="cs_in.php?customer_id=<?php echo $customer_id; ?>">
                <button class="btn btn-sm" 
                    style="background:var(--mauve);
                           color:#fff;
                           border:0;
                           border-radius:10px;
                           height:40px;
                           padding:0 20px;">
                    Add Services
                </button>
            </a>
        </div>
    </div>

    <!-- TABLE -->
    <div style="padding:0 18px 18px 18px;">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Category Name</th>
                    <th>Service Name</th>
                    <th>Service Date</th>
                    <th>Next Service Date</th>
                    <th>Price</th>
                    <th>Time</th>
                    <th>Action</th>
                </tr>
            </thead>

          <tbody>
            <?php if(mysqli_num_rows($result) > 0): ?>
              <?php while($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                  <td><?php echo $row['cs_id']; ?></td>
                  <td><?php echo $row['category_name']; ?></td>
                  <td><?php echo $row['service_name']; ?></td>
                  <td><?php echo $row['service_date']; ?></td>
                  <td><?php echo $row['next_service_date']; ?></td>
                  <td><?php echo $row['price']; ?></td>
                  <td><?php echo $row['time']; ?></td>
                  <td>
                      <a class="update-btn" href="cs_up.php?cs_id=<?php echo $row['cs_id']; ?>"><i class="bi-pencil"></i></a>
                      <a class="delete-btn" href="cs_de.php?cs_id=<?php echo $row['cs_id']; ?>" onclick="return confirm('Are you sure you want to delete this record?');"><i class="bi-trash"></i></a>
                       </td>
                </tr>
              <?php endwhile; ?>
            <?php else: ?>
              <tr><td colspan="7" style="text-align:center">No Appointments found</td></tr>
            <?php endif; ?>
          </tbody>

        </table>
    </div>

</section>

      <div class="bottom-space"></div>
    </main>

  </div>
</body>
</html>
