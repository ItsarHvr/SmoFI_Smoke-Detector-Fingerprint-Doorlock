<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Relay</title>
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/paho-mqtt/1.0.3/paho-mqtt.min.js"></script>
</head>
<body>
    <div class="container">
        <h2 align='center'>Status Relay Pintu</h2>
        <center>
            <form id="statusForm" method="post" action="/perbarui-status-relay">
                @csrf
                <input type="hidden" name="switch" value="0">
                <input type="checkbox" id="switch" class="checkbox" name="switch" {{ $statusRelay == 1 ? 'checked' : '' }} onchange="toggleCheckbox()">
                <label for="switch" class="toggle">
                </label>
                <p id="statusText" class="tulis"></p>
            </form>
            <form action="/" method="get">
                <button type="submit">Kembali ke Beranda</button>
            </form>
        </center>
    </div>
    <script>
        // Function to update checkbox status and status text
        function updateCheckboxStatus(statusRelay) {
            const checkbox = document.getElementById('switch');
            checkbox.checked = statusRelay === 1;

            const statusText = document.getElementById('statusText');
            statusText.innerHTML = statusRelay === 0 ? 'Pintu Terkunci' : 'Pintu Terbuka';
        }

        // Function to submit the form using Ajax
        function toggleCheckbox() {
            const form = document.getElementById('statusForm');
            const formData = new FormData(form);

            fetch('/perbarui-status-relay', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
            })
            .then(response => response.json())
            .then(data => {
                updateCheckboxStatus(data.statusRelay);
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }

        // Subscribe to MQTT for real-time updates
        const mqttClient = new Paho.MQTT.Client('192.168.100.4', 1883, 'web_' + parseInt(Math.random() * 100, 10));
        mqttClient.connect({
            onSuccess: function () {
                mqttClient.subscribe('relay/status');
            },
            onFailure: function (message) {
                console.error('MQTT Connection Failure: ' + message.errorMessage);
            }
        });

        mqttClient.onMessageArrived = function (message) {
            const payload = JSON.parse(message.payloadString);
            updateCheckboxStatus(payload.statusRelay);
        };
    </script>
</body>
</html>
