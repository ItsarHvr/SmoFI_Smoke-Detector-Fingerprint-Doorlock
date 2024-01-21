<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lock Unlock - Smart Door Lock Using Fingerprint & Smoke Detector</title>
    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/stylelock.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <div class="container">
        <h2>Lock & Unlock <br> Smart Door</h2>
        <br>
        <center>
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
                return response.text();
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }

        document.addEventListener("DOMContentLoaded", function (event) {
            Echo.channel(`relay-channel`)
                .listen('RelayEvent', (e) => {
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
            Echo.channel(`relay-channel`)
                .listen('RelayEvent', (e) => {
                    console.log(e);
                    if (e.data !== undefined) {
                        const switchToggle = document.getElementById('switch');
                        if (switchToggle) {
                            switchToggle.checked = (e.data == 1);
                        }
                    }
                });
        });
    </script>
    @endpush
</body>

</html>