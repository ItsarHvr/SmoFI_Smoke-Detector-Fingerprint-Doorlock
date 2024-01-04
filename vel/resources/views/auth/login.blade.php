<!-- resources/views/login.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Access Control & Smoke Detector Login</title>
    <link rel="stylesheet" type="text/css" href="css/stylelogin.css">
</head>
<body>
    <div class="login-container">
        <div class="login-content">

            @if(session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <img src="{{ asset('logo/pnj.png') }}" alt="Kampus Logo" class="logo" style="width: 60px;">
            <img src="{{ asset('logo/logo.png') }}" alt="Kampus Logo" class="logo2" style="width: 80px;">
            <form class="login-form" method="post" action="{{ url('/login') }}">
                @csrf
                <h2>Smart Door Lock and Smoke Detector System</h2>
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                <input type="text" name="email" placeholder="Email" class="login-input">
                <input type="password" name="password" placeholder="Password" class="login-input">
                <button type="submit" name="login" class="login-button">Login</button>
            </form>
            <br>
            <p class="register-link">Don't have an account? <a href="{{ url('/register') }}">Sign up</a></p>
        </div>
        <div class="decoration-container"></div>
    </div>
</body>
</html>
