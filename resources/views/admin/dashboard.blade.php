@extends('layouts.sidemin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="space-y-6">

    <!-- Welcome -->
    <div class="bg-white rounded-xl shadow-md p-6 flex items-center gap-4">
        <div class="text-blue-600 text-4xl">
            <i class="fas fa-hand-sparkles"></i>
        </div>
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Selamat Datang, Admin</h1>
            <p class="text-gray-600">Tanggal Hari Ini: <span class="font-semibold">{{ $tanggalHariIni }}</span></p>
        </div>
    </div>

    <!-- Ringkasan & Akses Cepat -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">

        <!-- Total Pengguna RFID -->
        <div class="bg-white rounded-xl shadow-md p-6 flex justify-between items-center">
            <div>
                <p class="text-sm text-gray-500">Pengguna RFID</p>
                <p class="text-3xl font-bold text-blue-600">{{ $totalRFID }}</p>
            </div>
            <div class="text-blue-500 text-4xl">
                <i class="fas fa-id-card-alt"></i>
            </div>
        </div>
        <!-- Total Guru -->
<div class="bg-white rounded-xl shadow-md p-6 flex justify-between items-center">
    <div>
        <p class="text-sm text-gray-500">Jumlah Guru</p>
        <p class="text-3xl font-bold text-green-600">{{ $totalGuru }}</p>
    </div>
    <div class="text-green-500 text-4xl">
        <i class="fas fa-chalkboard-teacher"></i>
    </div>
</div>


        <!-- Akses Cepat -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <p class="text-sm text-gray-500 mb-3">Akses Cepat</p>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('admin.users.index') }}" class="flex items-center gap-2 px-3 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition text-sm">
                    <i class="fas fa-users"></i> Pengguna
                </a>
                <a href="{{ route('admin.presensi.index') }}" class="flex items-center gap-2 px-3 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition text-sm">
                    <i class="fas fa-clipboard-list"></i> Presensi
                </a>
                <a href="{{ route('admin.rfid.index') }}" class="flex items-center gap-2 px-3 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition text-sm">
                    <i class="fas fa-id-card"></i> RFID
                </a>
            </div>
        </div>

        <!-- Catatan Penting -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <p class="text-sm text-gray-500 mb-2 flex items-center gap-2">
                <i class="fas fa-bell text-yellow-400"></i> Catatan Penting
            </p>
            <ul class="list-disc pl-5 text-gray-700 text-sm space-y-1">
                <li>Pastikan semua pengguna telah memiliki RFID aktif.</li>
                <li>Laporan bulanan tersedia di menu "Laporan".</li>
            </ul>
        </div>
    </div>

    <!-- Presensi Terbaru -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <h2 class="text-lg font-semibold text-gray-700 mb-4 flex items-center gap-2">
            <i class="fas fa-history text-gray-600"></i> Presensi Terbaru
        </h2>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left border-collapse">
                <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                    <tr>
                        <th class="px-4 py-2">Nama</th>
                        <th class="px-4 py-2">Tanggal</th>
                        <th class="px-4 py-2">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($presensiTerbaru as $absen)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 font-medium">{{ $absen->user->name }}</td>
                            <td class="px-4 py-2">{{ \Carbon\Carbon::parse($absen->tanggal)->translatedFormat('d F Y') }}</td>
                            <td class="px-4 py-2 capitalize">
                                @php
                                    $statusColor = match($absen->status) {
                                        'hadir' => 'text-green-600',
                                        'izin' => 'text-yellow-500',
                                        'sakit' => 'text-blue-500',
                                        default => 'text-red-600'
                                    };
                                @endphp
                                <span class="font-semibold {{ $statusColor }}">{{ $absen->status }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-gray-500 py-4">Tidak ada data presensi</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
