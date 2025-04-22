@extends('layouts.sidemin')

@section('content')
<div class="bg-white p-6 mt-5 rounded-lg shadow-xl">
    <h2 class="text-2xl font-semibold mb-4 text-gray-800">Daftar Presensi</h2>
    
   
    <!-- Form Pencarian -->
<form method="GET" action="{{ route('admin.presensi.index') }}" class="mb-4 flex flex-wrap gap-2">
    <input type="text" name="search_name" placeholder="Cari Nama..." value="{{ request('search_name') }}" class="border p-2 rounded w-full md:w-auto">
    
    <input type="date" name="search_date" value="{{ request('search_date') }}" class="border p-2 rounded w-full md:w-auto" placeholder="Pilih Tanggal">
    
    <select name="search_status" class="border p-2 rounded w-full md:w-auto">
        <option value="">Semua Status</option>
        <option value="hadir" {{ request('search_status') == 'hadir' ? 'selected' : '' }}>Hadir</option>
        <option value="izin" {{ request('search_status') == 'izin' ? 'selected' : '' }}>Izin</option>
        <option value="cuti" {{ request('search_status') == 'cuti' ? 'selected' : '' }}>Cuti</option>
    </select>

    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">Cari</button>
</form>

    
    <div class="overflow-x-auto mt-4">
        <table class="w-full table-auto border-collapse border border-gray-300 shadow-sm">
            <thead>
                <tr class="bg-gray-100 text-gray-700">
                    <th class="px-4 py-2 border">No</th>
                    <th class="px-4 py-2 border">Nama</th>
                    <th class="px-4 py-2 border">Tanggal</th>
                    <th class="px-4 py-2 border">Status</th>
                    <th class="px-4 py-2 border">Jam Masuk</th>
                    <th class="px-4 py-2 border">Jam Keluar</th>
                    <th class="px-4 py-2 border">Aksi</th>
                </tr>
            </thead>
            <tbody id="attendance-table">
                @foreach($attendances as $index => $attendance)
                    <tr class="hover:bg-gray-50" data-id="{{ $attendance->id_attendance }}">
                        <td class="px-4 py-2 border text-center">{{ $index + 1 }}</td>
                        <td class="px-4 py-2 border text-center">{{ $attendance->user->name }}</td>
                        <td class="px-4 py-2 border text-center">{{ $attendance->tanggal }}</td>
                        <td class="px-4 py-2 border text-center capitalize">{{ $attendance->status }}</td>
                        <td class="px-4 py-2 border text-center">{{ $attendance->jam_masuk ?? '-' }}</td>
                        <td class="px-4 py-2 border text-center">{{ $attendance->jam_keluar ?? '-' }}</td>
                        <td class="px-4 py-2 border text-center">
                            <button class="bg-blue-500 text-white px-3 py-1 rounded-md hover:bg-blue-600 transition" onclick="openDetailModal({{ json_encode($attendance) }})">Detail</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="flex justify-center items-center space-x-2 mt-4">
        {{ $attendances->links('pagination::tailwind') }}
    </div>
</div>

<div id="modalDetail" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 hidden">
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
            <button id="closeDetailBtn" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition">
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
