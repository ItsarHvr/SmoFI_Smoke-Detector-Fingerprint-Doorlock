<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logs Access - Smart Door Lock</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
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
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #ffffff;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 12px;
            color: #333;
        }
        th {
            background-color: #f2f2f2;
        }
        .logo {
            top: 115px;
            right: 240px;
            z-index: 1;
        }
    </style>
</head>
<body>
    <div class="container">
        <img class="logo" src="logo.png" alt="Logo" width="100" height="100">
        <h1> Log Access</h1>
        <h2>Logs Access - Smart Door Lock</h2>
        <table>
            <tr>
                <th>Email</th>
                <th>ID Fingerprint</th>
                <th>Tanggal</th>
                <th>Waktu</th>
                <th>Keterangan</th>
            </tr>
            <?php
                $servername = "localhost"; // Ganti dengan alamat server MySQL Anda
                $username = "root";
                $password = "";
                $dbname = "log_access";

                // Buat koneksi
                $conn = new mysqli($servername, $username, $password, $dbname);

                // Periksa koneksi
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Ambil data log akses dari database dengan JOIN
                $sql = "SELECT fingerprint.*, users.email FROM fingerprint
                        LEFT JOIN users ON fingerprint.id_fingerprint = id_fingerprint";
                $result = $conn->query($sql);

                // Tampilkan data log akses
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["email"] . "</td>";
                        echo "<td>" . $row["id"] . "</td>";
                        echo "<td>" . $row["timestamp"] . "</td>";
                        // Tambahkan kolom lain sesuai kebutuhan
                        echo "<td></td>"; // Waktu
                        echo "<td></td>"; // Keterangan
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No logs found</td></tr>";
                }

                $conn->close();
            ?>
        </table>
    </div>
</body>
</html>
