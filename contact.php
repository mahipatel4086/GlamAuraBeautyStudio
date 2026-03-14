
<?php
include('./conn.php');

// Selected values when form reloads
$category_id = $_POST['category_id'] ?? "";
$service_id  = $_POST['service_id'] ?? "";
$city_id     = $_POST['city_id'] ?? "";

// ------------------------------
// Insert booking
// ------------------------------
if (isset($_POST['btn_addData'])) {

    $name   = $_POST['name'];
    $phone  = $_POST['phone'];
    $email  = $_POST['email'];
    $cat    = $_POST['category_id'];
    $srv    = $_POST['service_id'];
    $date   = $_POST['date'];
    $msg    = $_POST['message'];
    $price  = $_POST['price'];

    $insert = mysqli_query($conn,
    "INSERT INTO tbl_booking
    (name, phone, email, category_id, service_id, date, message, price)
    VALUES ('$name','$phone','$email','$cat','$srv','$date','$msg','$price')");

    if ($insert) {
       echo "<script>
                alert('Booking Confirmed!');
                window.location.href = 'index.php';
              </script>";
        exit();
      } else {
        echo "<p style='color:red'>Error: " . mysqli_error($conn) . "</p>";
    }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="description" content="Contact GlamAura Beauty Studio — Book your appointment or request a consultation.">
  <title>Contact — GlamAura Beauty Studio</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/styles.css">
  <style>
    .app {
      display: grid;
      grid-template-columns: 240px 1fr;
      gap: 20px;              
      width: 96vw;        
      margin-right: -50px;
      padding: 0;         
      margin-top: -30px;
    } 

    .main {
      width:100%;
      padding: 6px 2px;
    }

    .form-container {
        max-width: 800px;
        margin: 100px auto 0 auto;
        background: white;
        padding: 25px 30px;
        border-radius: 16px;
        box-shadow: 0 10px 25px rgba(71, 38, 52, 0.10);
        color: var(--plum);
    }


    .form-container h3 {
        text-align: center;
        margin-bottom: 20px;
        font-weight: 700;
        color: var(--plum);
    }


    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;   
        gap: 18px 22px;                   
    }


    .form-container label {
        font-weight: 600;
        color: var(--mauve);
        display: block;
        margin-bottom: 6px;
    }

    .form-container input[type="text"],
    .form-container input[type="number"],
    .form-container input[type="email"],
    .form-container input[type="date"],
    .form-container select {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #e8d5d9;
        border-radius: 10px;
        background: var(--ivory);
        color: var(--plum);
        font-size: 15px;
        outline: none;
        transition: 0.3s ease;
    }

    .form-container input:focus,
    .form-container select:focus {
        border-color: var(--mauve);
    }


    .full {
        grid-column: 1 / span 2;
    }

    .btn-row {
        display: flex;
        justify-content: space-between;
        gap: 35px;
        margin-top: 30px;
    }

    /* SAME styling for both */
    .btn-row input[type="submit"],
    .btn-row .btn-dashboard {
        width: 100%;
        padding: 12px;
        background: #a96461;
        color: white;
        border: none;
        font-size: 16px;
        font-weight: 700;
        border-radius: 10px;
        box-shadow: 0 5px 12px rgba(71, 38, 52, 0.2);
        transition: 0.3s ease;
        text-align: center;
        cursor: pointer;
        display: block;
        text-decoration: none; /* underline hatane ke liye */
    }

    /* Hover effect for both */
    .btn-row input[type="submit"]:hover,
    .btn-row .btn-dashboard:hover {
        opacity: 0.9;
        transform: translateY(-2px);
    }
    /* REMOVE BORDER + UPDATE PRIMARY COLOR */
    .btn-primary {
        background: #a96461 !important; /* <-- change this to your preferred color */
        color: white;
        border: none !important;
        box-shadow: 0 5px 12px rgba(71, 38, 52, 0.2);
        padding: 12px 20px;
        border-radius: 30px;
        display: inline-block;
        text-decoration: none;
    }
    .btn-primary:hover { opacity: 0.9; transform: translateY(-2px); }
    .btn-outline{background:transparent;border-color:var(--plum);color:var(--plum );text-decoration: none;}
    .btn-rose{background:var(--rose-gold);color:#fff;text-decoration: none; }
    
    @media (max-width: 768px) {
      .form-container {
        margin: 20px auto;
        padding: 20px 15px;
      }
      
      .form-grid {
        grid-template-columns: 1fr;
        gap: 15px;
      }
      
      .full {
        grid-column: 1;
      }
      
      .btn-row {
        flex-direction: column;
        gap: 15px;
      }
    }
          :root {
    --rose-gold: #CFA46A; /* your logo color */
}

.instagram-btn,
.whatsapp-btn {
    position: fixed;
    right: 20px;
    width: 55px;
    height: 55px;
    border-radius: 50%;
    background: #ffffff;
    /*border: 1.5px solid #b76e79;  Soft rose gold border */
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
    cursor: pointer;
    transition: all 0.35s ease;
    box-shadow: var(--rose-gold); /* Soft rose gold shadow */
}

.instagram-btn { bottom: 110px; }
.whatsapp-btn { bottom: 45px; }

/* ICON COLOR */
.instagram-btn i,
.whatsapp-btn i {
    color: #b76e79;       /* Rose gold */
    font-size: 23px;
    transition: 0.35s ease;
}

/* HOVER EFFECT */
.instagram-btn:hover,
.whatsapp-btn:hover {
           /* Rose gold background */
    border-color: #b76e79;
    box-shadow: 0px 6px 18px rgba(183, 110, 121, 0.45);
    transform: translateY(-4px); /* Subtle lift */
}

/* ICON stays white on hover */
.instagram-btn:hover i,
.whatsapp-btn:hover i {
    color: #ffffff;
}

  </style>
</head>
<body>
<?php include('layouts/header.php'); ?>
<main>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8 col-md-10 col-sm-12">
        <div class="form-container">
          <h3 class="text-center mb-4">Book Your Appointment</h3>
          <form method="POST" action="" enctype="multipart/form-data">
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label">Name:</label>
                <input type="text" name="name" class="form-control" required />
              </div>
              <div class="col-md-6">
                <label class="form-label">Phone:</label>
                <input type="text" name="phone" class="form-control" required>
              </div>  
              <div class="col-md-6">
                <label class="form-label">Email:</label>
                <input type="email" name="email" class="form-control">
              </div>
              <div class="col-md-6">
                <label class="form-label">Category:</label>
                <select name="category_id" id="categoryDropdown" class="form-select" onchange="filterServices(this.value)">
                    <option value="">Select Category</option>
                    <?php
                    $cat = mysqli_query($conn, "SELECT * FROM tbl_categories WHERE status=1");
                    while ($r = mysqli_fetch_assoc($cat)) {
                        echo "<option value='{$r['id']}'>{$r['name']}</option>";
                    }
                    ?>
                </select>
              </div>
              <div class="col-md-6">
                  <label class="form-label">Service:</label>
                  <select name="service_id" id="serviceDropdown" class="form-select">
                      <option value="">Select Service</option>
              <?php
                  if ($category_id > 0) {
                    $services = mysqli_query($conn, "SELECT service_id, name FROM tbl_services WHERE status=1 AND category_id = {$category_id} ORDER BY name");
                    while ($s = mysqli_fetch_assoc($services)) {
                        $sel = ($service_id == $s['service_id']) ? "selected" : "";
                        echo "<option value='{$s['service_id']}' $sel>" . htmlspecialchars($s['name']) . "</option>";
                    }
                  }
                ?>
                  </select>
              </div>
              <div class="col-md-6">
                <label class="form-label">Date:</label>
                <input type="date" name="date" class="form-control" required>
              </div>
              <div class="col-12">
                <label class="form-label">Message:</label>
                <textarea name="message" class="form-control" rows="3"></textarea>
                <input type="hidden" name="price" id="priceField">
              </div>
              <div class="col-12 text-center">
                <input type="submit" class="btn btn-primary btn-lg" name="btn_addData" value="Book Appointment">
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</main>
<?php include('layouts/footer.php'); ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<a href="https://instagram.com/shreyasiyer96" target="_blank" class="instagram-btn d-flex align-items-center justify-content-center">
    <i class="bi bi-instagram"></i>
</a>

<a href="https://wa.me/9879020573" target="_blank" class="whatsapp-btn d-flex align-items-center justify-content-center">
    <i class="bi bi-whatsapp"></i>
</a>
  <script>
    // Load all services from PHP into JavaScript
    const allServices = [
        <?php
        $srvAll = mysqli_query($conn, "SELECT * FROM tbl_services WHERE status=1");
        while ($s = mysqli_fetch_assoc($srvAll)) {
            echo "{service_id: {$s['service_id']}, category_id: {$s['category_id']}, name: '" . addslashes($s['name']) . "', price: {$s['price']}},";
        }
        ?>
    ];

    function filterServices(catId) {
        const dropdown = document.getElementById("serviceDropdown");
        dropdown.innerHTML = "<option value=''>Select Service</option>";

        allServices.forEach(service => {
            if (service.category_id == catId) {
                dropdown.innerHTML += `<option value="${service.service_id}">${service.name}</option>`;
            }
        });
    }

    // ---- STEP 2: Auto-fill price when service is selected ----
document.getElementById("serviceDropdown").addEventListener("change", function() {
    const selectedId = this.value;

    const priceInput = document.getElementById("priceField");

    const selectedService = allServices.find(s => s.service_id == selectedId);

    if (selectedService) {
        priceInput.value = selectedService.price;
    }
});
</script>
</body>
</html>

