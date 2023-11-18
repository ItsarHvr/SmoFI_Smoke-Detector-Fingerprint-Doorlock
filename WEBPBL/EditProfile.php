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
<html>
<head>
    <title>Edit Profile</title>
    <!-- Add CSS or styling as needed -->
</head>
<body>
    <h1>Edit Profile</h1>

    <!-- Display current user information -->
    <p><strong>Full Name:</strong> <?php echo $userData["full_name"]; ?></p>
    <p><strong>Email:</strong> <?php echo $userData["email"]; ?></p>

    <!-- Edit form -->
    <form method="post" action="">
        <label for="new_username">New Username:</label>
        <input type="text" id="new_username" name="new_username" placeholder="Enter new username">

        <label for="new_email">New Email:</label>
        <input type="email" id="new_email" name="new_email" placeholder="Enter new email">

        <label for="new_password">New Password:</label>
        <input type="password" id="new_password" name="new_password" placeholder="Enter new password">

        <button type="submit">Save Changes</button>
    </form>
</body>
</html>
