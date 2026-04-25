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

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-white">
        <div class="flex">
            <div class="w-48 bg-gray-800 text-white min-h-screen p-6">
                <div class="mb-6 flex justify-left">
                    <x-application-logo class="h-8 w-auto text-white" />
                </div>
                <ul>
                    <li class="mb-2">
                        <a href="/dashboard" class="block p-2 hover:bg-gray-700">Dashboard</a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('products.index') }}" class="block p-2 hover:bg-gray-700">Kelola Produk</a>
                    </li>
                </ul>
            </div>
            <div class="flex-1 p-6">
                @include('layouts.navigation')
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
