<?php
include('./conn.php');
session_start();

if(isset($_SESSION['admin'])) {
    header('location:dashboard.php');
    exit();
}

if (isset($_POST['login'])) {

    $name = $_POST['user_name'];
    $pass = $_POST['user_password'];

    // LOGIN MUST CHECK STATUS = 1
    $sql = "
        SELECT * FROM tbl_admin
        WHERE username='$name'
        AND password='$pass'
        AND status = 1
    ";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {

        $_SESSION['admin'] = $name;

        echo "<script>
                alert('Admin Login Successful!');
                window.location = 'dashboard.php';
              </script>";

    } else {

        echo "<script>
                alert('Invalid credentials OR admin is inactive!');
              </script>";
    }
}
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Login — GlamAura</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="login.css">
</head>
<body>
  <main class="container">
    <section class="contact-grid">
<div class="login-box">

  <h2 class="login-title">Login</h2>
  <p class="login-subtitle">Sign in to manage your bookings and profile.</p>

  <form method="post" action="" class="contact-form">

      <!-- <label>Name</label> -->
      <div class="input-group">
        <input type="text" name="user_name" placeholder="Username" required>
      </div>

      <!-- <label>Password</label> -->
      <div class="password-group">
          <input type="password" id="password" name="user_password" placeholder="Password" required>
          <i class="fa-solid fa-eye" id="togglePassword"></i>
      </div>

      <div class="form-actions">
        <button type="submit" name="login" class="btn btn-rose">Login</button>
        <a href="registration.php" class="btn btn-outline">Register</a>
      </div>
  </form>
</div>
</section>

  </main>
  <script>document.getElementById('year') && (document.getElementById('year').textContent = new Date().getFullYear());</script>
  <script>
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');

    togglePassword.addEventListener('click', function (e) {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        this.classList.toggle('fa-eye-slash');
    });
  </script>
</body>
</html>
