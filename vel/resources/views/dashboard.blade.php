<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
            {{ __('Smart Door Lock & Smoke Detector') }}
        </h2>
    </x-slot>
    <div class="container">
        <div class="device">
            <a href="log_akses.html"> <img src="logo/door.jpg" alt="Smart Door Lock"> </a>
            <h2>Smart Door Lock</h2>
            <p>Buka dan kunci pintu dengan mudah hanya dengan sidik jari </p>
        </div>
        <div class="device">
            <img src="logo/smoke.jpg" alt="Smoke Detector">
            <h2>Smoke Detector</h2>
            <p>Dapat notifikasi seketika jika ada tanda asap atau kebakaran di kampus </p>
        </div>
        <div class="device">
            <a href="lockunlock.html"><img src="logo/lock.png" alt="Lock Unlock"></a>
            <h2>Lock & Unlock</h2>
            <p>Akses buka dan kunci pintu melalui website khusus Admin </p>
        </div>
    </div>
</x-app-layout>

