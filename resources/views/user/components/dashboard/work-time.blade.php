<div class="bg-white p-6 rounded-lg shadow-xl flex flex-col md:flex-row items-center justify-between space-y-6 md:space-y-0 md:space-x-8">
    <!-- Foto User -->
    <div class="order-first md:order-none text-center md:text-left">
        <img src="{{ Auth::user()->photo_url ?? 'https://via.placeholder.com/100' }}" alt="Foto Profil"
            class="w-24 h-24 rounded-full border-4 border-teal-500 shadow-lg mx-auto md:mx-0">
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

            $company = Company::first();
            $workTime = $company ? $company->work_time : '08:00-17:00';
            $workTimeParts = explode('-', $workTime);

            $jamKerjaMasuk = isset($workTimeParts[0]) ? trim($workTimeParts[0]) : '-';
            $jamKerjaKeluar = isset($workTimeParts[1]) ? trim($workTimeParts[1]) : '-';

            $userId = Auth::id();
            $attendance = Attendance::where('id_user', $userId)
                ->whereDate('tanggal', Carbon::today()->toDateString())
                ->first();

            $jamMasuk = $attendance && $attendance->jam_masuk ? $attendance->jam_masuk : '-';
            $jamKeluar = $attendance && $attendance->jam_keluar ? $attendance->jam_keluar : '-';
            $status = $attendance ? ucfirst($attendance->status) : 'Belum Absen';

            // Logika keterlambatan
            $isTerlambat = false;
            $durasiTerlambat = null;
            if ($jamMasuk !== '-' && $jamKerjaMasuk !== '-') {
                try {
                    $jamMasukTime = Carbon::parse($jamMasuk);
                    $jamKerjaTime = Carbon::createFromFormat('H:i', $jamKerjaMasuk);
                    if ($jamMasukTime->gt($jamKerjaTime)) {
                        $isTerlambat = true;
                        $diff = $jamMasukTime->diff($jamKerjaTime);
                        $durasiTerlambat = ($diff->h ? $diff->h . ' jam ' : '') . ($diff->i ? $diff->i . ' menit' : '');
                    }
                } catch (\Exception $e) {
                    $isTerlambat = false;
                }
            }
        @endphp

        <!-- Jam Kerja -->
        <div class="p-5 bg-yellow-400 text-teal-900 rounded-lg shadow-lg flex flex-col items-center justify-center hover:scale-105 transition-transform duration-200">
            <h4 class="text-sm font-semibold">Jam Kerja</h4>
            <p class="md:text-lg text-center font-bold">{{ $jamKerjaMasuk }} - {{ $jamKerjaKeluar }}</p>
        </div>

        <!-- Jam Masuk -->
        <div class="p-6 bg-teal-700 text-white rounded-lg shadow-lg flex flex-col items-center justify-center hover:scale-105 transition-transform duration-200">
            <h4 class="text-sm font-semibold">Jam Masuk</h4>
            <p class="text-lg font-bold">
                {{ $jamMasuk !== '-' ? \Carbon\Carbon::parse($jamMasuk)->format('H:i') : '-' }}
            </p>
            @if ($isTerlambat && $durasiTerlambat)
                <p class="mt-1 text-xs bg-red-600 text-white px-2 py-1 rounded">
                    Terlambat {{ $durasiTerlambat }}
                </p>
            @endif
        </div>

        <!-- Jam Keluar -->
        <!-- Jam Keluar -->
<div class="p-6 bg-teal-600 text-white rounded-lg shadow-lg flex flex-col items-center justify-center hover:scale-105 transition-transform duration-200">
    <h4 class="text-sm font-semibold">Jam Keluar</h4>
    <p class="text-lg font-bold">
        {{ $jamKeluar !== '-' ? \Carbon\Carbon::parse($jamKeluar)->format('H:i') : '-' }}
    </p>

    @php
        $catatanKeluar = '';
        $durasiTambahan = null;

        if ($jamKeluar !== '-' && $jamKerjaKeluar !== '-') {
            try {
                $jamKeluarTime = Carbon::parse($jamKeluar);
                $jamKerjaAkhirTime = Carbon::createFromFormat('H:i', $jamKerjaKeluar);

                if ($jamKeluarTime->lt($jamKerjaAkhirTime)) {
                    // Pulang cepat
                    $selisih = $jamKerjaAkhirTime->diff($jamKeluarTime);
                    $durasiTambahan = ($selisih->h ? $selisih->h . ' jam ' : '') . ($selisih->i ? $selisih->i . ' menit lebih cepat' : '');
                    $catatanKeluar = 'Pulang Cepat ' . $durasiTambahan;
                } elseif ($jamKeluarTime->gt($jamKerjaAkhirTime)) {
                    // Lembur
                    $selisih = $jamKeluarTime->diff($jamKerjaAkhirTime);
                    $durasiTambahan = ($selisih->h ? $selisih->h . ' jam ' : '') . ($selisih->i ? $selisih->i . ' menit' : '');
                    $catatanKeluar = 'Lembur ' . $durasiTambahan;
                }
            } catch (\Exception $e) {
                $catatanKeluar = '';
            }
        }
    @endphp

    @if ($catatanKeluar)
        <p class="mt-1 text-xs {{ Str::startsWith($catatanKeluar, 'Lembur') ? 'bg-blue-700' : 'bg-red-600' }} text-white px-2 py-1 rounded">
            {{ $catatanKeluar }}
        </p>
    @endif
</div>


        <!-- Status Kehadiran -->
        <div class="p-5 bg-emerald-600 text-white rounded-lg shadow-lg flex flex-col items-center justify-center hover:scale-105 transition-transform duration-200">
            <h4 class="text-sm text-center font-semibold">Status Kehadiran</h4>
            <p class="text-lg font-bold">{{ $status }}</p>
        </div>
    </div>
</div>
