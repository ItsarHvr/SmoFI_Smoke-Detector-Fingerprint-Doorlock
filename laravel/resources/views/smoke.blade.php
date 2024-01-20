<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smoke Detector - Gas Readings</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/stylesmoke.css') }}">
</head>
<body>
    <div class="container mt-4">
        <h1>Gas Readings Data</h1>

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Gas Value</th>
                    <th>Status</th>
                    <th>Timestamp</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($gasReadings->sortByDesc('id') as $reading)
                    <tr>
                        <td>{{ $reading->id }}</td>
                        <td>{{ $reading->gas_value }}</td>
                        <td>{{ $reading->gas_value > 1000 ? ' Gas Detected' : 'Gas Not Detected' }}</td>
                        <td>{{ $reading->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Custom Styled Pagination -->
        <div class="custom-pagination">
            {{ $gasReadings->render() }}
        </div>

        <a href="{{ url('/home') }}" class="btn btn-primary mt-3">Back to Dashboard</a>
    </div>
    @vite('resources/js/app.js')
    <script>
        document.addEventListener("DOMContentLoaded", function(event) { 
            Echo.channel(`smoke-channel`)
                 .listen('SmokeEvent', (e) => {
                    console.log(e);
    });
});
        
    </script>

    <!-- Bootstrap JS (optional, if you need it) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>