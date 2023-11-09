<?php
// session_start();
// if (isset($_SESSION["user"])) {
//     header("Location: dashboard.php");
//     exit();
// }
?>

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
        if (isset($_POST["submit"])) {
            $fullName = $_POST["fullname"];
            $email = $_POST["email"];
            $password = $_POST["password"];
            $passwordRepeat = $_POST["repeat_password"];

            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            $errors = array();

            if (empty($fullName) || empty($email) || empty($password) || empty($passwordRepeat)) {
                array_push($errors, "Semua kolom harus diisi");
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                array_push($errors, "Email tidak valid");
            }
            if (strlen($password) < 8) {
                array_push($errors, "Password harus minimal 8 karakter");
            }
            if ($password !== $passwordRepeat) {
                array_push($errors, "Password tidak cocok");
            }

            require_once "database.php";
            $sql = "SELECT * FROM users WHERE email = ?";
            $stmt = mysqli_stmt_init($conn);

            if (mysqli_stmt_prepare($stmt, $sql)) {
                mysqli_stmt_bind_param($stmt, "s", $email);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                $rowCount = mysqli_num_rows($result);

                if ($rowCount > 0) {
                    array_push($errors, "Email sudah digunakan!");
                }

                if (count($errors) > 0) {
                    foreach ($errors as  $error) {
                        echo "<div class='alert alert-danger'>$error</div>";
                    }
                } else {
                    $sql = "INSERT INTO users (full_name, email, password) VALUES (?, ?, ?)";
                    $stmt = mysqli_stmt_init($conn);

                    if (mysqli_stmt_prepare($stmt, $sql)) {
                        mysqli_stmt_bind_param($stmt, "sss", $fullName, $email, $passwordHash);
                        mysqli_stmt_execute($stmt);
                        echo "<div class='alert alert-success'>Anda telah berhasil terdaftar.</div>";
                    } else {
                        die("Terjadi kesalahan");
                    }
                }
            }
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
