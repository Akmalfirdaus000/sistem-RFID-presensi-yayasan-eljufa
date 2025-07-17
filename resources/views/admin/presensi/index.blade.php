@extends('layouts.sidemin')

@section('content')
<div class="p-4">
    <div class="bg-gray-100 shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-4 text-gray-900">Daftar Presensi</h2>

        <form method="GET" action="{{ route('admin.presensi.index') }}" class="mb-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="search_name" class="block text-gray-700 font-bold mb-2">Nama Karyawan:</label>
                    <input type="text" name="search_name" id="search_name" class="w-full border border-gray-300 rounded px-3 py-2" value="{{ request('search_name') }}">
                </div>
                <div>
                    <label for="start_date" class="block text-gray-700 font-bold mb-2">Tanggal Mulai:</label>
                    <input type="date" name="start_date" id="start_date" class="w-full border border-gray-300 rounded px-3 py-2" value="{{ request('start_date') }}">
                </div>
                <div>
                    <label for="end_date" class="block text-gray-700 font-bold mb-2">Tanggal Selesai:</label>
                    <input type="date" name="end_date" id="end_date" class="w-full border border-gray-300 rounded px-3 py-2" value="{{ request('end_date') }}">
                </div>
            </div>
            <div>
    <label for="filter_waktu" class="block text-gray-700 font-bold mb-2">Filter Waktu:</label>
    <select name="filter_waktu" id="filter_waktu" class="w-full border border-gray-300 rounded px-3 py-2">
        <option value="">-- Semua --</option>
        <option value="terlambat" {{ request('filter_waktu') == 'terlambat' ? 'selected' : '' }}>Terlambat</option>
        <option value="lembur" {{ request('filter_waktu') == 'lembur' ? 'selected' : '' }}>Lembur</option>
    </select>
</div>

            <div class="flex justify-end mt-4">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Cari</button>
            </div>
        </form>

        <div class="overflow-x-auto">
            <div class="min-w-full">
                @php $i = 1; @endphp

                @forelse ($users as $user)
                    <div class="mb-4 bg-white rounded-lg shadow-md p-4">
                        <h3 class="text-lg font-bold mb-2 text-gray-800">
                            {{ $i++ }}. {{ $user->name }}
                        </h3>
                        @if ($user->attendances->isEmpty())
                            <p class="text-gray-500 italic">Tidak ada data presensi.</p>
                        @else
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Waktu Masuk</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Waktu Keluar</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                        <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                   @foreach ($user->attendances as $attendance)
                                        @php
                                            $jamKerja = explode(' - ', optional($user->company)->work_time ?? '08:00:00 - 17:00:00');
                                            $jamMasukNormal = $jamKerja[0];
                                            $jamKeluarNormal = $jamKerja[1];

                                            $dataAttendance = [
                                                'id' => $attendance->id,
                                                'tanggal' => $attendance->tanggal,
                                                'jam_masuk' => $attendance->jam_masuk,
                                                'jam_keluar' => $attendance->jam_keluar,
                                                'status' => $attendance->status,
                                                'keterangan' => $attendance->keterangan,
                                                'lampiran' => $attendance->lampiran,
                                                'foto' => $attendance->foto,
                                                'user' => [
                                                    'name' => $user->name,
                                                ],
                                            ];
                                        @endphp
                                        <tr class="hover:bg-gray-100">
                                            <td class="px-4 py-2 text-sm text-gray-500">{{ $attendance->tanggal }}</td>
                                            <td class="px-4 py-2 text-sm text-gray-500">
                                                {{ $attendance->jam_masuk ?? '-' }}
                                                @if ($attendance->jam_masuk && $attendance->jam_masuk > $jamMasukNormal)
                                                    <div class="text-xs text-red-600 mt-1">
                                                        Terlambat {{ \Carbon\Carbon::parse($jamMasukNormal)->diff(\Carbon\Carbon::parse($attendance->jam_masuk))->format('%h jam %i menit') }}
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="px-4 py-2 text-sm text-gray-500">
                                                {{ $attendance->jam_keluar ?? '-' }}
                                                @if ($attendance->jam_keluar)
                                                    @if ($attendance->jam_keluar < $jamKeluarNormal)
                                                        <div class="text-xs text-yellow-600 mt-1">
                                                            Pulang Cepat {{ \Carbon\Carbon::parse($attendance->jam_keluar)->diff(\Carbon\Carbon::parse($jamKeluarNormal))->format('%h jam %i menit') }}
                                                        </div>
                                                    @elseif ($attendance->jam_keluar > $jamKeluarNormal)
                                                        <div class="text-xs text-green-600 mt-1">
                                                            Lembur {{ \Carbon\Carbon::parse($jamKeluarNormal)->diff(\Carbon\Carbon::parse($attendance->jam_keluar))->format('%h jam %i menit') }}
                                                        </div>
                                                    @endif
                                                @endif
                                            </td>
                                            <td class="px-4 py-2 text-sm">
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium
                                                    @if ($attendance->status == 'Hadir') bg-green-100 text-green-800
                                                    @elseif ($attendance->status == 'Tidak Hadir') bg-red-100 text-red-800
                                                    @else bg-yellow-100 text-yellow-800 @endif">
                                                    {{ $attendance->status }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-2 text-center">
                                                <button class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600"
                                                    onclick='openDetailModal(@json($dataAttendance))'>
                                                    Detail
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                @empty
                    <p class="text-gray-500 text-center">Tidak ada user ditemukan.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

{{-- Modal --}}
<div id="modalDetail" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 hidden z-50">
    <div class="bg-white p-6 rounded-lg shadow-lg w-96 max-w-lg">
        <h2 class="text-xl font-semibold mb-4">Detail Presensi</h2>
        <p><strong>Nama:</strong> <span id="detailNamaUser"></span></p>
        <p><strong>Tanggal:</strong> <span id="detailTanggal"></span></p>
        <p><strong>Status:</strong> <span id="detailStatus"></span></p>
        <p><strong>Keterangan:</strong> <span id="detailKeterangan"></span></p>
        <p><strong>Lampiran:</strong>
            <a id="detailLampiran" href="#" target="_blank" class="text-blue-500 underline">Lihat Dokumen</a>
        </p>
        <p><strong>Foto Bukti:</strong></p>
        <div class="max-h-60 overflow-y-auto border rounded-lg p-2">
            <img id="detailFoto" src="#" alt="Bukti" class="rounded-lg w-full h-auto">
        </div>
        <div class="flex justify-end mt-4">
            <button id="closeDetailBtn" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                Tutup
            </button>
        </div>
    </div>
</div>

<script>
    function openDetailModal(attendance) {
        document.getElementById("detailNamaUser").innerText = attendance.user.name;
        document.getElementById("detailTanggal").innerText = attendance.tanggal;
        document.getElementById("detailStatus").innerText = attendance.status;
        document.getElementById("detailKeterangan").innerText = attendance.keterangan || '-';
        document.getElementById("detailLampiran").href = attendance.lampiran ? `/storage/${attendance.lampiran}` : '#';
        document.getElementById("detailLampiran").style.display = attendance.lampiran ? 'inline' : 'none';

        const fotoEl = document.getElementById("detailFoto");
        if (attendance.foto) {
            fotoEl.src = `/storage/${attendance.foto}`;
            fotoEl.style.display = 'block';
        } else {
            fotoEl.style.display = 'none';
        }

        document.getElementById("modalDetail").classList.remove("hidden");
    }

    document.getElementById("closeDetailBtn").addEventListener("click", () => {
        document.getElementById("modalDetail").classList.add("hidden");
    });
</script>
@endsection
