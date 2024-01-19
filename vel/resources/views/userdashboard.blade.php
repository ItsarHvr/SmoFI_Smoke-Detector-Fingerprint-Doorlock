<x-app-layout>
    <x-slot name="header">
    <link rel="stylesheet" type="text/css" href="css/styledashboard.css">
    <title>Dashboard - Smart Door Lock Using Fingerprint & Smoke Detector</title>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
            {{ __('Smart Door Lock & Smoke Detector') }}
        </h2>
    </x-slot>

    <div class="container mx-auto mt-8">
        <div class="grid grid-cols-1 md:flex-col lg:flex-col gap-4">
            <div class="device">
            <a href="{{ route('logs') }}">
                    <img src="{{ asset('logo/door.jpg') }}" alt="Smart Door Lock">
                </a>
                <h2 class="font-semibold text-center">Log Access</h2>
                <p class="text-center">The log access feature keeps track of who accessed the door and when</p>
            </div>

            <div class="device">
            <a href="{{ route('smoke') }}">
                <img src="{{ asset('logo/smoke.jpg') }}" alt="Smoke Detector">
                <h2 class="font-semibold text-center">Smoke Detector</h2>
                <p class="text-center">The smoke detector feature provides protection by detecting the presence of smoke and alerting users</p>
            </div>
        </div>
    </div>
    <footer>
        &copy; 2023 Smart Class Kelompok 3
    </footer>
</x-app-layout>
