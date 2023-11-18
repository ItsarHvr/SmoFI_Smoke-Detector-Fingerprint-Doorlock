<!DOCTYPE html>
<html>
<head>
    <title>Smart Door Lock & Smoke Detector</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
        /* Add CSS styles for user info */
        .user-info {
            float: right;
            margin-top: 10px;
            margin-right: 20px;
            color: #fff; /* Text color */
            cursor: pointer; /* Add cursor style to indicate it's clickable */
        }
    </style>
</head>
<body style="background: url('background.jpg') no-repeat center center fixed;
  background-size: cover;">

    <header>
        <h1>Smart Door Lock & Smoke Detector</h1>
        <!-- Display user's name in the header -->
        <div class="user-info" onclick="location.href='profile.php';">
            <?php
            session_start();
            if (isset($_SESSION["full_name"])) {
                echo "Welcome, " . $_SESSION["full_name"] . "!";
            }
            ?>
            <form method="post" action="login.php">
                <button type="submit" name="logout">Logout</button>
            </form>
        </div>
    </header>

    <div class="container">
        <div class="device">
            <a href="log_akses.html"> <img src="door.jpg" alt="Smart Door Lock"> </a>
            <h2>Smart Door Lock</h2>
            <p>Monitor and control your door lock remotely with our smart lock technology.</p>
        </div>
        <div class="device">
            <img src="smoke.jpg" alt="Smoke Detector">
            <h2>Smoke Detector</h2>
            <p>Get real-time alerts about smoke or fire in your home with our smart smoke detector.</p>
        </div>
        <div class="device">
            <img src="lock.png" alt="Lock Unlock">
            <h2>Lock Unlock</h2>
            <p>Get real-time alerts about smoke or fire in your home with our smart smoke detector.</p>
        </div>
    </div>

    <footer>
        &copy; 2023 Smart Home Solutions
    </footer>

</body>
</html>
