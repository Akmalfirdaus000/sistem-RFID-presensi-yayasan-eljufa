@extends('layouts.sidemin')

@section('title', 'Rekap Absensi Harian')

@section('content')
@php
    use Carbon\Carbon;
    $tanggal = request('tanggal') ?? now()->toDateString();
    $filterStatus = request('status') ?? 'semua';
    $tanggalCarbon = Carbon::parse($tanggal);
    $namaSekolah = 'Yayasan El-Jufa';
@endphp

<div class="bg-white p-6 w-full max-w-full rounded-lg shadow-md">
    <h2 class="text-xl font-semibold text-gray-800 mb-4">Rekap Absensi Harian</h2>

    <!-- Filter -->
    <form method="GET" class="mb-4 flex flex-wrap gap-4 items-end no-print">
        <div>
            <label for="tanggal" class="block text-sm font-medium text-gray-700">Pilih Tanggal</label>
            <input type="date" name="tanggal" id="tanggal" value="{{ $tanggal }}" class="p-2 border rounded">
        </div>

        <div>
            <label for="status" class="block text-sm font-medium text-gray-700">Status Kehadiran</label>
            <select name="status" id="status" class="p-2 border rounded">
                <option value="semua" {{ $filterStatus === 'semua' ? 'selected' : '' }}>Semua</option>
                <option value="hadir" {{ $filterStatus === 'H' ? 'selected' : '' }}>Hadir (H)</option>
                <option value="izin" {{ $filterStatus === 'I' ? 'selected' : '' }}>Izin (I)</option>
                <option value="sakit" {{ $filterStatus === 'S' ? 'selected' : '' }}>Sakit (S)</option>
                <option value="alfa" {{ $filterStatus === 'A' ? 'selected' : '' }}>Alpa (A)</option>
                <option value="tidak" {{ $filterStatus === 'tidak' ? 'selected' : '' }}>Tidak Absen</option>
            </select>
        </div>

        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 h-10">
            Tampilkan
        </button>
        <button onclick="window.print()" type="button" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 h-10">
            Cetak
        </button>
    </form>

    <!-- Rekap Surat -->
    <div id="rekapSurat" class="bg-gray-100 p-6 rounded-md shadow-lg">
        <div class="text-center mb-4">
            <img src="/kemendikbud.webp" alt="Logo" class="mx-auto h-20 pb-2">
            <h3 class="text-xl font-bold">KEMENTERIAN AGAMA REPUBLIK INDONESIA</h3>
            <h4 class="font-semibold">KANTOR KEMENTERIAN AGAMA KAB. SOLOK</h4>
            <p class="font-light py-2">{{ $namaSekolah }}</p>
            <p class="font-light pb-5">Rekap Absensi Harian Tahun Pelajaran {{ $tanggalCarbon->format('Y') }}</p>
            <hr class="my-2 border-gray-400">
        </div>

        <h3 class="text-center text-lg font-bold mb-6">
            LAPORAN ABSENSI TANGGAL {{ strtoupper($tanggalCarbon->translatedFormat('l, d F Y')) }}
        </h3>

        <div class="overflow-x-auto mb-8">
            <table class="w-full border-collapse text-sm">
                <thead>
                    <tr class="text-center bg-blue-200 font-semibold">
                        <th class="border border-gray-400 px-3 py-2">No</th>
                        <th class="border border-gray-400 px-3 py-2">Nama</th>
                        <th class="border border-gray-400 px-3 py-2">Status</th>
                        <th class="border border-gray-400 px-3 py-2">Jam Masuk</th>
                        <th class="border border-gray-400 px-3 py-2">Jam Keluar</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @forelse($users as $user)
                        @php
                            $absen = $user->attendances->first();
                            $tampilkan = false;

                            if ($absen) {
                                if ($filterStatus === 'semua' || $absen->status === $filterStatus) {
                                    $tampilkan = true;
                                }
                            } else {
                                if ($filterStatus === 'semua' || $filterStatus === 'tidak') {
                                    $tampilkan = true;
                                }
                            }
                        @endphp

                        @if($tampilkan)
                            <tr class="text-center hover:bg-gray-100">
                                <td class="border border-gray-400 px-3 py-2">{{ $no++ }}</td>
                                <td class="border border-gray-400 px-3 py-2 text-left">{{ $user->name }}</td>
                                @if($absen)
                                    <td class="border border-gray-400 px-3 py-2 font-semibold text-green-700">{{ $absen->status }}</td>
                                    <td class="border border-gray-400 px-3 py-2">{{ $absen->jam_masuk ?? '-' }}</td>
                                    <td class="border border-gray-400 px-3 py-2">{{ $absen->jam_keluar ?? '-' }}</td>
                                @else
                                    <td class="border border-gray-400 px-3 py-2 text-red-600 font-semibold">Tidak Absen</td>
                                    <td class="border border-gray-400 px-3 py-2">-</td>
                                    <td class="border border-gray-400 px-3 py-2">-</td>
                                @endif
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-gray-500 py-4">Tidak ada data siswa</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-12 flex justify-end mr-20">
            <div class="text-center">
                <p>Alahan Panjang, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
                <p>Kepala Yayasan</p>
                <div style="height: 80px;"></div>
                <p class="font-semibold underline">[Dr. Junsel Friade Alstra, S. Hi, M. H.]</p>
                <p>NIP: [211100005]</p>
            </div>
        </div>
    </div>
</div>

<!-- CSS untuk print -->
<style>
    @media print {
        body * {
            visibility: hidden;
        }
        #rekapSurat, #rekapSurat * {
            visibility: visible;
        }
        #rekapSurat {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }
        .no-print {
            display: none !important;
        }
    }
</style>
@endsection
