<!-- resources/views/user/create.blade.php -->

<!DOCTYPE html>
<html>
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

    <form method="post" action="{{ route('user.store') }}">
        @csrf
        <div class="form-group">
            <input type="text" class="form-control" name="name" placeholder="Nama Lengkap" required>
        </div>
        <div class="form-group">
            <input type="email" class="form-control" name="email" placeholder="Email" required>
        </div>
        <div class="form-group">
            <input type="password" class="form-control" name="password" placeholder="Kata Sandi" required>
        </div>
        <div class="form-group">
            <input type="password" class="form-control" name="password_confirmation" placeholder="Ulangi Kata Sandi" required>
        </div>
        <div class="form-btn">
            <input type="submit" class="btn btn-primary" value="Daftar" name="submit">
        </div>
</form>
<p style="text-align: center; margin-top: 20px;">Sudah terdaftar? <a href="{{ route('user.login') }}">Masuk di sini</a></p>
</div>
</body>
</html>
