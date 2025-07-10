<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts & Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen flex flex-col md:flex-row">
        <!-- Sidebar -->
      <!-- Sidebar -->
<nav id="sidebar" class="w-64 bg-teal-800 text-white shadow-lg flex flex-col justify-between fixed md:relative md:translate-x-0 transition-transform duration-300 transform -translate-x-full md:w-64 z-50">
    <div>
        <div class="h-16 flex items-center justify-between px-4 border-b shadow-md bg-teal-900">
            <a href="{{ route('user.dashboard') }}" class="text-2xl font-bold flex items-center space-x-2">
                <i class="fas fa-building-columns text-yellow-300 text-3xl"></i>
                <span>El-Jufa</span>
            </a>
            <button id="sidebarClose" class="md:hidden text-white text-2xl focus:outline-none">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div class="p-4 space-y-4">
            {{-- Dashboard --}}
            <a href="{{ route('user.dashboard') }}"
                class="flex items-center space-x-3 p-3 rounded-lg transition shadow-md
                    {{ request()->routeIs('user.dashboard') ? 'bg-yellow-400 text-teal-900 font-semibold' : 'hover:bg-teal-700' }}">
                <i class="fas fa-gauge-high text-yellow-300 text-lg"></i>
                <span class="font-medium">Dashboard</span>
            </a>

            {{-- Presensi --}}
            <a href="{{ route('presensi.index') }}"
                class="flex items-center space-x-3 p-3 rounded-lg transition shadow-md
                    {{ request()->routeIs('presensi.*') ? 'bg-yellow-400 text-teal-900 font-semibold' : 'hover:bg-teal-700' }}">
                <i class="fas fa-fingerprint text-yellow-300 text-lg"></i>
                <span class="font-medium">Presensi</span>
            </a>

            {{-- Riwayat --}}
            <a href="{{ route('riwayat.index') }}"
                class="flex items-center space-x-3 p-3 rounded-lg transition shadow-md
                    {{ request()->routeIs('riwayat.*') ? 'bg-yellow-400 text-teal-900 font-semibold' : 'hover:bg-teal-700' }}">
                <i class="fas fa-clock-rotate-left text-yellow-300 text-lg"></i>
                <span class="font-medium">Riwayat</span>
            </a>

            {{-- Profil --}}
            <a href="{{ route('profile') }}"
                class="flex items-center space-x-3 p-3 rounded-lg transition shadow-md
                    {{ request()->routeIs('profile') ? 'bg-yellow-400 text-teal-900 font-semibold' : 'hover:bg-teal-700' }}">
                <i class="fas fa-id-badge text-yellow-300 text-lg"></i>
                <span class="font-medium">Profil</span>
            </a>
        </div>
    </div>

    <!-- Info & Logout -->
    <div class="border-t mt-4 py-4 bg-teal-900 px-4">
        <p class="font-medium">{{ Auth::user()->name }}</p>
        <p class="text-sm text-gray-300">NIK: {{ Auth::user()->nik }}</p>
        <a href="{{ route('logout') }}"
            class="mt-3 flex items-center space-x-3 p-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition shadow-md">
            <i class="fas fa-right-from-bracket"></i>
            <span>Logout</span>
        </a>
    </div>
</nav>



        <!-- Main Content -->
        <div class="flex-1 min-h-screen">
            <!-- Navbar untuk mobile -->
            <header class="bg-green-700 w-full fixed mb-40 z-20 shadow-md p-2 px-4 flex items-center justify-between md:hidden">
                <div class="h-16 flex items-center text-white">
                    <a href="{{ route('user.dashboard') }}" class="text-2xl font-bold flex items-center space-x-2">
                        <i class="fas fa-shield-alt text-3xl"></i>
                        <span>MyApp</span>
                    </a>
                </div>
                <button id="sidebarOpen" class="text-white text-2xl focus:outline-none">
                    <i class="fas fa-bars"></i>
                </button>
            </header>

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow-md p-6">
                    <div class="max-w-7xl mx-auto">{{ $header }}</div>
                </header>
            @endisset

            <!-- Page Content -->
            {{-- <main class=" bg-gray-200">@yield('content')</main> --}}
            <main class="bg-gray-200 h-screen md:h-screen max-h-screen overflow-y-auto p-4">
    @yield('content')
</main>

        </div>
    </div>

    @include('components.landing.footer')

    <!-- JavaScript for Sidebar Toggle -->
    <script>
        const sidebar = document.getElementById("sidebar");
        const sidebarOpen = document.getElementById("sidebarOpen");
        const sidebarClose = document.getElementById("sidebarClose");

        sidebarOpen.addEventListener("click", () => {
            sidebar.classList.remove("-translate-x-full");
        });

        sidebarClose.addEventListener("click", () => {
            sidebar.classList.add("-translate-x-full");
        });
    </script>
</body>

</html>
