<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Pendaftaran</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 80vh;
            background: linear-gradient(135deg, #c850c0, #4158d0);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .container {
            width: 6000%;
            max-width: 400px;
            padding: 40px;
            border-radius: 10px;
            background-color: #ffffff;
            box-shadow: 0 0 100px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-control {
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .form-btn {
            text-align: center;
        }
        .alert {
            margin-bottom: 20px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        .form-desc {
            text-align: center;
            margin-bottom: 40px;
            color: #555;
        }
        .accessory {
            text-align: center;
            margin-top: 20px;
        }
        .accessory img {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            margin: 0 10px;
        }
    </style>
</head>
<body>
    <div class="container">
    <div class="accessory">
            <img src="logo.png" alt="Accessories 1">       </div>
        <h2>Register Your Account </h2>
        <p class="form-desc">Isi informasi di bawah ini untuk mendaftar</p>
        <?php

require_once "database.php"; // Make sure to include this file for database connection

class UserRegistration
{
    private $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function registerUser($fullName, $email, $password, $passwordRepeat)
    {
        $conn = $this->db->getConnection();

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $errors = [];

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Email tidak valid";
        }

        if (strlen($password) < 8) {
            $errors[] = "Password harus minimal 8 karakter";
        }

        if ($password !== $passwordRepeat) {
            $errors[] = "Password tidak cocok";
        }

        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            $rowCount = $result->num_rows;

            if ($rowCount > 0) {
                $errors[] = "Email sudah digunakan!";
            }

            if (empty($errors)) {
                $sql = "INSERT INTO users (full_name, email, password) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($sql);

                if ($stmt) {
                    $stmt->bind_param("sss", $fullName, $email, $passwordHash);
                    $stmt->execute();
                    echo "<div class='alert alert-success'>Anda telah berhasil terdaftar.</div>";
                } else {
                    die("Terjadi kesalahan");
                }
            } else {
                foreach ($errors as $error) {
                    echo "<div class='alert alert-danger'>$error</div>";
                }
            }
        }
    }
}

$db = new Database();
$userRegistration = new UserRegistration($db);

if (isset($_POST["submit"])) {
    $fullName = trim($_POST["fullname"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $passwordRepeat = $_POST["repeat_password"];

    $userRegistration->registerUser($fullName, $email, $password, $passwordRepeat);
}

?>


        <form action="register.php" method="post">
            <div class="form-group">
                <input type="text" class="form-control" name="fullname" placeholder="Nama Lengkap">
            </div>
            <div class="form-group">
                <input type="email" class="form-control" name="email" placeholder="Email">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Kata Sandi">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="repeat_password" placeholder="Ulangi Kata Sandi">
            </div>
            <div class="form-btn">
                <input type="submit" class="btn btn-primary" value="Daftar" name="submit">
            </div>
        </form>
        <p style="text-align: center; margin-top: 20px;">Sudah terdaftar? <a href="login.php">Masuk di sini</a></p>
    </div>
</body>
</html>
