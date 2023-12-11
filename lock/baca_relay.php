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

echo $relayState;
?>
