<?php
// session_start();
// if (isset($_SESSION["user"])) {
//    header("Location: dashboard.php");
//    exit();
// }
// ?>
<!DOCTYPE html>
<html>
<head>
  <title>Access Control & Smoke Detector Login</title>
  <link rel="stylesheet" type="text/css" href="stylelogin.css">
</head>
<body>
  <div class="login-container">
    <div class="login-content">
    <?php
        if (isset($_POST["login"])) {
          $email = $_POST["email"];
          $password = $_POST["password"];
          require_once "database.php";
          $sql = "SELECT * FROM users WHERE email = ?";
          
          $stmt = mysqli_stmt_init($conn);
          if (mysqli_stmt_prepare($stmt, $sql)) {
              mysqli_stmt_bind_param($stmt, "s", $email);
              mysqli_stmt_execute($stmt);
              $result = mysqli_stmt_get_result($stmt);
              $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
      
              if ($user) {
                  if (password_verify($password, $user["password"])) {
                      session_start();
                      $_SESSION["user"] = $user; // Simpan seluruh data pengguna dalam sesi
                      header("Location: dashboard.php");
                      exit(); // Tambahkan exit() untuk menghentikan eksekusi lebih lanjut
                  } else {
                      echo "<div class='alert alert-danger'>Password does not match</div>";
                  }
              } else {
                  echo "<div class='alert alert-danger'>Email does not match</div>";
              }
          }
      }
      
    ?>
      <img src="pnj.png" alt="Kampus Logo" class="kampus-logo" style="width: 100px;">
      <form class="login-form" method="post" action="login.php">
        <h2>Smart Door Lock and Smoke Detector System</h2>
        <input type="text" name="email" placeholder="Email" class="login-input">
        <input type="password" name="password" placeholder="Password" class="login-input">
        <button type="submit" name="login" class="login-button">Login</button>
      </form>
      <br>
      <p class="register-link">Don't have an account?  <a href="register.php">Sign up</a></p>
    </div>
    <div class="decoration-container">
      <!-- Masukkan hiasan cantik di sini -->
    </div>
  </div>
</body>
</html>
