

@extends('layouts.kepala')

@section('title', 'Laporan Harian')

@section('content')
@include('components.alert')

@php
    use Carbon\Carbon;
    $tanggal = request('tanggal') ?? now()->toDateString();
    $tanggalCarbon = Carbon::parse($tanggal);
@endphp

<div class="bg-white p-6 w-full rounded-lg shadow-md">
    <h2 class="text-xl font-semibold text-gray-800 mb-4">Laporan Absensi Harian</h2>

    <!-- Filter -->
    <form method="GET" class="mb-4 flex flex-wrap gap-4 items-end no-print">
        <div>
            <label for="tanggal" class="block text-sm font-medium text-gray-700">Tanggal</label>
            <input type="date" name="tanggal" id="tanggal" value="{{ $tanggal }}" class="p-2 border rounded">
        </div>
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 h-10">Tampilkan</button>
        
    </form>

    <div id="rekapSurat" class="bg-gray-50 p-6 rounded-md shadow-lg">
        <div class="text-center mb-4">
            <img src="/kemendikbud.webp" alt="Logo" class="mx-auto h-20 pb-2">
            <h3 class="text-xl font-bold">KEMENTERIAN AGAMA REPUBLIK INDONESIA</h3>
            <h4 class="font-semibold">KANTOR KEMENTERIAN AGAMA KABUPATEN SOLOK</h4>
            <p class="font-light py-2">Yayasan El-Jufa</p>
            <hr class="my-2 border-gray-400">
            <p class="font-light pb-5">Laporan Absensi Tanggal {{ $tanggalCarbon->translatedFormat('d F Y') }}</p>
        </div>

        <table class="w-full border-collapse border text-sm">
            <thead class="bg-blue-200 text-center">
                <tr>
                    <th class="border px-3 py-2">No</th>
                    <th class="border px-3 py-2">Nama</th>
                    <th class="border px-3 py-2">Status</th>
                    <th class="border px-3 py-2">Jam Masuk</th>
                    <th class="border px-3 py-2">Jam Keluar</th>
                </tr>
            </thead>
            <tbody>
                @php $no = 1; @endphp
                @foreach($users as $user)
                    @php $absen = $user->attendances->firstWhere('tanggal', $tanggal); @endphp
                    <tr class="text-center hover:bg-gray-100">
                        <td class="border px-3 py-2">{{ $no++ }}</td>
                        <td class="border px-3 py-2 text-left">{{ $user->name }}</td>
                        <td class="border px-3 py-2 font-semibold {{ $absen ? 'text-green-600' : 'text-red-600' }}">
                            {{ $absen->status ?? 'Tidak Absen' }}
                        </td>
                        <td class="border px-3 py-2">{{ $absen->jam_masuk ?? '-' }}</td>
                        <td class="border px-3 py-2">{{ $absen->jam_keluar ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-12 flex justify-end mr-20">
            <div class="text-center">
                <p>Alahan Panjang, {{ now()->translatedFormat('d F Y') }}</p>
                <p>Kepala Yayasan</p>
                <div style="height: 80px;"></div>
                <p class="font-semibold underline">[Dr. Junsel Friade Alstra, S. Hi, M. H.]</p>
                <p>NIP: [211100005]</p>
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        body * { visibility: hidden; }
        #rekapSurat, #rekapSurat * { visibility: visible; }
        #rekapSurat { position: absolute; top: 0; left: 0; width: 100%; }
        .no-print { display: none !important; }
    }
</style>
@endsection
