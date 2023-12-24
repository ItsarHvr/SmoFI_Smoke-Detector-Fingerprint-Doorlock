<!-- resources/views/mqtt.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MQTT Data Display</title>
</head>
<body>
    <div id="app">
        <h1>MQTT Data:</h1>
        <ul>
            <li v-for="message in messages">{{ message }}</li>
        </ul>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
    <script>
        new Vue({
            el: '#app',
            data: {
                messages: []
            },
            created() {
                // Menggunakan teknologi JavaScript MQTT client (misalnya, Paho MQTT)
                const client = new Paho.MQTT.Client('your-mqtt-broker-url', 1883, 'clientId');

                client.onMessageArrived = (message) => {
                    // Menambahkan pesan ke dalam array messages
                    this.messages.push(message.payloadString);
                };

                client.connect({
                    onSuccess: () => {
                        // Berlangganan ke topik 'fingerprint_data'
                        client.subscribe('fingerprint_data');
                    },
                    onFailure: (e) => {
                        console.error('Failed to connect to MQTT broker: ', e);
                    }
                });
            }
        });
    </script>
</body>
</html>
