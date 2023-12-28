<!DOCTYPE html>
<html>
<head>
    <title>Smart Door Lock & Smoke Detector</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
</head>
<body style="background: url('{{ asset('background.jpg') }}') no-repeat center center fixed;
  background-size: cover;">

    <header>
        <h1>Smart Door Lock & Smoke Detector</h1>
        <div class="menu-icon" onclick="toggleMenu()">
            <div class="bar"></div>
            <div class="bar"></div>
            <div class="bar"></div>
        </div>

        <div class="menu" id="menu">
            <a href="javascript:void(0);" onclick="openPopup()">
                <img src="{{ asset('image/ava.jpg') }}" alt="User Avatar" style="width: 50px; height: 50px; border-radius: 50%; cursor:default;">
                <div class="user-info">
                    @php
                        session_start();
                        if (isset($_SESSION["full_name"])) {
                            echo "Welcome, " . $_SESSION["full_name"];
                        }
                    @endphp
                </div>
            </a>
            <a href="{{ route('user.profile') }}">
                🧑‍💼 Profil Saya
            </a>
            <a href="javascript:void(0);" onclick="confirmLogout()">🚪Logout</a>
        </div>
    </header>

    <div class="container">
        <div class="device">
                <img src="{{ asset('image/door.jpg') }}" alt="Smart Door Lock">
            </a>
            <h2>Smart Door Lock</h2>
            <p>Buka dan kunci pintu dengan mudah hanya dengan sidik jari </p>
        </div>
        <div class="device">
            <img src="{{ asset('image/smoke.jpg') }}" alt="Smoke Detector">
            <h2>Smoke Detector</h2>
            <p>Dapat notifikasi seketika jika ada tanda asap atau kebakaran di kampus </p>
        </div>
        <div class="device">
            <h2>Enroll Fingerprint</h2>
            <p>Daftarkan fingerprintmu untuk mengakses pintu </p>
        </div>
    </div>

    <footer>
        &copy; 2023 Smart Class Kelompok 3
    </footer>

    <script>
        function toggleMenu() {
            var menu = document.getElementById("menu");
            if (menu.style.display === "none") {
                menu.style.display = "block";
            } else {
                menu.style.display = "none";
            }
        }

        function confirmLogout() {
            var isLogoutConfirmed = confirm("Apakah Anda yakin untuk logout?");
            if (isLogoutConfirmed) {
                // Redirect atau lakukan logika logout
                window.location.href = "{{ route('user.logout') }}";
            }
        }
    </script>

</body>
</html>
