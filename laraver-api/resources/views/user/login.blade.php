<!DOCTYPE html>
<html>
<head>
  <title>Access Control & Smoke Detector Login</title>
  <link rel="stylesheet" type="text/css" href="stylelogin.css">
</head>
<body>
  <div class="login-container">
    <div class="login-content">
      <img src="{{ asset('image/pnj.png') }}" alt="Kampus Logo" class="logo" style="width: 60px;">
      <img src="{{ asset('image/logo.png') }}" alt="Kampus Logo" class="logo2" style="width: 80px;">
      <form class="login-form" method="post" action="{{ route('user.in') }}">
      @csrf
        <h2>Smart Door Lock and Smoke Detector System</h2>
        <input type="text" name="email" placeholder="Email" class="login-input">
        <input type="password" name="password" placeholder="Password" class="login-input">
        <button type="submit" name="login" class="login-button">Login</button>
      </form>
      <br>
      <p class="register-link">Don't have an account? <a href="{{ route('user.create') }}">Sign up</a></p>
    </div>
    <div class="decoration-container">
    </div>
  </div>
</body>
</html>