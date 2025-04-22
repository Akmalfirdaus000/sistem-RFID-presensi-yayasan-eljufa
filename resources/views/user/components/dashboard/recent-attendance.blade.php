<div class="bg-gradient-to-br from-purple-50 to-blue-50 rounded-lg shadow-md p-4 md:p-6 flex flex-col md:flex-row mt-6">
    <!-- Tabel Presensi -->
    <div class="overflow-x-auto w-full md:w-3/4">
        <table class="min-w-full table-auto">
            <thead>
                <tr class="bg-gradient-to-r from-indigo-500 to-blue-500 text-white">
                    <th class="px-4 md:px-6 py-3 text-left text-sm font-medium">Tanggal</th>
                    <th class="px-4 md:px-6 py-3 text-left text-sm font-medium">Status</th>
                    <th class="px-4 md:px-6 py-3 text-left text-sm font-medium">Jam Masuk</th>
                    <th class="px-4 md:px-6 py-3 text-left text-sm font-medium">Jam Keluar</th>
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
                <tr class="border-t bg-white hover:bg-blue-50 transition">
                    <td class="px-4 md:px-6 py-4 text-sm text-gray-900">
                        {{ Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}
                    </td>
                    <td class="px-4 md:px-6 py-4 text-sm font-bold
                        @if($item->status == 'Hadir') text-green-700 
                        @elseif($item->status == 'Absen') text-red-700 
                        @elseif($item->status == 'Cuti') text-yellow-700 
                        @endif">
                        {{ $item->status }}
                    </td>
                    <td class="px-4 md:px-6 py-4 text-sm text-gray-900">{{ $item->jam_masuk ?? '-' }}</td>
                    <td class="px-4 md:px-6 py-4 text-sm text-gray-900">{{ $item->jam_keluar ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-4 text-gray-600 bg-white">Belum ada data presensi</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Statistik Kehadiran -->
    <div class="w-full md:w-1/4 flex flex-col space-y-4 order-first md:order-last mt-6 md:mt-0 md:ml-6">
        <div class="p-6 bg-green-500 text-white rounded-lg shadow-md flex flex-col items-center">
            <h4 class="text-sm font-bold">Hadir</h4>
            <p class="text-2xl font-semibold">{{ $hadirCount }} Hari</p>
        </div>

        <div class="p-6 bg-red-500 text-white rounded-lg shadow-md flex flex-col items-center">
            <h4 class="text-sm font-bold">Absen</h4>
            <p class="text-2xl font-semibold">{{ $absenCount }} Hari</p>
        </div>

        <div class="p-6 bg-yellow-500 text-white rounded-lg shadow-md flex flex-col items-center">
            <h4 class="text-sm font-bold">Cuti</h4>
            <p class="text-2xl font-semibold">{{ $cutiCount }} Hari</p>
        </div>
    </div>
</div>
