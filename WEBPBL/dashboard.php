<?php
session_start();
if (!isset($_SESSION["user"])) {
   header("Location: login.php");
   exit(); // Pastikan untuk keluar setelah mengarahkan pengguna
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Smart Door Lock & Smoke Detector</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body style="background: url('background.jpg') no-repeat center center fixed;
  background-size: cover;">
  <header>
    <h1>Smart Door Lock & Smoke Detector</h1>
  </header>
  <div class="container">
    <div class="device">
      <img src="door.jpg" alt="Smart Door Lock">
      <h2>Smart Door Lock</h2>
      <p>Monitor and control your door lock remotely with our smart lock technology.</p>
    </div>
    <div class="device">
      <img src="smoke.jpg" alt="Smoke Detector">
      <h2>Smoke Detector</h2>
      <p>Get real-time alerts about smoke or fire in your home with our smart smoke detector.</p>
    </div>
  </div>
  <footer>
    &copy; 2023 Smart Home Solutions
  </footer>
</body>
</html>
