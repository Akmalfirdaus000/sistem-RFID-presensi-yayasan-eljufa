@extends('layouts.sidemin')

@section('content')
<div class="bg-white p-6 mt-5 rounded-lg shadow-xl">
    <h2 class="text-2xl font-semibold mb-4 text-gray-800">Detail Presensi - {{ $user->name }}</h2>

    <!-- Biodata User -->
    <div class="mb-6 border-b pb-4">
        <h3 class="text-lg font-semibold">Biodata</h3>
        <p><strong>Nama:</strong> {{ $user->name }}</p>
        <p><strong>Jabatan:</strong> {{ $user->jabatan }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
    </div>

    <!-- Riwayat Presensi -->
    <h3 class="text-lg font-semibold mb-3">Riwayat Presensi</h3>
    
    @foreach($presensiPerBulan as $bulan => $presensi)
        <div class="mb-4">
            <h4 class="font-semibold text-blue-600">{{ $bulan }}</h4>
            <table class="w-full table-auto border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 border">Tanggal</th>
                        <th class="px-4 py-2 border">Status</th>
                        <th class="px-4 py-2 border">Jam Masuk</th>
                        <th class="px-4 py-2 border">Jam Keluar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($presensi as $item)
                        <tr>
                            <td class="px-4 py-2 border">{{ $item->tanggal }}</td>
                            <td class="px-4 py-2 border">{{ $item->status }}</td>
                            <td class="px-4 py-2 border">{{ $item->jam_masuk ?? '-' }}</td>
                            <td class="px-4 py-2 border">{{ $item->jam_keluar ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endforeach
</div>
@endsection
