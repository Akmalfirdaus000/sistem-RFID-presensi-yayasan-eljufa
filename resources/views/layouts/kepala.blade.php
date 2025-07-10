<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ketua Yayasan | @yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Tambahkan ini di <head> -->
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-3Q8gmZlwKak+jR9fJ8OgIWxLbpqtVgS4w9yt8AA+jkUgKfKT7CUPD6A+KeWIsZt3FjKZWBCHaUQ+9x8fHZl1yA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
</head>
<body class="bg-gray-100 flex">

    <!-- Sidebar -->
    <aside class="w-64 h-screen bg-green-700 text-white flex flex-col shadow-lg">
        <div class="text-2xl font-bold text-center py-6 border-b border-green-600">
            <i class="fas fa-school mr-2"></i> Ketua Yayasan
        </div>

        <nav class="flex-1 p-4 space-y-2">
            <a href="{{ route('kepala.dashboard') }}" class="flex items-center space-x-3 p-3 rounded hover:bg-green-800 transition">
                <i class="fas fa-home w-5"></i>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('kepala.pengguna.index') }}" class="flex items-center space-x-3 p-3 rounded hover:bg-green-800 transition">
                <i class="fas fa-users w-5"></i>
                <span>List Pengguna</span>
            </a>

            <!-- Dropdown Laporan -->
            <div x-data="{ open: false }" class="space-y-1">
                <button @click="open = !open" class="w-full flex items-center justify-between p-3 rounded hover:bg-green-800 transition focus:outline-none">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-chart-line w-5"></i>
                        <span>Laporan</span>
                    </div>
                    <i class="fas fa-chevron-down text-sm" :class="{ 'rotate-180': open }"></i>
                </button>
                <div x-show="open" class="pl-10 mt-1 space-y-1" x-cloak>
                    <a href="{{ route('kepala.laporan.harian') }}" class="block p-2 rounded hover:bg-green-800 transition">Laporan Harian</a>
                    <a href="{{ route('kepala.laporan.bulanan') }}" class="block p-2 rounded hover:bg-green-800 transition">Laporan Bulanan</a>
                </div>
            </div>
        </nav>

        <div class="p-4 border-t border-green-600 mt-auto">
            <div class="text-sm mb-2">
                <i class="fas fa-user mr-2"></i> {{ Auth::user()->name }}
            </div>
            <a href="{{ route('logout') }}" class="block bg-red-600 hover:bg-red-700 text-white text-center py-2 rounded">
                <i class="fas fa-sign-out-alt mr-2"></i> Logout
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-6 overflow-y-auto">
        @yield('content')
    </main>

    <!-- AlpineJS for Dropdown -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</body>
</html>
