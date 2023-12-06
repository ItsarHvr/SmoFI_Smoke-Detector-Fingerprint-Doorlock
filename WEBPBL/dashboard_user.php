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
        <div class="menu-icon" onclick="toggleMenu()">
      <div class="bar"></div>
      <div class="bar"></div>
      <div class="bar"></div>
    </div>

    <div class="menu" id="menu">
      <a href="javascript:void(0);" onclick="openPopup()">
      <img src="ava.jpg" alt="User Avatar" style="width: 50px; height: 50px; border-radius: 50%;"><div class="user-info">
            <?php
            session_start();
            if (isset($_SESSION["full_name"])) {
                echo "Welcome, " . $_SESSION["full_name"];
            }
            ?>
            </div>
    </a>
    <a href="profile.php">
      🧑‍💼 Profil Saya
    </a>
    <a href="javascript:void(0);" onclick="confirmLogout()">🚪Logout</a>

    </div>
    </header>

    <div class="container">
        <div class="device">
            <a href="log_akses_user.php"> <img src="door.jpg" alt="Smart Door Lock"> </a>
            <h2>Smart Door Lock</h2>
            <p>Buka dan kunci pintu dengan mudah hanya dengan sidik jari </p>
        </div>
        <div class="device">
            <img src="smoke.jpg" alt="Smoke Detector">
            <h2>Smoke Detector</h2>
            <p>Dapat notifikasi seketika jika ada tanda asap atau kebakaran di kampus </p>
        </div>
    </div>    

    <footer>
        &copy; 2023 Smart Class Kelompok 3
    </footer>

    <script>
    function toggleMenu() {
      var menu = document.getElementById("menu");
      if (menu.style.display === "none") {
        menu.style.display = "block";
      } else {
        menu.style.display = "none";
      }
    }
    function openPopup() {
    document.getElementById("profilPopup").style.display = "block";
  }

  function confirmLogout() {
    var isLogoutConfirmed = confirm("Apakah Anda yakin untuk logout?");
    if (isLogoutConfirmed) {
      // Redirect atau lakukan logika logout
      window.location.href = "login.php";
    }
  }
  </script>

</body>
</html>
