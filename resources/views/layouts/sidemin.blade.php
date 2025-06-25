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
    <div class="flex h-screen">
        <!-- Sidebar -->
        <nav class="w-64 bg-blue-900 text-white flex-shrink-0 flex flex-col justify-between">
            <div>
                <div class="h-16 flex items-center justify-between px-4 border-b shadow-md bg-blue-800">
                    <a href="{{ route('admin.dashboard') }}" class="text-2xl font-bold flex items-center space-x-2">
                        <i class="fas fa-user-shield text-3xl"></i>
                        <span>Admin Panel</span>
                    </a>
                </div>
                <div class="p-4 space-y-4 overflow-y-auto">
                    <!-- Sidebar Menu -->
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-blue-800 transition {{ request()->routeIs('admin.dashboard') ? 'bg-blue-800' : '' }}">
                        <i class="fas fa-home"></i><span>Dashboard</span>
                    </a>

                    <!-- Dropdown lainnya -->
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



                      <div class="py-5">
                        <button onclick="toggleMenu('laporan')" class="flex items-center space-x-3 p-3 w-full rounded-lg bg-blue-800">
                            <i class="fas fa-users"></i>
                            <span>Laporan</span>
                            <i class="fas fa-chevron-down ml-auto"></i>
                        </button>
                        <div id="laporan" class="hidden bg-blue-900 rounded-lg ml-6">
                            <a href="{{ route('admin.rekap.index') }}" class="block px-4 py-2 text-sm">Laporan Bulanan</a>
                            <a href="{{ route('admin.rekap.harian') }}" class="block px-4 py-2 text-sm">Laporan Harian</a>
                        </div>
                    </div>
                    </div>
                    {{-- Tambahkan menu lainnya di sini --}}
                </div>
            </div>

            <div class="border-t mt-4 py-4 bg-blue-800 px-4">
                <p class="font-medium">{{ Auth::user()->name }}</p>
                <p class="text-sm">Role: Admin</p>
                <a href="{{ route('logout') }}" class="mt-3 flex items-center space-x-3 p-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
                    <i class="fas fa-sign-out-alt"></i><span>Logout</span>
                </a>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Optional Mobile Header -->
            @isset($header)
                <header class="bg-white shadow p-4 w-full">
                    <div class="w-full">{{ $header }}</div>
                </header>
            @endisset

            <!-- Scrollable content area -->
            <main class="flex-1 overflow-y-auto bg-gray-100 p-4">
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        function toggleMenu(menuId) {
            document.getElementById(menuId).classList.toggle("hidden");
        }
    </script>
</body>
</html>
