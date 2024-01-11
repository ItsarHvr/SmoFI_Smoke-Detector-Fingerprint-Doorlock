<!DOCTYPE html>
<html lang="en">

<head>
    <title>Enroll Fingerprint</title>
   
</head>

<body>
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Enroll Fingerprint') }}
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        <section>
                            <header>
                                <h2 class="text-lg font-medium text-gray-900">
                                    {{ __('Enroll Fingerprint Information') }}
                                </h2>
                            </header>

                            <form action="{{ url('home') }}" method="post" class="mt-6 space-y-6">
                                @csrf

                                <div>
                                    <x-input-label for="nama" :value="__('Nama')" />
                                    <input type="text" id="nama" name="nama" required autofocus autocomplete="name"
                                        class="mt-1 block w-full">
                                </div>

                                <div>
                                    <x-input-label for="id_fingerprint" :value="__('ID Fingerprint')" />
                                    <input type="text" id="id_fingerprint" name="id_fingerprint" required
                                        class="mt-1 block w-full">
                                </div>

                                <div class="flex items-center gap-4">
                                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold
                                        py-2 px-4 rounded">
                                        {{ __('Submit Fingerprint') }}
                                    </button>
                                </div>
                            </form>

                            <div class="flex items-center gap-4 mt-4">
                                <button type="button" onclick="window.location.href='/userlist'"
                                    class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                    {{ __('Back to User List') }}
                                </button>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>
</body>

</html>
