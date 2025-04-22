@extends('layouts.sidemin')

@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-2xl font-bold mb-4">Detail Pengguna</h2>

    <!-- Biodata Pengguna -->
   <!-- Biodata Pengguna -->
<div class="bg-white shadow-md rounded-lg p-6 mb-6">
    <h3 class="text-xl font-semibold mb-4">Biodata Pengguna</h3>
    
    <div class="flex items-center space-x-6 mb-4">
<img src="{{ asset('storage/' . $user->foto) }}" 
    alt="Foto {{ $user->name }}" 
    class="w-24 h-24 rounded-full border-2 border-gray-300 object-cover">

    <p>Path Foto: {{ asset('storage/users/' . $user->foto) }}</p>



    </div>

    <div class="grid grid-cols-2 gap-4">
        <p><strong>Nama:</strong> {{ $user->name }}</p>
        <p><strong>NIK:</strong> {{ $user->nik ?? '-' }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Jabatan:</strong> {{ $user->jabatan ?? '-' }}</p>
        <p><strong>RFID:</strong> {{ $user->id_rfid ?? '-' }}</p>
        <p><strong>Role:</strong> 
            <span class="px-2 py-1 text-xs font-semibold rounded-full 
            {{ $user->role === 'admin' ? 'bg-green-200 text-green-800' : 'bg-blue-200 text-blue-800' }}">
                {{ ucfirst($user->role) }}
            </span>
        </p>
    </div>
</div>
@include('admin.users.partial.rekap-user', ['rekapPresensi' => $rekapPresensi])


    <!-- Tombol Pilih Bulan -->
    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <h3 class="text-xl font-semibold mb-4">Pilih Bulan</h3>

        <div class="grid grid-cols-6 gap-2 mb-2">
            @foreach(['01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April', '05' => 'Mei', '06' => 'Juni'] as $key => $bulan)
                <button onclick="showMonth('{{ $key }}')" class="month-btn bg-blue-500 text-white px-3 py-2 rounded-md hover:bg-blue-600 transition">{{ $bulan }}</button>
            @endforeach
        </div>

        <div class="grid grid-cols-6 gap-2">
            @foreach(['07' => 'Juli', '08' => 'Agustus', '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'] as $key => $bulan)
                <button onclick="showMonth('{{ $key }}')" class="month-btn bg-blue-500 text-white px-3 py-2 rounded-md hover:bg-blue-600 transition">{{ $bulan }}</button>
            @endforeach
        </div>
    </div>

    <!-- Riwayat Presensi -->
    <div class="bg-white shadow-md rounded-lg p-6">
        <h3 class="text-xl font-semibold mb-4">Riwayat Presensi</h3>

        <div id="presensi-container">
            @forelse ($presences as $month => $records)
                <div class="presensi-month mb-4" data-month="{{ \Carbon\Carbon::parse($month)->format('m') }}">
                    <h4 class="text-lg font-semibold bg-gray-100 p-2 rounded-md">{{ \Carbon\Carbon::parse($month)->translatedFormat('F Y') }}</h4>
                    <table class="w-full mt-2 border-collapse">
                        <thead>
                            <tr class="bg-gray-100 border-b">
                                <th class="p-3">Tanggal</th>
                                <th class="p-3">Status</th>
                                <th class="p-3">Jam Masuk</th>
                                <th class="p-3">Jam Keluar</th>
                    <th class="px-4 py-2 border">Aksi</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($records as $record)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-3">{{ \Carbon\Carbon::parse($record->tanggal)->translatedFormat('d F Y') }}</td>
                                <td class="p-3">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                        {{ $record->status === 'hadir' ? 'bg-green-200 text-green-800' : ($record->status === 'izin' ? 'bg-yellow-200 text-yellow-800' : 'bg-red-200 text-red-800') }}">
                                        {{ ucfirst($record->status) }}
                                    </span>
                                </td>
                                <td class="p-3">{{ $record->jam_masuk ?? '-' }}</td>
                                <td class="p-3">{{ $record->jam_keluar ?? '-' }}</td>
                                <td class="px-4 py-2 border text-center">
                            <button class="bg-blue-500 text-white px-3 py-1 rounded-md hover:bg-blue-600 transition" onclick="openDetailModal({{ json_encode($record) }})">Detail</button>
                        </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @empty
                <p class="text-gray-500">Tidak ada riwayat presensi.</p>
            @endforelse
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
        <div class="flex justify-end mt-4 hidden">
            <button id="modalDetail" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition">
                Tutup
            </button>
        </div>
    </div>
</div>
    </div>

    <!-- Tombol Kembali -->
    <div class="mt-6">
        <a href="{{ route('admin.users.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition">Kembali</a>
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
          
        document.getElementById("modalDetail").addEventListener("click", function(event) {
    if (event.target === this) {
        this.classList.add("hidden");
    }
});


    }
    function showMonth(month) {
        document.querySelectorAll('.presensi-month').forEach(element => {
            if (element.getAttribute('data-month') === month) {
                element.style.display = 'block';
            } else {
                element.style.display = 'none';
            }
        });
    }

    // Tampilkan bulan saat ini secara default
    document.addEventListener('DOMContentLoaded', function() {
        const currentMonth = new Date().getMonth() + 1; 
        const formattedMonth = currentMonth < 10 ? '0' + currentMonth : '' + currentMonth;
        showMonth(formattedMonth);
    });
</script>
@endsection
