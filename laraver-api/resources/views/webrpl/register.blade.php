<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Pendaftaran</title>
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
</head>
<body>
    <div class="container">
        <div class="accessory">
            <img src="{{ asset('image/logo.png') }}" alt="Accessories 1">
        </div>
        <h2>Register Your Account</h2>
        <p class="form-desc">Isi informasi di bawah ini untuk mendaftar</p>

        <form action="{{ route('webrpl.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <input type="text" class="form-control" name="full_name" placeholder="Nama Lengkap">
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
