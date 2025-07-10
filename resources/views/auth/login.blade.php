<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>{{ config('app.name', 'Laravel') }}</title>

  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="/logo.png">

  <!-- Font Awesome -->
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

  <!-- Vite -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="flex items-center justify-center min-h-screen bg-teal-800">
  <!-- Komponen Alert -->
  @include('components.alert')

  <div class="bg-white p-8 rounded-xl shadow-xl max-w-md w-full">
    <h1 class="text-3xl font-bold text-center text-teal-800 mb-4">Selamat Datang</h1>
    <p class="text-center text-gray-600 mb-6">Masuk untuk melanjutkan ke sistem Yayasan El-Jufa</p>

    <form action="{{ route('login.action') }}" method="POST" class="space-y-4">
      @csrf
      <div>
        <label for="email" class="block text-sm font-medium text-gray-700">Alamat Email</label>
        <input id="email" name="email" type="email" placeholder="Masukkan email Anda"
          class="w-full px-4 py-2 mt-1 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-600"
          required>
      </div>

      <div>
        <label for="password" class="block text-sm font-medium text-gray-700">Kata Sandi</label>
        <input id="password" name="password" type="password" placeholder="Masukkan kata sandi Anda"
          class="w-full px-4 py-2 mt-1 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-600"
          required>
      </div>

      <div class="flex items-center justify-between text-sm">
        <label class="flex items-center">
          <input type="checkbox" name="remember" class="h-4 w-4 text-teal-700 border-gray-300 rounded focus:ring-teal-600">
          <span class="ml-2 text-gray-700">Ingat saya</span>
        </label>
        <a href="#" class="text-teal-700 hover:text-yellow-500">Lupa Kata Sandi?</a>
      </div>

      <button type="submit"
        class="w-full py-3 bg-teal-700 text-white font-semibold rounded-md hover:bg-teal-900 transition duration-200 shadow">
        Masuk
      </button>
    </form>

    <p class="text-center text-sm text-gray-600 mt-6">
      Belum punya akun?
      <a href="{{ route('register') }}" class="text-teal-700 hover:text-yellow-500 font-medium">Daftar</a>
    </p>

    <div class="w-full flex items-center my-6">
      <div class="flex-1 border-b border-gray-300"></div>
      <span class="mx-3 text-sm text-gray-400">atau</span>
      <div class="flex-1 border-b border-gray-300"></div>
    </div>

    <!-- Tempat tombol login sosial jika ingin ditambahkan -->
    <div class="flex justify-center gap-4">
      <!-- Contoh tombol sosial (nonaktif jika tidak dipakai) -->
      <!-- <button class="p-3 rounded-full bg-blue-600 text-white"><i class="fab fa-facebook-f"></i></button>
      <button class="p-3 rounded-full bg-red-600 text-white"><i class="fab fa-google"></i></button> -->
    </div>
  </div>
</body>

</html>
