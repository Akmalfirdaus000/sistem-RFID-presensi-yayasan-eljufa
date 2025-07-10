<!-- Hero Section with Background Slider -->
<section class="relative h-[90vh] text-white overflow-hidden">
    <!-- Swiper Container -->
    <div class="absolute inset-0 z-0">
        <div class="swiper mySwiper ">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <img src="/hero1.jpg" class=" w-full h-full" alt="Slide 1" />
                </div>

            </div>
        </div>
        <!-- Dark overlay -->
        <div class="absolute inset-0 bg-black bg-opacity-60 z-10"></div>
    </div>

    <!-- Content -->
    <div class="relative z-20 flex flex-col items-center justify-center h-full text-center px-6 animate-fade-in">
        <h1 class="text-4xl md:text-6xl font-extrabold leading-tight mb-6 tracking-tight">
            Selamat Datang di <span class="text-yellow-400">Yayasan El-Jufa</span>
        </h1>
        <p class="text-lg md:text-xl text-white/90 mb-8 max-w-2xl leading-relaxed">
            Mewujudkan generasi unggul melalui pendidikan berkualitas yang berlandaskan nilai-nilai luhur dan karakter.
        </p>
        <div class="flex flex-wrap justify-center gap-4">
            <a href="#laporkan"
                class="bg-yellow-400 text-green-900 font-semibold px-6 py-3 rounded-xl shadow-lg hover:bg-yellow-300 transition-all duration-300 hover:scale-105">
                Pendaftaran Siswa Baru
            </a>
            <a href="#learn-more"
                class="border border-white font-medium px-6 py-3 rounded-xl hover:bg-white hover:text-green-800 transition-all duration-300 hover:scale-105">
                Masuk Sebagai Guru
            </a>
        </div>
    </div>
</section>
