<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Sistem BK') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="font-sans antialiased bg-gray-100" x-data="{ sidebarOpen: false }">

    <!-- Sidebar Desktop -->
    @include('layouts.sidebar')

    <!-- Mobile Header -->
    <header class="md:hidden fixed top-0 left-0 right-0 z-40 bg-blue-800 text-white shadow h-16">
        <div class="flex items-center justify-between p-4 h-full">
            <h1 class="text-xl font-bold">Sistem BK</h1>
            <button @click="sidebarOpen = true" class="p-2 rounded-lg hover:bg-blue-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                    </path>
                </svg>
            </button>
        </div>
    </header>

    <!-- Mobile Overlay -->
    <div x-show="sidebarOpen" @click="sidebarOpen = false" class="md:hidden fixed inset-0 bg-black bg-opacity-50 z-40">
    </div>

    <!-- Main Content -->
    <main class="min-h-screen transition-all duration-300 md:ml-64 pt-16 md:pt-0 px-4 sm:px-6 lg:px-8 py-6">
        {{ $slot }}
    </main>

    <!-- Mobile Sidebar -->
    <div x-show="sidebarOpen" @click.away="sidebarOpen = false"
        class="md:hidden fixed top-0 left-0 h-screen w-64 bg-gradient-to-b from-blue-600 to-blue-800 text-white z-50 overflow-y-auto">
        @include('layouts.sidebar')
    </div>
</body>

</html>