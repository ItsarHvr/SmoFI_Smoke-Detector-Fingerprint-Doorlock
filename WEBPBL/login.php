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

require_once "database.php"; // Make sure to include this file for database connection

class UserLogin
{
    private $conn;

    public function __construct(Database $db)
    {
        $this->conn = $db->getConnection();
    }

    public function loginUser($email, $password){
        $sql = "SELECT id, email, full_name, password FROM users WHERE email = ?";

        $stmt = mysqli_stmt_init($this->conn);
        if (mysqli_stmt_prepare($stmt, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($result) {
                $user = mysqli_fetch_assoc($result);

                if ($user) {
                    if (password_verify($password, $user["password"])) {
                        session_start();
                        $_SESSION["user_id"] = $user["id"]; // Store only the user ID in the session
                        $_SESSION["full_name"] = $user["full_name"];
                        header("Location: dashboard.php");
                        exit();
                    } else {
                        echo "<div class='alert alert-danger'>Invalid email or password</div>";
                    }
                } else {
                    echo "<div class='alert alert-danger'>User not found</div>";
                }
            } else {
                echo "<div class='alert alert-danger'>Error fetching user data</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>Error preparing SQL statement</div>";
        }
    }
}

$db = new Database();
$userLogin = new UserLogin($db);

if (isset($_POST["login"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $userLogin->loginUser($email, $password);
}

?>

      <img src="pnj.png" alt="Kampus Logo" class="logo" style="width: 60px;">
      <img src="logo.png" alt="Kampus Logo" class="logo2" style="width: 80px;">
      <form class="login-form" method="post" action="login.php">
        <h2>Smart Door Lock and Smoke Detector System</h2>
        <input type="text" name="email" placeholder="Email" class="login-input">
        <input type="password" name="password" placeholder="Password" class="login-input">
        <button type="submit" name="login" class="login-button">Login</button>
      </form>
      <br>
      <p class="register-link">Don't have an account? <a href="register.php">Sign up</a></p>
    </div>
    <div class="decoration-container">
      <!-- Masukkan hiasan cantik di sini -->
    </div>
  </div>
</body>
</html>
