<div class="bg-gradient-to-br from-teal-50 to-white rounded-2xl shadow-lg p-6 mt-6 flex justify-center">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        <!-- Presensi -->
        <a href="{{ route('presensi.index') }}" class="w-24 h-24 flex flex-col items-center justify-center bg-teal-700 text-white rounded-full shadow-md hover:bg-teal-800 transition transform hover:scale-105 duration-300">
            <i class="fas fa-fingerprint text-3xl mb-1"></i>
            <span class="text-xs md:text-sm font-semibold">Presensi</span>
        </a>

        <!-- Riwayat -->
        <a href="{{ route('riwayat.index') }}" class="w-24 h-24 flex flex-col items-center justify-center bg-emerald-600 text-white rounded-full shadow-md hover:bg-emerald-700 transition transform hover:scale-105 duration-300">
            <i class="fas fa-clock-rotate-left text-3xl mb-1"></i>
            <span class="text-xs md:text-sm font-semibold">Riwayat</span>
        </a>

        <!-- Profil -->
        <a href="{{ route('profile') }}" class="w-24 h-24 flex flex-col items-center justify-center bg-yellow-500 text-white rounded-full shadow-md hover:bg-yellow-600 transition transform hover:scale-105 duration-300">
            <i class="fas fa-id-badge text-3xl mb-1"></i>
            <span class="text-xs md:text-sm font-semibold">Profil</span>
        </a>

        <!-- Pengaturan -->
        <a href="#" class="w-24 h-24 flex flex-col items-center justify-center bg-rose-600 text-white rounded-full shadow-md hover:bg-rose-700 transition transform hover:scale-105 duration-300">
            <i class="fas fa-gear text-3xl mb-1"></i>
            <span class="text-xs md:text-sm font-semibold">Pengaturan</span>
        </a>
    </div>
</div>
