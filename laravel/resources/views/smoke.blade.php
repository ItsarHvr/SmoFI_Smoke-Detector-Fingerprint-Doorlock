<!DOCTYPE html>
<html lang="en">
<title>Smoke Detector - Smart Door Lock Using Fingerprint & Smoke Detector</title>
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/stylesmoke.css') }}">
</head>
<body>
    <div class="container">
        <h1>Smoke Detector Data</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Status</th>
                    <th>Timestamp</th>
                </tr>
            </thead>
            <tbody>
                @php
                    // Generate fake data using Faker
                    $faker = Faker\Factory::create();
                    $fakeData = [];

                    for ($i = 1; $i <= 10; $i++) {
                        $fakeData[] = (object) [
                            'id' => $i,
                            'status' => $faker->boolean ? 'Smoke Detected' : 'No Smoke',
                            'timestamp' => $faker->dateTimeThisMonth()->format('Y-m-d H:i:s'),
                        ];
                    }
                @endphp

                @foreach ($fakeData as $data)
                    <tr>
                        <td>{{ $data->id }}</td>
                        <td>{{ $data->status }}</td>
                        <td>{{ $data->timestamp }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination Links -->
        <div class="d-flex justify-content-center">
            <!-- Since we don't have actual pagination data, I'm using a placeholder link -->
            <ul class="pagination">
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
            </ul>
        </div>
        <a href="{{ url('/home') }}" class="btn btn-primary">Back to Dashboard</a>
    </div>
</body>
</html>
