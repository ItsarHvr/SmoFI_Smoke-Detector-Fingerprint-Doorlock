<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #4a90e2, #8e3f95);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 120vh;
        }

        .edit-profile-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h1 {
            color: #333;
        }

        p {
            color: #555;
            margin: 10px 0;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        label {
            font-weight: bold;
            margin-top: 10px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin: 5px 0 20px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        button {
            background-color: #4CAF50;
            color: #fff;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="edit-profile-container">
        <h1>Edit Profil</h1>

        <!-- Display current user information -->
        <p><strong>Full Name:</strong> {{ $userData["name"] }}</p>
        <p><strong>Email:</strong> {{ $userData["email"] }}</p>

        <!-- Edit form -->
        <form method="post" action="{{ route('user.update.profile') }}">
            @csrf
            <label for="new_username">Username Baru:</label>
            <input type="text" id="new_username" name="new_username" placeholder="Enter new username">

            <label for="new_email">Email Baru:</label>
            <input type="email" id="new_email" name="new_email" placeholder="Enter new email">

            <label for="new_password">Password Baru:</label>
            <input type="password" id="new_password" name="new_password" placeholder="Enter new password">

            <button type="submit">Save Changes</button>
        </form>

        <br>

        <form action="{{ route('user.profile') }}" method="get">
            <button type="submit">Profil</button>
        </form>

        <br>

        <form action="{{ route('user.index') }}" method="get">
            <button type="submit">Kembali ke Beranda </button>
        </form>
    </div>
</body>
</html>
