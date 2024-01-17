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

    <!-- Table inside Container -->
    <table class="table">
        <thead>
            <tr>
                <th>Nama</th>
                <th>ID Fingerprint</th>
                <th>Tanggal</th>
                <th>Waktu</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody id="logAccessTableBody" data-current-page="{{ $logAccesses->currentPage() }}" data-total-pages="{{ $logAccesses->lastPage() }}">
            @foreach ($logAccesses as $logAccess)
                <tr>
                    <td>{{ $logAccess->user_name }}</td>
                    <td>{{ $logAccess->fingerprint_id }}</td>
                    <td>{{ $logAccess->access_date }}</td>
                    <td>{{ $logAccess->access_time }}</td>
                    <td>{{ $logAccess->access }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination -->
    <nav aria-label="Page navigation">
        <ul class="pagination" id="paginate">
            {{-- Previous Page --}}
            <li class="page-item {{ $logAccesses->currentPage() == 1 ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $logAccesses->previousPageUrl() }}" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>

            <div id="pageNumber">
            {{-- Page Numbers --}}
            @for ($i = 1; $i <= $logAccesses->lastPage(); $i++)
                <li class="page-item {{ $logAccesses->currentPage() == $i ? 'active' : '' }}">
                    <a class="page-link" href="{{ $logAccesses->url($i) }}">{{ $i }}</a>
                </li>
            @endfor
        {{-- Page numbers will be dynamically added here --}}
    </div>

            {{-- Next Page --}}
            <li class="page-item {{ $logAccesses->currentPage() == $logAccesses->lastPage() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $logAccesses->nextPageUrl() }}" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>

    <br>
    <a href="{{ url('/home') }}" class="btn btn-primary mb-3">Back to Dashboard</a>
</div>
<script>
    let totalPages;
let currentPage;
const itemsPerPage = 15;

document.addEventListener("DOMContentLoaded", function (event) {
    const logAccessTableBody = document.getElementById('logAccessTableBody');
    currentPage = parseInt(logAccessTableBody.getAttribute('data-current-page'));
    totalPages = parseInt(logAccessTableBody.getAttribute('data-total-pages'));

    console.log('Client sedang berada di halaman:', currentPage);

    function getTotalData() {
    fetch('http://localhost:8000/api/log-access')
        .then(response => response.json())
        .then(data => {
            console.log('Data dari API:', data);
            console.log('Total halaman pada paginasi:', totalPages);

            // Hanya memperbarui totalPages jika data.total berubah
            const newTotalPages = Math.ceil(data.total / itemsPerPage);
            if (totalPages !== newTotalPages) {
                totalPages = newTotalPages || 1; // Jika totalPages 0, set menjadi 1
                console.log('Total halaman diperbarui menjadi:', totalPages);

                // Tambahkan nomor halaman pada halaman berikutnya
                addPageNumber(totalPages, totalPages);
            }
        })
        .catch(error => console.error('Error fetching total data:', error));
}

    getTotalData();

    Echo.channel('log-access-channel')
        .listen('LogAccessEvent', (e) => {
            console.log(e);
            if (e.logAccess !== undefined && e.paginate !== undefined) {
                if (currentPage === totalPages) {
                    // Client berada di halaman terakhir
                    addLogAccessToNextPage(e.logAccess);
                } else {
                    // Client tidak berada di halaman terakhir, tampilkan data di console saja
                    console.log('Client tidak berada di halaman terakhir. Data:', e.logAccess);
                }
            }
            getTotalData();
        });
});

function addPageNumber(paginate) {
    const pageNumber = document.getElementById('pageNumber');
    pageNumber.innerHTML = '';

    for (let i = 1; i <= paginate; i++) {
        const listItem = document.createElement('li');
        listItem.className = `page-item ${currentPage === i ? 'active' : ''}`;

        const link = document.createElement('a');
        link.className = 'page-link';
        link.href = `/logs?page=${i}`; // Sesuaikan dengan URL yang benar
        link.textContent = i;

        listItem.appendChild(link);
        pageNumber.appendChild(listItem);
    }
}

function addLogAccessToNextPage(logAccess) {
    const logAccessTableBody = document.getElementById('logAccessTableBody');
    const numRowsPerPage = 15;

    // Tambahkan baris baru
    const newRow = document.createElement('tr');
    newRow.innerHTML = `
        <td>${logAccess.user_name}</td>
        <td>${logAccess.fingerprint_id}</td>
        <td>${logAccess.access_date}</td>
        <td>${logAccess.access_time}</td>
        <td>${logAccess.access}</td>
    `;

    logAccessTableBody.appendChild(newRow);

    const currentRowCount = logAccessTableBody.children.length;

    // Cek jika halaman penuh setelah penambahan baris baru
    if (currentRowCount % numRowsPerPage === 0) {
        // Perbarui totalPages
        totalPages++;

        // Tambahkan nomor halaman pada halaman berikutnya
        addPageNumber(totalPages);

        // Log the data to the console
        console.log('Halaman terakhir penuh. Tambahkan nomor halaman berikutnya. Data:', logAccess);
    }
}

</script>

    @vite('resources/js/app.js')
    @push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function (event) {
    const logAccessTableBody = document.getElementById('logAccessTableBody');
    const currentPage = parseInt(logAccessTableBody.getAttribute('data-current-page'));
    totalPages = parseInt(logAccessTableBody.getAttribute('data-total-pages')); // menggunakan variabel global totalPages

    console.log('Client sedang berada di halaman:', currentPage);
    console.log('Total halaman pada paginasi:', totalPages);

    Echo.channel('log-access-channel')
        .listen('LogAccessEvent', (e) => {
            console.log(e);
            if (e.logAccess !== undefined) {
                if (currentPage === totalPages) {
                    // Client berada di halaman terakhir
                    addLogAccessToNextPage(e.logAccess);
                } else {
                    // Client tidak berada di halaman terakhir, tampilkan data di console saja
                    console.log('Client tidak berada di halaman terakhir. Data:', e.logAccess);
                }
            }
        });
});
    </script>
    @endpush
</body>
</html>
