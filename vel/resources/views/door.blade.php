<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lock Unlock - Smart Door Lock Using Fingerprint & Smoke Detector</title>
    <link rel="stylesheet" type="text/css" href="css/stylelock.css">
    <style>
        button {
            width: 150px;
            height: 150px;
            background-color: {{ $relayState == 1 ? 'rgb(40, 194, 40)' : 'rgb(229, 81, 81)' }};
            color: #fff;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: {{ $relayState == 1 ? 'rgb(46, 160, 67)' : 'rgb(174, 51, 51)' }};
        }
    </style>
</head>
<body>
    <div class="container">
        <div>
            <h2>Lock & Unlock <br> Smart Door</h2>
        </div>
        <br>
        <form method="post" action="{{ route('door.update') }}">
            @csrf
            <input type="hidden" name="switch" value="{{ $relayState }}">
            
            <button type="button" id="toggleButton" class="toggle" onclick="toggleSwitch()">
                <p>{{ $relayState == 0 ? 'UNLOCK' : 'LOCK' }}</p>
            </button>

            <script>
                function toggleSwitch() {
                    var switchInput = document.getElementsByName('switch')[0];
                    switchInput.value = switchInput.value === '1' ? '0' : '1';
                    document.forms[0].submit();
                }
            </script>
        </form>
        <form action="{{ route('home') }}" method="get">
            <button type="submit" class="back-button">Kembali ke Beranda</button>
        </form>
    </div>
</body>
</html>
