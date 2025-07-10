<div class="bg-gradient-to-br from-white to-gray-50 p-6 rounded-xl shadow-2xl border border-gray-200">
    <h2 class="text-2xl font-bold text-teal-800 mb-6">Riwayat Presensi</h2>

    @if($riwayatPresensi->isEmpty())
        <p class="text-gray-600 text-center italic">Belum ada riwayat presensi.</p>
    @else
        <form method="GET" action="{{ route('riwayat.index') }}" class="mb-6 flex flex-col md:flex-row gap-3 items-start md:items-center">
            <input type="date" id="search_date" name="search_date"
                class="border border-gray-300 p-2 rounded-md shadow-sm w-full md:w-1/3"
                value="{{ request('search_date', date('Y-m-d')) }}">
            <button type="submit"
                class="bg-teal-600 text-white px-5 py-2 rounded-md shadow hover:bg-teal-700 transition">
                Cari
            </button>
        </form>

        <div class="overflow-x-auto rounded-lg shadow">
            <table class="min-w-full text-sm text-gray-800">
                <thead>
                    <tr class="bg-teal-600 text-white text-left">
                        <th class="px-4 py-3">No</th>
                        <th class="px-4 py-3">Tanggal</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Jam Masuk</th>
                        <th class="px-4 py-3">Jam Keluar</th>
                        <th class="px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($riwayatPresensi as $index => $attendance)
                        <tr class="even:bg-white odd:bg-gray-50 hover:bg-teal-50 transition">
                            <td class="px-4 py-3 border">{{ $loop->iteration }}</td>
                            <td class="px-4 py-3 border">{{ $attendance->tanggal }}</td>
                            <td class="px-4 py-3 border capitalize font-semibold
                                @if($attendance->status === 'Hadir') text-green-600
                                @elseif($attendance->status === 'Absen') text-red-600
                                @elseif($attendance->status === 'Cuti') text-yellow-600
                                @endif">
                                {{ $attendance->status }}
                            </td>
                            <td class="px-4 py-3 border text-center">{{ $attendance->jam_masuk ?? '-' }}</td>
                            <td class="px-4 py-3 border text-center">{{ $attendance->jam_keluar ?? '-' }}</td>
                            <td class="px-4 py-3 border text-center">
                                <button onclick="openDetailModal({{ json_encode($attendance) }})"
                                    class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 transition text-xs shadow">
                                    Detail
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="flex justify-center mt-6">
            {{ $riwayatPresensi->links('pagination::tailwind') }}
        </div>
    @endif
</div>
