<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logs Access - Smart Door Lock Using Fingerprint & Smoke Detector</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/stylelogakses.css') }}">
</head>
<body>
    <div class="container">
        <h1>Logs Access - Smart Door Lock</h1>
        <table>
            <tr>
                <th>Nama</th>
                <th>ID Fingerprint</th>
                <th>Tanggal</th>
                <th>Waktu</th>
                <th>Keterangan</th>
            </tr>
            <!-- Fictitious Data for Pagination -->
            @php
                $rowsPerPage = 5;
                $totalRows = 20; // Total number of rows in your dataset

                // Assuming page number is provided via query parameter (e.g., ?page=2)
                $currentPage = request('page', 1);
                $startRow = ($currentPage - 1) * $rowsPerPage;

                $totalPages = ceil($totalRows / $rowsPerPage);
            @endphp

            @for ($i = $startRow + 1; $i <= min($startRow + $rowsPerPage, $totalRows); $i++)
                <tr>
                    <td>user{{ $i }}@example.com</td>
                    <td>{{ $i }}</td>
                    <td>2024-01-05</td>
                    <td>12:00 PM</td>
                    <td>Access Granted</td>
                </tr>
            @endfor
        </table>
        <br>
        <a href="{{ url('/home') }}" class="btn btn-primary mb-3">Back to Dashboard</a>

        <!-- Pagination -->
        <nav aria-label="Page navigation">
            <ul class="pagination">
                {{-- Previous Page --}}
                <li class="page-item {{ $currentPage == 1 ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ url('logs?page=' . ($currentPage - 1)) }}" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>

                {{-- Page Numbers --}}
                @for ($i = 1; $i <= $totalPages; $i++)
                    <li class="page-item {{ $currentPage == $i ? 'active' : '' }}">
                        <a class="page-link" href="{{ url('logs?page=' . $i) }}">{{ $i }}</a>
                    </li>
                @endfor

                {{-- Next Page --}}
                <li class="page-item {{ $currentPage == $totalPages ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ url('logs?page=' . ($currentPage + 1)) }}" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</body>
</html>
