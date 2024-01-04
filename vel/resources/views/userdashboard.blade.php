<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
            {{ __('Smart Door Lock & Smoke Detector') }}
        </h2>
    </x-slot>

    <div class="container mx-auto mt-8">
        <div class="grid grid-cols-1 md:flex-col lg:flex-col gap-4">
            <div class="device">
                <a href="log_akses.html">
                    <img src="{{ asset('logo/door.jpg') }}" alt="Smart Door Lock">
                </a>
                <h2 class="font-semibold text-center">Smart Door Lock</h2>
                <p class="text-center">Buka dan kunci pintu dengan mudah hanya dengan sidik jari</p>
            </div>

            <div class="device">
                <img src="{{ asset('logo/smoke.jpg') }}" alt="Smoke Detector">
                <h2 class="font-semibold text-center">Smoke Detector</h2>
                <p class="text-center">Dapat notifikasi seketika jika ada tanda asap atau kebakaran di kampus</p>
            </div>
        </div>
    </div>
</x-app-layout>
