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
            
            <form action="{{ url('home') }}" method="get">
                <button type="submit">Submit Fingerprint</button>
            </form>
            <button type="button" onclick="window.location.href='/userlist'" class="back-btn">Back to User List</button>
        </center>
    </div>
</body>
</html>
