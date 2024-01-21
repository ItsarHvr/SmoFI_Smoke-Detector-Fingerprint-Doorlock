<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smoke Detector - Gas Readings</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/stylesmoke.css') }}">
</head>
<body>
    <div class="container mt-4">
        <h1>Gas Readings Data</h1>

        <table class="table">
            <thead>
                <tr>
                    <th>Gas Value</th>
                    <th>Status</th>
                    <th>Timestamp</th>
                </tr>
            </thead>
            <tbody id="gasReadingsTableBody">
                @foreach ($gasReadings->sortByDesc('id') as $reading)
                    <tr>
                        <td>{{ $reading->gas_value }}</td>
                        <td>{{ $reading->gas_value > 1000 ? ' Gas Detected' : 'Gas Not Detected' }}</td>
                        <td>{{ $reading->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="custom-pagination">
            @if ($gasReadings->previousPageUrl())
                <a href="{{ $gasReadings->previousPageUrl() }}" class="btn btn-primary" onclick="updateCurrentPage({{ $gasReadings->currentPage() - 1 }})">Previous</a>
            @endif
            @if ($gasReadings->nextPageUrl())
                <a href="{{ $gasReadings->nextPageUrl() }}" class="btn btn-primary" onclick="updateCurrentPage({{ $gasReadings->currentPage() + 1 }})">Next</a>
            @endif
        </div>

        <a href="{{ url('/home') }}" class="btn btn-primary mt-3">Back to Dashboard</a>
    </div>
    @vite('resources/js/app.js')

<script>
let currentPage = parseInt("{{ $gasReadings->currentPage() }}");
document.addEventListener("DOMContentLoaded", function(event) { 
    const gasReadingsTableBody = document.getElementById('gasReadingsTableBody');

    Echo.channel('smoke-channel')
        .listen('SmokeEvent', (e) => {
            console.log(e);
            const gasReading = e.data;
            if (gasReading !== undefined) {
                addGasReadingToTable(gasReading);
                console.log('Data:', gasReading);
            }
        });
});

function updateCurrentPage(newPage) {
    currentPage = newPage;
}

function addGasReadingToTable(gasReading) {
    const formattedTimestamp = formatTimestamp(gasReading.created_at);

    // If on page 1, add the row to the top of the table
    if (currentPage === 1) {
        if (gasReadingsTableBody.rows.length >= 6) {
            gasReadingsTableBody.deleteRow(gasReadingsTableBody.rows.length - 1);
        }
        const newRow = gasReadingsTableBody.insertRow(0);
        newRow.innerHTML = `
            <td>${gasReading.gas_value}</td>
            <td>${gasReading.gas_value > 1000 ? ' Gas Detected' : 'Gas Not Detected' }</td>
            <td>${formattedTimestamp}</td>
        `;
    } else {
    // Fetch only the last item from the previous page
    const previousPage = currentPage - 1;
    const apiUrl = `http://localhost:8000/api/smoke-value?page=${previousPage}&per_page=1`;

    axios.get(apiUrl)
        .then(response => {
            const previousPageData = response.data.data;
            if (previousPageData.length > 0) {
                const lastItemOnPreviousPage = previousPageData[5];
                const newRow = gasReadingsTableBody.insertRow(0);
                newRow.innerHTML = `
                    <td>${lastItemOnPreviousPage.gas_value}</td>
                    <td>${lastItemOnPreviousPage.gas_value > 1000 ? ' Gas Detected' : 'Gas Not Detected' }</td>
                    <td>${formatTimestamp(lastItemOnPreviousPage.created_at)}</td>
                `;

                // Remove the last row if the table exceeds 6 rows
                if (gasReadingsTableBody.rows.length > 6) {
                    gasReadingsTableBody.deleteRow(gasReadingsTableBody.rows.length - 1);
                }
            } else {
                console.log('No data on the previous page');
            }
        })
        .catch(error => {
            console.error('Error fetching data:', error);
        });
    }
}

function formatTimestamp(timestamp) {
    const date = new Date(timestamp);
    const year = date.getFullYear();
    const month = (date.getMonth() + 1).toString().padStart(2, '0');
    const day = date.getDate().toString().padStart(2, '0');
    const hours = date.getHours().toString().padStart(2, '0');
    const minutes = date.getMinutes().toString().padStart(2, '0');
    const seconds = date.getSeconds().toString().padStart(2, '0');

    const formattedTimestamp = `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
    return formattedTimestamp;
}
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
