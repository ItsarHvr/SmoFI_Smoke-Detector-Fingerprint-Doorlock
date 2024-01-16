<x-app-layout>
    <x-slot name="header">
    <link rel="stylesheet" type="text/css" href="css/styledashboard.css">
    <title>Dashboard - Smart Door Lock Using Fingerprint & Smoke Detector</title>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
            {{ __('Smart Door Lock & Smoke Detector') }}
        </h2>
    </x-slot>

    <div class="container mx-auto mt-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-4">
            <div class="device">
                <a href="{{ route('logs') }}">
                    <img src="{{ asset('logo/door.jpg') }}" alt="Smart Door Lock" class="w-full h-auto">
                </a>
                <h2 class="font-semibold text-center">Log Access</h2>
                <p class="text-center">Buka dan kunci pintu dengan mudah hanya dengan sidik jari</p>
            </div>

            <div class="device">
                <a href="{{ route('smoke') }}">
                    <img src="{{ asset('logo/smoke.jpg') }}" alt="Smoke Detector" class="w-full h-auto">
                </a>
                <h2 class="font-semibold text-center">Smoke Detector</h2>
                <p class="text-center">Dapat notifikasi seketika jika ada tanda asap atau kebakaran di kampus</p>
            </div>

            <div class="device">
            <a href="{{ route('userlist.index') }}">
                    <img src="{{ asset('logo/sidik.png') }}" alt="Enroll Fingerprint" class="w-full h-auto">
                </a>
                <h2 class="font-semibold text-center">User List</h2>
                <p class="text-center">Daftarkan fingerprintmu untuk mengakses pintu</p>
            </div>

            <div class="device">
                <a href="{{ route('door') }}">
                    <img src="{{ asset('logo/lock.png') }}" alt="Lock Unlock" class="w-full h-auto">
                </a>
                <h2 class="font-semibold text-center">Lock Unlock</h2>
                <p class="text-center">Daftarkan fingerprintmu untuk mengakses pintu</p>
            </div>
        </div>
    </div>
    <footer>
        &copy; 2023 Smart Class Kelompok 3
    </footer>
</x-app-layout>

