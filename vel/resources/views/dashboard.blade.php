<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
            {{ __('Smart Door Lock & Smoke Detector') }}
        </h2>
    </x-slot>

    <div class="container mx-auto mt-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-4">
            <div class="device">
             <a href="log_akses.html">
                    <img src="{{ asset('logo/door.jpg') }}" alt="Smart Door Lock" class="w-full h-auto">
                </a>
                <h2 class="font-semibold text-center">Smart Door Lock</h2>
                <p class="text-center">Buka dan kunci pintu dengan mudah hanya dengan sidik jari</p>
            </div>

            <div class="device">
                <img src="{{ asset('logo/smoke.jpg') }}" alt="Smoke Detector" class="w-full h-auto">
                <h2 class="font-semibold text-center">Smoke Detector</h2>
                <p class="text-center">Dapat notifikasi seketika jika ada tanda asap atau kebakaran di kampus</p>
            </div>

            <div class="device">
                <a href="log_akses.html">
                    <img src="{{ asset('logo/sidik.png') }}" alt="Enroll Fingerprint" class="w-full h-auto">
                </a>
                <h2 class="font-semibold text-center">Enroll Fingerprint</h2>
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
</x-app-layout>
