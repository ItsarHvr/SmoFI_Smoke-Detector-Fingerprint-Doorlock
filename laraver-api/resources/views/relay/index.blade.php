<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relay Control</title>
</head>
<body>
    <h1>Relay Control</h1>
    <button id="toggleRelay">Toggle Relay</button>

    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        document.getElementById('toggleRelay').addEventListener('click', function() {
            axios.post('/toggle-relay')
                .then(response => {
                    console.log(response.data);
                    // Logika untuk menangani respons (jika diperlukan)
                })
                .catch(error => {
                    console.error(error);
                });
        });
    </script>
</body>
</html>
