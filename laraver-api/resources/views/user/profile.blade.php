<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Profile</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(135deg, #4a90e2, #8e3f95);
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 110vh;
    }

    .profile-container {
      background: white;
      padding: 60px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      text-align: center;
    }

    h1 {
      color: #333;
    }

    p {
      color: #555;
      margin: 10px 0;
    }

    button {
      background-color: #4CAF50;
      color: #fff;
      padding: 10px 20px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-size: 16px;
      margin-top: 20px;
    }

    button:hover {
      background-color: #45a049;
    }
  </style>
</head>
<body>
  <div class="profile-container">
    <h1>Profil Saya</h1>
    <img src="{{ asset('image/ava.jpg') }}" alt="User Avatar" style="width: 200px; height: 200px; border: 1px solid gray;">
    <p><strong>Full Name:</strong> {{ $name }}</p>
    <p><strong>Email:</strong> {{ $email }}</p>
    <form action="{{ route('user.edit.profile') }}" method="get">
      <button type="submit">Edit Profil</button>
    </form>
    <form action="{{ route('user.dashboard') }}" method="get">
      <button type="submit">Kembali ke Beranda</button>
    </form>
  </div>
</body>
</html>
+