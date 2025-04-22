<div class="bg-white p-6 rounded-lg shadow-xl flex flex-col md:flex-row items-center justify-between space-y-6 md:space-y-0 md:space-x-8">
    <!-- Foto User -->
    <div class="order-first md:order-none text-center md:text-left">
        <img src="{{ Auth::user()->photo_url ?? 'https://via.placeholder.com/100' }}" alt="Foto Profil"
            class="w-24 h-24 rounded-full border-4 border-gray-300 shadow-lg mx-auto md:mx-0">
        <div class="pt-3">
            <p class="font-semibold text-center text-gray-900 text-lg">{{ Auth::user()->name }}</p>
            <p class="text-sm text-center text-gray-700">{{ Auth::user()->jabatan ?? 'Tidak Diketahui' }}</p>
        </div>
    </div>

    <!-- Informasi Pengguna -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 w-full">
        @php
            use Carbon\Carbon;
            use App\Models\Company;
            use App\Models\Attendance;
            use Illuminate\Support\Facades\Auth;

            // Ambil data perusahaan
            $company = Company::first();
            $workTime = $company ? $company->work_time : '08:00-17:00';

            // Ambil data absensi user untuk hari ini
            $userId = Auth::id();
            $attendance = Attendance::where('id_user', $userId)
                ->whereDate('tanggal', Carbon::today()->toDateString())
                ->first();

            // Pisahkan jam kerja menjadi jam masuk & keluar
            $workTimeParts = explode('-', $workTime);
            $jamKerjaMasuk = $workTimeParts[0] ?? '-';
            $jamKerjaKeluar = $workTimeParts[1] ?? '-';

            // Jam masuk dan keluar berdasarkan absensi
            $jamMasuk = $attendance && $attendance->jam_masuk ? $attendance->jam_masuk : '-';
            $jamKeluar = $attendance && $attendance->jam_keluar ? $attendance->jam_keluar : '-';

            // Tentukan status kehadiran
            $status = $attendance ? ucfirst($attendance->status) : 'Belum Absen';
        @endphp

        <!-- Jam Kerja -->
        <div class="p-5 bg-yellow-500 text-white rounded-lg shadow-lg flex flex-col items-center justify-center hover:scale-105 transition-transform duration-200">
            <h4 class="text-sm font-semibold">Jam Kerja</h4>
            <p class="md:text-lg text-center font-bold">{{ $jamKerjaMasuk }} - {{ $jamKerjaKeluar }}</p>
        </div>

        <!-- Jam Masuk -->
        <div class="p-6 bg-blue-700 text-white rounded-lg shadow-lg flex flex-col items-center justify-center hover:scale-105 transition-transform duration-200">
            <h4 class="text-sm font-semibold">Jam Masuk</h4>
            <p class="text-lg font-bold">{{ $jamMasuk }}</p>
        </div>

        <!-- Jam Keluar -->
        <div class="p-6 bg-purple-700 text-white rounded-lg shadow-lg flex flex-col items-center justify-center hover:scale-105 transition-transform duration-200">
            <h4 class="text-sm font-semibold">Jam Keluar</h4>
            <p class="text-lg font-bold">{{ $jamKeluar }}</p>
        </div>

        <!-- Status Kehadiran -->
        <div class="p-5 bg-green-700 text-white rounded-lg shadow-lg flex flex-col items-center justify-center hover:scale-105 transition-transform duration-200">
            <h4 class="text-sm text-center font-semibold">Status Kehadiran</h4>
            <p class="text-lg font-bold">{{ $status }}</p>
        </div>
    </div>
</div>
