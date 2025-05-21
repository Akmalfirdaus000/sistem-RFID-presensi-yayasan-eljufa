<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel Admin') }}</title>

    <!-- Fonts & Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen flex flex-col md:flex-row">
        <!-- Sidebar Admin -->
        <nav id="sidebar" class="w-64 bg-blue-900 text-white shadow-lg flex flex-col justify-between fixed md:relative md:translate-x-0 transition-transform duration-300 transform -translate-x-full md:w-64 z-50">
            <div>
                <div class="h-16 flex items-center justify-between px-4 border-b shadow-md bg-blue-800 text-white">
                    <a href="{{ route('admin.dashboard') }}" class="text-2xl font-bold flex items-center space-x-2">
                        <i class="fas fa-user-shield text-3xl"></i>
                        <span>Admin Panel</span>
                    </a>
                    <button id="sidebarClose" class="md:hidden text-white text-2xl focus:outline-none">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="p-4 space-y-4">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-blue-900 transition">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>

                    <!-- Dropdown Kelola Pengguna -->
                    <div>
                        <button onclick="toggleMenu('userMenu')" class="flex items-center space-x-3 p-3 w-full rounded-lg bg-blue-800">
                            <i class="fas fa-users"></i>
                            <span>Kelola Pengguna</span>
                            <i class="fas fa-chevron-down ml-auto"></i>
                        </button>
                        <div id="userMenu" class="hidden bg-blue-900 rounded-lg ml-6">
                            <a href="{{ route('admin.users.index') }}" class="block px-4 py-2 text-sm">List Pengguna</a>
                            <a href="{{ route('admin.users.create') }}" class="block px-4 py-2 text-sm">Tambah Pengguna</a>
                        </div>
                    </div>

                    <!-- Dropdown Presensi -->
                    <div>
                        <button onclick="toggleMenu('presensiMenu')" class="flex items-center space-x-3 p-3 w-full rounded-lg bg-blue-800">
                            <i class="fas fa-clipboard-list"></i>
                            <span>Presensi</span>
                            <i class="fas fa-chevron-down ml-auto"></i>
                        </button>
                        <div id="presensiMenu" class="hidden bg-blue-900 rounded-lg ml-6">
                            <a href="{{ route('admin.presensi.index') }}" class="block px-4 py-2 text-sm">List Presensi</a>
                            <a href="{{ route('admin.riwayat.index') }}" class="block px-4 py-2 text-sm">Riwayat</a>
                            <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm">Rekap</a>
                        </div>
                    </div>

                    <!-- Dropdown RFID Management -->
                    <div>
                        <button onclick="toggleMenu('rfidMenu')" class="flex items-center space-x-3 p-3 w-full rounded-lg bg-blue-800">
                            <i class="fas fa-id-card"></i>
                            <span>RFID Management</span>
                            <i class="fas fa-chevron-down ml-auto"></i>
                        </button>
                        <div id="rfidMenu" class="hidden bg-blue-900 rounded-lg ml-6">
                            <a href="{{ route('admin.rfid.index') }}" class="block px-4 py-2 text-sm">List RFID</a>
                            <a href="{{ route('admin.rfid.add') }}" class="block px-4 py-2 text-sm">Tambah RFID</a>
                        </div>
                         <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-blue-900 transition">
                        <i class="fas fa-chart-line"></i>
                        <span>Laporan</span>
                    </a>
                    </div>
                </div>
            </div>
            <!-- User Info & Logout -->
            <div class="border-t mt-4 py-4 bg-blue-800 px-4">
                <p class="font-medium">{{ Auth::user()->name }}</p>
                <p class="text-sm">Role: Admin</p>
                <a href="{{ route('logout') }}" class="mt-3 flex items-center space-x-3 p-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="flex-1 min-h-screen">
            <!-- Navbar untuk mobile -->
            <header class="bg-blue-800 w-full fixed mb-40 z-20 shadow-md p-2 px-4 flex items-center justify-between md:hidden">
                <div class="h-16 flex items-center text-white">
                    <a href="{{ route('admin.dashboard') }}" class="text-2xl font-bold flex items-center space-x-2">
                        <i class="fas fa-user-shield text-3xl"></i>
                        <span>Admin Panel</span>
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
            <main class="p-3 bg-gray-200">@yield('content')</main>
        </div>
    </div>

    <script>
        function toggleMenu(menuId) {
            document.getElementById(menuId).classList.toggle("hidden");
        }
    </script>
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
