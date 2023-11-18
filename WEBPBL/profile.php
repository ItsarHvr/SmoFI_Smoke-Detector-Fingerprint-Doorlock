<?php
session_start();

require_once "database.php"; 
require_once "UserProfile.php";

// Pastikan pengguna sudah login
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

// Membuat objek UserProfile
$db = new Database();
$userProfile = new UserProfile($db, $_SESSION["user_id"]);

// Mendapatkan data pengguna
$userData = $userProfile->getUserData();

if ($userData) {
    $fullName = $userData["full_name"];
    $email = $userData["email"];
    // Password tidak boleh ditampilkan secara langsung, jadi kita hanya menampilkan panjangnya
    $passwordLength = strlen($userData["password"]);
} else {
    // Handle error or redirect to an error page
    echo "Error fetching user data";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>User Profile</title>
  <!-- Tambahkan file CSS atau styling sesuai kebutuhan -->
</head>
<body>
  <h1>User Profile</h1>
  <p><strong>Full Name:</strong> <?php echo $fullName; ?></p>
  <p><strong>Email:</strong> <?php echo $email; ?></p>
  <p><strong>Password Length:</strong> <?php echo $passwordLength; ?> characters</p>
  <form action="EditProfile.php" method="get">
    <button type="submit">Edit Profile</button>
  </form>
  <form action="dashboard.php" method="get">
    <button type="submit">Home</button>
  </form>
</body>
</html>
