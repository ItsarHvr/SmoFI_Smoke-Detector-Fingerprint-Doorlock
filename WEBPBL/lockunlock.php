<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lock_unlock";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize the relay state
$relayState = 0;

// Retrieve the current relay state from the database
$sql = "SELECT relay FROM door WHERE id = 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $relayState = $row["relay"];
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['switch'])) {
        $relayState = ($_POST['switch'] == 'on') ? 1 : 0;

        // Update the database
        $updateSql = "UPDATE door SET relay = $relayState WHERE id = 1";
        if ($conn->query($updateSql) === TRUE) {
            echo "<script>alert('Record updated successfully');</script>";
        } else {
            echo "<script>alert('Error updating record: " . $conn->error . "');</script>";
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Door Lock</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #c850c0, #4158d0);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            width: 60%;
            margin-top: 10px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        /* toggle in label designing */
        .toggle-button {
            position: relative;
            display: inline-block;
            width: 102px;
            height: 52px;
            border-radius: 30px;
            border: 2px solid gray;
            overflow: hidden;
            margin-right: 20px;
        }

        /* After slide changes */
        .toggle-button:after {
            content: '';
            position: absolute;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            top: 1px;
            left: 1px;
            transition: all 0.5s;
        }

        /* Toggle text */
        p {
            font-family: Arial, Helvetica, sans-serif;
            font-weight: bold;
            color: black; /* Set text color to black */
        }

        /* Checkbox checked effect */
        .checkbox:checked + .toggle-button::after {
            left: 52px;
        }

        /* Checkbox checked toggle label bg color */
        .checkbox:checked + .toggle-button {
            background-color: <?php echo $relayState == 1 ? 'rgb(229, 81, 81)' : 'rgb(64, 218, 64)'; ?>;
        }

        /* Checkbox vanished */
        .checkbox {
            display: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <img class="logo" src="logo.png" alt="Logo" width="100" height="100">
        <h2> Lock & Unlock Smart Door </h2>
        <br>
        <center>
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <input type="hidden" name="switch" value="0">
                <input type="checkbox" id="switch" class="checkbox" name="switch" <?php echo $relayState == 1 ? 'checked' : ''; ?> onchange="this.form.submit()">
                <label for="switch" class="toggle-button">
                    <p>
                        <?php echo $relayState == 1 ? 'Unlock' : 'Lock'; ?>
                    </p>
                </label>
            </form>
        </center>
    </div>
</body>

</html>
