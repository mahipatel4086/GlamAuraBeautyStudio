<?php

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "db_cosmetic";
    $conn = new mysqli($servername, $username, $password, $dbname);

    if($conn ->connect_error){
        die("Connection Error ".$conn->connect_error);
    }
    else {
        
    }

$select_sql = "SELECT * FROM tbl_user";
$result = mysqli_query($conn,$select_sql);
?>

<?php
		if(isset($_POST['btn_submit'])){
			$name= $_POST['user_name'];
			$email = $_POST['user_email'];
			$contact = $_POST['user_con'];
			$password = $_POST['user_password'];
		
		$sql = " INSERT INTO tbl_user (user_name,user_email,user_con,user_password)VALUES('$name','$email',$contact,'$password' )";
		$res = mysqli_query($conn,$sql);
			
			if($res==1)
			header("Location:http://localhost/internship/cosmetic_website/login.php");
			}
			else
			{
					}
		
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Register — GlamAura</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
  <header class="site-header">
    <div class="header-wrapper">
      <a class="brand" href="index.html">
        <span class="logo-mark">GA</span>
        <div class="brand-text">
          <span class="brand-name">GlamAura</span>
          <span class="brand-tagline">Beauty Studio</span>
        </div>
      </a>
      <button class="nav-toggle" aria-label="Open navigation"><span></span><span></span><span></span></button>
      <nav class="site-nav">
        <ul>
          <li><a href="index.html">Home</a></li>
          <li><a href="services.html">Services</a></li>
          <li><a href="gallery.html">Gallery</a></li>
          <li><a href="about.html">About</a></li>
          <li><a href="testimonials.html">Reviews</a></li>
          <li><a href="contact.html" class="btn btn-rose">Book Appointment</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <main>
    <div class="container">
      <section class="page-intro text-center">
        <h1>Register</h1>
        <p class="muted">Create an account to manage your bookings and get updates.</p>
      </section>

      <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8 col-sm-12">
          <div class="form-container">
            <form method="post" action="" class="contact-form">
              <div class="mb-3">
                <label for="name" class="form-label">Full name</label>
                <input id="name" name="user_name" type="text" class="form-control" required>
              </div>

              <div class="mb-3">
                <label class="form-label">Email</label>
                <input id="email" name="user_email" type="email" class="form-control" required>
              </div>

              <div class="mb-3">
                <label class="form-label">Phone</label>
                <input id="phone" name="user_con" type="text" class="form-control" required>
              </div>

              <div class="mb-3">
                <label class="form-label">Password</label>
                <input id="password" name="user_password" type="password" class="form-control" required>
              </div>

              <div class="d-flex gap-2 justify-content-center">
                <button type="submit" name="btn_submit" class="btn btn-rose">Register</button>
                <a href="login.php" class="btn btn-outline">Login</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </main>

  <footer class="site-footer">
    <div class="container footer-inner">
      <div class="footer-brand"><span class="logo-mark">GA</span><div><strong>GlamAura Beauty Studio</strong><p class="muted">Where Beauty Meets Art</p></div></div>
      <div class="footer-contact"><p class="muted">© <span id="year"></span> GlamAura. All rights reserved.</p></div>
    </div>
  </footer>

  <script>document.getElementById('year') && (document.getElementById('year').textContent = new Date().getFullYear());</script>
</body>
</html>

