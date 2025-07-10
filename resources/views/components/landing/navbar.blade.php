<!-- Font Awesome CDN -->
<link
  rel="stylesheet"
  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
/>

<header class="shadow border-b">
  <!-- Top Bar -->
  <div class="bg-teal-800 text-white text-sm py-2 px-4 flex justify-between items-center">
    <div class="flex gap-5">
      <a href="#" class="hover:underline">Testimonials</a>
      <a href="#" class="hover:underline">Events</a>
      <a href="#" class="hover:underline">Ekstrakurikuler</a>
      <a href="#" class="hover:underline">Berita</a>
    </div>
    <div class="flex gap-3 text-lg">
      <a href="#"><i class="fab fa-facebook-f hover:text-yellow-400"></i></a>
      <a href="#"><i class="fab fa-x-twitter hover:text-yellow-400"></i></a>
      <a href="#"><i class="fab fa-linkedin-in hover:text-yellow-400"></i></a>
      <a href="#"><i class="fab fa-youtube hover:text-yellow-400"></i></a>
      <a href="#"><i class="fab fa-instagram hover:text-yellow-400"></i></a>
    </div>
  </div>

  <!-- Info & Logo Bar -->
  <div class="bg-white px-4 md:px-6 py-4 flex flex-col md:flex-row items-center justify-between gap-4">
    <!-- Logo + Nama -->
    <div class="flex items-center gap-3">
      <img src="/logo.png" alt="Logo" class="w-14 h-14 object-contain" />
      <h1 class="text-xl font-bold text-teal-900">Yayasan El-Jufa</h1>
    </div>

    <!-- Kontak -->
    <div class="flex gap-8 items-center text-gray-600 text-sm">
      <div class="flex items-center gap-2">
        <i class="fas fa-square-phone text-lg text-teal-800"></i>
        <div>
          <p class="text-xs uppercase text-gray-400">Phone Number</p>
          <p class="font-semibold text-base">(021) 1234567</p>
        </div>
      </div>
      <div class="flex items-center gap-2">
        <i class="fas fa-envelope text-lg text-teal-800"></i>
        <div>
          <p class="text-xs uppercase text-gray-400">E-Mail</p>
          <p class="font-semibold text-base">info@eljufa.or.id</p>
        </div>
      </div>
    </div>

    <!-- CTA -->
    <a
      href="/login"
      class="bg-teal-800 text-white font-semibold px-6 py-3 rounded hover:bg-teal-900 transition shadow"
    >
      Masuk
    </a>
  </div>

  <!-- Main Menu -->
  <nav class="bg-white border-t">
    <div class="max-w-7xl mx-auto px-4">
      <div class="flex justify-between items-center h-16">
        <!-- Navigation Links -->
        <div class="hidden md:flex items-center space-x-6 text-sm font-medium">
          <a href="#home" class="text-black hover:text-teal-800 flex items-center gap-2 transition">
            <i class="fas fa-house text-teal-800 w-5 h-5"></i><span>Beranda</span>
          </a>
          <a href="#about" class="text-black hover:text-teal-800 flex items-center gap-2 transition">
            <i class="fas fa-landmark text-teal-800 w-5 h-5"></i><span>Yayasan</span>
          </a>
          <a href="#team" class="text-black hover:text-teal-800 flex items-center gap-2 transition">
            <i class="fas fa-chalkboard-teacher text-teal-800 w-5 h-5"></i><span>Guru</span>
          </a>
          <a href="#services" class="text-black hover:text-teal-800 flex items-center gap-2 transition">
            <i class="fas fa-photo-film text-teal-800 w-5 h-5"></i><span>Foto</span>
          </a>
          <a href="#location" class="text-black hover:text-teal-800 flex items-center gap-2 transition">
            <i class="fas fa-map-location-dot text-teal-800 w-5 h-5"></i><span>Lokasi</span>
          </a>
          
        </div>

        <!-- Mobile menu toggle -->
        <button
          id="nav-toggle"
          class="md:hidden text-2xl text-gray-600 hover:text-teal-700"
        >
          <i class="fas fa-bars"></i>
        </button>
      </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="md:hidden hidden px-4 pb-4 space-y-3 text-sm font-medium">
      <a href="#home" class="block text-black hover:text-teal-800 flex items-center gap-2">
        <i class="fas fa-house text-teal-800 w-5 h-5"></i><span>Beranda</span>
      </a>
      <a href="#about" class="block text-black hover:text-teal-800 flex items-center gap-2">
        <i class="fas fa-landmark text-teal-800 w-5 h-5"></i><span>Yayasan</span>
      </a>
      <a href="#team" class="block text-black hover:text-teal-800 flex items-center gap-2">
        <i class="fas fa-chalkboard-teacher text-teal-800 w-5 h-5"></i><span>Guru</span>
      </a>
      <a href="#services" class="block text-black hover:text-teal-800 flex items-center gap-2">
        <i class="fas fa-photo-film text-teal-800 w-5 h-5"></i><span>Foto</span>
      </a>
      <a href="#location" class="block text-black hover:text-teal-800 flex items-center gap-2">
        <i class="fas fa-map-location-dot text-teal-800 w-5 h-5"></i><span>Lokasi</span>
      </a>
      <a href="/login" class="block text-black hover:text-teal-800 flex items-center gap-2">
        <i class="fas fa-right-to-bracket text-teal-800 w-5 h-5"></i><span>Masuk</span>
      </a>
    </div>
  </nav>
</header>

<!-- Script for toggling mobile menu -->
<script>
  document.getElementById("nav-toggle").addEventListener("click", () => {
    const menu = document.getElementById("mobile-menu");
    menu.classList.toggle("hidden");
  });
</script>
