<?php
session_start();

require_once "database.php"; // Make sure to include the database connection
require_once "UserProfile.php";

// Make sure the user is logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

// Create a UserProfile object
$db = new Database();
$userProfile = new UserProfile($db, $_SESSION["user_id"]);

// Fetch user data
$userData = $userProfile->getUserData();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle changing username
    if (!empty($_POST["new_username"])) {
        $newUsername = $_POST["new_username"];
        // Validate and update the username in the database
        // You may want to add more validation and error handling
        // Update the database with the new username
        $db->updateUsername($_SESSION["user_id"], $newUsername);
    }

    // Handle changing email
    if (!empty($_POST["new_email"])) {
        $newEmail = $_POST["new_email"];
        // Validate and update the email in the database
        // You may want to add more validation and error handling
        // Update the database with the new email
        $db->updateEmail($_SESSION["user_id"], $newEmail);
    }

    // Handle changing password
    if (!empty($_POST["new_password"])) {
        $newPassword = password_hash($_POST["new_password"], PASSWORD_DEFAULT);
        // Update the database with the new hashed password
        $db->updatePassword($_SESSION["user_id"], $newPassword);
    }
}
?>

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
    <?php
    // Your PHP code remains unchanged
    ?>

    <div class="edit-profile-container">
        <h1>Edit Profil</h1>

        <!-- Display current user information -->
        <p><strong>Full Name:</strong> <?php echo $userData["full_name"]; ?></p>
        <p><strong>Email:</strong> <?php echo $userData["email"]; ?></p>

        <!-- Edit form -->
        <form method="post" action="">
            <label for="new_username">Username Baru:</label>
            <input type="text" id="new_username" name="new_username" placeholder="Enter new username">

            <label for="new_email">Email Baru:</label>
            <input type="email" id="new_email" name="new_email" placeholder="Enter new email">

            <label for="new_password">Password Baru:</label>
            <input type="password" id="new_password" name="new_password" placeholder="Enter new password">

            <button type="submit">Save Changes</button>
        </form>
        <br>
        <form action="profile.php" method="get">
            <button type="submit">Profil</button>
        </form>
        <br>
        <form action="dashboard.php" method="get">
            <button type="submit">Kembali ke Beranda </button>
        </form>
        <br>
    </div>
</body>
</html>
