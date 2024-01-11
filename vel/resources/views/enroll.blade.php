<!DOCTYPE html>
<html lang="en">

<head>
    <title>Enroll Fingerprint</title>
    <link rel="stylesheet" href="{{ asset('css/styleenroll.css') }}">
</head>

<body>
    <div class="container">
        <h1>Enroll Fingerprint</h1>
        <br>
        <center>
            <img class="logo" src="{{ asset('logo/finger.png') }}" alt="Logo" width="150" height="150">
            <form action="{{ url('home') }}" method="post">
                <!-- Use <label> for better semantics -->
                <label for="nama">		Nama:</label>
                <input type="text" id="nama" name="nama" required>
<br>
                <!-- Use <label> for better semantics -->
                <label for="id_fingerprint">	ID Fingerprint:</label>
                <input type="text" id="id_fingerprint" name="id_fingerprint" required>
<br>
                <button type="submit">Submit Fingerprint</button>
            </form>

            <button type="button" onclick="window.location.href='/userlist'" class="back-btn">Back to User List</button>
        </center>
    </div>
</body>
</html>
