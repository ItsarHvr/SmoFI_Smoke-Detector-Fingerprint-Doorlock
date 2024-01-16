<?php
$gasValue = $_GET['gas_value'];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "laravel";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Menyisipkan data ke database
$sql = "INSERT INTO gas_readings (gas_value) VALUES ('$gasValue')";
if ($conn->query($sql) === TRUE) {
    echo "Data inserted successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
