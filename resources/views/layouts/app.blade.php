<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="icon" type="image/png" href="https://aircinelmvc.blob.core.windows.net/resources/inovcorp_logo_book_bg_removed.png.png">


        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
    </head>
    <body class="font-serif antialiased bg-cover bg-center bg-no-repeat"
          style="background-image: url('https://aircinelmvc.blob.core.windows.net/resources/libraryBackground2blurred.jpg');">

    @livewire('navigation-menu')

    <x-banner/>

    <!-- Page Heading -->
    @if (isset($header))
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
    @endif

    <div class="text-black min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 p-6">
            <div class="bg-white overflow-hidden shadow-xl rounded-lg m-3">
                <!-- Page Content -->
                <main class="flex-grow w-full h-full">
                    {{ $slot }}
                </main>
            </div>
        </div>

        @stack('modals')

        @livewireScripts

    </div>
    <footer class="text-center text-sm text-gray-500 bg-white py-4 shadow w-full">
        Created by Nuno Salavessa Mota using Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP
        v{{ PHP_VERSION }})
    </footer>
    </body>
</html>
