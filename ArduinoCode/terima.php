<?php
// Cek apakah data POST telah diterima
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Cek apakah parameter 'message' telah dikirim
    if (isset($_POST["message"])) {
        // Ambil data dari parameter 'message'
        $message = $_POST["message"];

        // Lakukan operasi atau simpan data ke database sesuai kebutuhan
        // Misalnya, menyimpan data ke dalam file atau database
        // Di sini kita hanya mencetak pesan yang diterima
        echo "Message received: " . $message;
    } else {
        // Jika parameter 'message' tidak ada
        echo "Error: 'message' parameter is missing";
    }
} else {
    // Jika bukan metode POST
    echo "Error: Only POST requests are allowed";
}
?>
