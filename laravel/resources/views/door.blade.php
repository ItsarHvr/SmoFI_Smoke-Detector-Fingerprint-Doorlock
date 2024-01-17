<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lock Unlock - Smart Door Lock Using Fingerprint & Smoke Detector</title>
    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
            width: 30%;
            text-align: center;
            margin-top: 10px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .toggle,
        .back-button {
            width: 150px;
            height: 150px;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .toggle {
            position: relative;
            display: inline-block;
            border-radius: 100%;
            background-color: #ccc;
            cursor: pointer;
        }

        .toggle:after {
            content: "Off";
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 24px;
            color: #fff;
            opacity: 1;
            transition: opacity 0.3s;
        }

        .checkbox {
            display: none;
        }

        .checkbox:checked+.toggle {
            background-color: #4CAF50;
        }

        .checkbox:checked+.toggle:after {
            content: "On";
            opacity: 1;
        }

        .tulis {
            font-size: 18px;
            color: #000;
            transition: color 0.3s;
        }

        .checkbox:checked+.toggle+.tulis::before {
            content: "Pintu Terbuka";
        }

        .tulis::before {
            content: "Pintu Terkunci";
            display: block;
        }

        .checkbox:checked+.toggle:after+.tulis::before {
            content: "Pintu Tertutup";
        }

        .back-button {
            width: 150px;
            height: 50px;
            background-color: #3490dc;
            color: #fff;
            border-radius: 25px;
            margin-top: 20px;
        }

        .back-button:hover {
            background-color: #2779bd;
        }

        .logo-container {
            display: flex;
            justify-content: flex-start;
            margin-bottom: 20px;
        }

        .logo {
            max-width: 100px;
            max-height: 100px;
        }

        h2 {
            margin: 0;
            text-align: center;
        }

        @media only screen and (max-width: 600px) {
            .container {
                width: 100%;
            }

            button,
            .back-button {
                width: 100%;
                height: 80px;
                border-radius: 10px;
                margin-top: 10px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Lock & Unlock <br> Smart Door</h2>
        <br>
        <center>
            <!-- Remove the duplicated switch input -->
            <form id="statusForm" method="post" action="/door-update">
                @csrf
                <input type="hidden" name="switch" value="off">
                <input type="checkbox" id="switch" class="checkbox" name="switch" {{ $statusRelay == 1 ? 'checked' : '' }} onchange="toggleCheckbox()">
                <label for="switch" class="toggle"></label>
            </form>
            <form action="/home" method="get">
                <button type="submit" class="back-button">Kembali ke Beranda</button>
            </form>
        </center>
    </div>
    <script>
        function updateCheckboxStatus(statusRelay) {
            const checkbox = document.getElementById('switch');
            checkbox.checked = statusRelay === 1;
        }

        function toggleCheckbox() {
            const form = document.getElementById('statusForm');
            const formData = new FormData(form);

            fetch('/door-update', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.text(); // Read the response as text, not JSON
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }

        document.addEventListener("DOMContentLoaded", function (event) {
            Echo.channel(`hello-channel`)
                .listen('HelloEvent', (e) => {
                    console.log(e);
                    if (e.data !== undefined) {
                        updateCheckboxStatus(e.data);
                    }
                });
        });
    </script>
    
    @vite('resources/js/app.js')
    @push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function (event) {
            Echo.channel(`hello-channel`)
                .listen('HelloEvent', (e) => {
                    console.log(e);
                    // Check if the event payload contains the 'data' property
                    if (e.data !== undefined) {
                        // Toggle the switch based on the value of e.data
                        const switchToggle = document.getElementById('switch');
                        if (switchToggle) {
                            switchToggle.checked = (e.data == 1); // Set to true (on) if e.data is 1, otherwise false (off)
                        }
                    }
                });
        });
    </script>
    @endpush
</body>

</html>