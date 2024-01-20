<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styleregister.css">
</head>
<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">

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

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-group">
                    <x-text-input id="name" class="form-control" type="text" name="name" :value="old('name')" placeholder="Nama Lengkap" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div class="form-group">
                    <x-text-input id="email" class="form-control" type="email" name="email" :value="old('email')" placeholder="Email" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="form-group">
                    <x-text-input id="password" class="form-control" type="password" name="password" placeholder="Kata Sandi" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="form-group">
                    <x-text-input id="password_confirmation" class="form-control" type="password" name="password_confirmation" placeholder="Ulangi Kata Sandi" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="form-btn">
                    <button type="submit" class="btn btn-primary">Daftar</button>
                </div>
            </form>

            <p style="text-align: center; margin-top: 20px;">Already registered? <a href="{{ route('login') }}">Sign in</a></p>
        </div>
    </div>
</body>
</html>
