<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Formulir Pendaftaran</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
  <link rel="stylesheet" href="css/styleregister.css">
</head>
<body>
  <div class="container">
    <div class="accessory">
      <img src="logo/logo.png" alt="Accessories 1">
    </div>
    <h2>Register Your Account</h2>

    @if(session('success'))
       <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
       <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif

    <form action="{{ route('register') }}" method="post">
      @csrf

      <div class="form-group">
        <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Nama Lengkap" value="{{ old('fullname') }}">
      </div>

      <div class="form-group">
        <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{ old('email') }}">
      </div>

      <div class="form-group">
        <input type="password" class="form-control" id="password" name="password" placeholder="Kata Sandi">
      </div>

      <div class="form-group">
        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Ulangi Kata Sandi">
      </div>

      <div class="form-btn">
        <button type="submit" class="btn btn-primary">Daftar</button>
      </div>
    </form>

    <p style="text-align: center; margin-top: 20px;">Sudah terdaftar? <a href="{{ url('/login') }}">Masuk di sini</a></p>
  </div>
</body>
</html>
