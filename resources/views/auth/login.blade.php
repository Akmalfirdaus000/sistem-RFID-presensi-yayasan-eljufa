<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/logo.png">

    <!-- Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="flex items-center justify-center min-h-screen bg-gradient-to-r from-red-600 via-yellow-500 to-black">
    
    <!-- Komponen Alert -->
    @include('components.alert')

    <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full">
        <h1 class="text-4xl font-bold text-center text-red-600 mb-6">Selamat Datang!</h1>
        <p class="text-center text-gray-600 mb-8">Silakan masuk ke akun Anda</p>

        <form action="{{ route('login.action') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Alamat Email</label>
                <input id="email" name="email" type="email" placeholder="Masukkan email Anda"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600"
                    required>
            </div>

            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-700">Kata Sandi</label>
                <input id="password" name="password" type="password" placeholder="Masukkan kata sandi Anda"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600"
                    required>
            </div>

            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center">
                    <input id="remember_me" name="remember" type="checkbox"
                        class="h-4 w-4 text-red-600 focus:ring-red-600 border-gray-300 rounded">
                    <label for="remember_me" class="ml-2 block text-sm text-gray-800">Ingat saya</label>
                </div>
                <a href="#" class="text-sm text-red-600 hover:text-red-800">Lupa Kata Sandi?</a>
            </div>

            <button type="submit"
                class="w-full py-3 bg-red-600 text-white font-bold rounded-lg shadow-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-600 focus:ring-offset-2 transition duration-150 ease-in-out">
                Masuk
            </button>
        </form>

        <p class="text-center text-gray-600 mt-6">Belum punya akun? 
            <a href="{{ route('register') }}" class="text-red-600 hover:text-red-800 font-medium">Daftar</a>
        </p>

        <div class="w-full flex justify-center items-center mt-3">
            <div class="flex-1 border-b border-gray-500"></div>
            <div class="mx-2 text-gray-600">atau</div>
            <div class="flex-1 border-b border-gray-500"></div>
        </div>

        <!-- Social Login -->
       
    </div>
</body>

</html>
