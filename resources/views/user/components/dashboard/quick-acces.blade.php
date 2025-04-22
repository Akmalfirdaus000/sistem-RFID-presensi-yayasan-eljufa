<div class="bg-gradient-to-br flex justify-center from-gray-50 to-gray-100 rounded-2xl shadow-lg p-4 mt-4">
    {{-- <h3 class="text-lg font-bold text-gray-900 mb-4 text-center">Quick Access</h3> --}}
    <div class="grid grid-cols-4 md:grid-cols-4 gap-4 ">
        <!-- Presensi -->
        <a href="{{ route('presensi.index') }}" class="w-20 h-20 md:w-24 md:h-24 flex flex-col items-center justify-center bg-blue-500 text-white rounded-full shadow-lg hover:bg-blue-600 transition duration-300 transform hover:scale-105">
            <i class="fas fa-calendar-check text-white text-2xl md:text-3xl"></i>
            <span class="text-xs md:text-sm font-semibold mt-1">Presensi</span>
        </a>

        <!-- Laporan -->
        <a href="{{ route('riwayat.index') }}" class="w-20 h-20 md:w-24 md:h-24 flex flex-col items-center justify-center bg-green-500 text-white rounded-full shadow-lg hover:bg-green-600 transition duration-300 transform hover:scale-105">
            <i class="fas fa-file-alt text-white text-2xl md:text-3xl"></i>
            <span class="text-xs md:text-sm font-semibold mt-1">Riwayat</span>
        </a>

        <!-- Profil -->
        <a href="{{ route('profile') }}" class="w-20 h-20 md:w-24 md:h-24 flex flex-col items-center justify-center bg-yellow-500 text-white rounded-full shadow-lg hover:bg-yellow-600 transition duration-300 transform hover:scale-105">
            <i class="fas fa-user text-white text-2xl md:text-3xl"></i>
            <span class="text-xs md:text-sm font-semibold mt-1">Profil</span>
        </a>

        <!-- Pengaturan -->
        <a href="#" class="w-20 h-20 md:w-24 md:h-24 flex flex-col items-center justify-center bg-red-500 text-white rounded-full shadow-lg hover:bg-red-600 transition duration-300 transform hover:scale-105">
            <i class="fas fa-cog text-white text-2xl md:text-3xl"></i>
            <span class="text-xs md:text-sm font-semibold mt-1">Pengaturan</span>
        </a>
    </div>
</div>
