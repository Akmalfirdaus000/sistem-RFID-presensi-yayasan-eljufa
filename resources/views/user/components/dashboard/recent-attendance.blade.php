<div class="bg-gradient-to-br from-teal-50 to-white rounded-lg shadow-md p-4 md:p-6 flex flex-col md:flex-row mt-6">
    <!-- Tabel Presensi -->
    <div class="overflow-x-auto w-full md:w-3/4">
        <table class="min-w-full table-auto">
            <thead>
                <tr class="bg-gradient-to-r from-teal-700 to-teal-600 text-white">
                    <th class="px-4 md:px-6 py-3 text-left text-sm font-semibold">Tanggal</th>
                    <th class="px-4 md:px-6 py-3 text-left text-sm font-semibold">Status</th>
                    <th class="px-4 md:px-6 py-3 text-left text-sm font-semibold">Jam Masuk</th>
                    <th class="px-4 md:px-6 py-3 text-left text-sm font-semibold">Jam Keluar</th>
                </tr>
            </thead>
            <tbody>
                @php
                    use Carbon\Carbon;
                    use App\Models\Attendance;
                    use Illuminate\Support\Facades\Auth;

                    $attendances = Attendance::where('id_user', Auth::id())
                        ->orderBy('tanggal', 'desc')
                        ->take(6)
                        ->get();

                    $hadirCount = Attendance::where('id_user', Auth::id())->where('status', 'Hadir')->count();
                    $absenCount = Attendance::where('id_user', Auth::id())->where('status', 'Absen')->count();
                    $cutiCount = Attendance::where('id_user', Auth::id())->where('status', 'Cuti')->count();
                @endphp

                @forelse ($attendances as $item)
                    <tr class="border-t bg-white hover:bg-teal-50 transition">
                        <td class="px-4 md:px-6 py-4 text-sm text-gray-800">
                            {{ Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}
                        </td>
                        <td class="px-4 md:px-6 py-4 text-sm font-bold
                            @if($item->status == 'Hadir') text-green-700
                            @elseif($item->status == 'Absen') text-red-600
                            @elseif($item->status == 'Cuti') text-yellow-600
                            @endif">
                            {{ $item->status }}
                        </td>
                        <td class="px-4 md:px-6 py-4 text-sm text-gray-800">{{ $item->jam_masuk ?? '-' }}</td>
                        <td class="px-4 md:px-6 py-4 text-sm text-gray-800">{{ $item->jam_keluar ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-4 text-gray-500 bg-white">Belum ada data presensi</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Statistik Kehadiran -->
    <div class="w-full md:w-1/4 flex flex-col space-y-4 order-first md:order-last mt-6 md:mt-0 md:ml-6">
        <div class="p-5 bg-emerald-600 text-white rounded-lg shadow-md flex flex-col items-center">
            <i class="fas fa-user-check text-2xl mb-2"></i>
            <h4 class="text-sm font-bold">Hadir</h4>
            <p class="text-2xl font-semibold">{{ $hadirCount }} Hari</p>
        </div>

        <div class="p-5 bg-rose-600 text-white rounded-lg shadow-md flex flex-col items-center">
            <i class="fas fa-user-times text-2xl mb-2"></i>
            <h4 class="text-sm font-bold">Absen</h4>
            <p class="text-2xl font-semibold">{{ $absenCount }} Hari</p>
        </div>

        <div class="p-5 bg-yellow-500 text-teal-900 rounded-lg shadow-md flex flex-col items-center">
            <i class="fas fa-plane-departure text-2xl mb-2"></i>
            <h4 class="text-sm font-bold">Cuti</h4>
            <p class="text-2xl font-semibold">{{ $cutiCount }} Hari</p>
        </div>
    </div>
</div>
