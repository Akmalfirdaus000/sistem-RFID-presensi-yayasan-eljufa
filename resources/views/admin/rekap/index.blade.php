@extends('layouts.sidemin')

@section('title', 'Rekap Absensi Bulanan')

@section('content')
@php
    use Carbon\Carbon;
    use Carbon\CarbonPeriod;

    $bulan = (int)(request('bulan') ?? now()->month);
    $tahun = (int)(request('tahun') ?? now()->year);
    $jumlahHari = Carbon::create($tahun, $bulan)->daysInMonth;
    $tanggalAwal = Carbon::create($tahun, $bulan, 1);
    $tanggalAkhir = Carbon::create($tahun, $bulan, $jumlahHari);
    $tanggalPeriode = CarbonPeriod::create($tanggalAwal, $tanggalAkhir);

    $namaSekolah = 'MTS NEGERI 1 WONOGIRI';
@endphp

<div class="bg-white p-6 rounded-lg shadow-md">

    <h2 class="text-xl font-semibold text-gray-800 mb-4">Rekap Absensi Bulanan</h2>

    <!-- Filter -->
    <form method="GET" class="mb-4 flex gap-4 no-print ">
        <select name="bulan" class="p-2 border rounded">
            @for ($m = 1; $m <= 12; $m++)
                <option value="{{ $m }}" {{ $m == $bulan ? 'selected' : '' }}>
                    {{ Carbon::create()->month($m)->translatedFormat('F') }}
                </option>
            @endfor
        </select>
        <select name="tahun" class="p-2 border rounded">
            @for ($y = now()->year - 1; $y <= now()->year + 1; $y++)
                <option value="{{ $y }}" {{ $y == $tahun ? 'selected' : '' }}>{{ $y }}</option>
            @endfor
        </select>
        <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Tampilkan</button>
         <div class="flex justify-end mb-3 no-print">
        </div>
        <button onclick="window.print()"
                class="px-4 py-2 bg-blue-700 text-white rounded hover:bg-blue-800">
            Cetak
        </button>
    </form>


    <!-- Surat dan Tabel Rekap -->
    <div id="rekapSurat" class="bg-gray-100 p-6 rounded-md shadow-lg">
        <div class="text-center mb-4">
            <img src="/th.jpeg" alt="Logo" class="mx-auto h-20 pb-2">
            <h3 class="text-xl font-bold">KEMENTERIAN AGAMA REPUBLIK INDONESIA</h3>
            <h4 class="font-semibold">KANTOR KEMENTERIAN AGAMA KAB. WONOGIRI</h4>
            <p class="font-light py-2">{{ $namaSekolah }}</p>
            <p class="font-light pb-5">Rekap Absensi Bulanan Tahun Pelajaran {{ $tahun }}</p>
            <hr class="my-2 border-gray-400">
        </div>

        <h3 class="text-center text-lg font-bold mb-4">
            LAPORAN REKAP ABSENSI BULAN {{ strtoupper($tanggalAwal->translatedFormat('F')) }} {{ $tahun }}
        </h3>

        <div class="overflow-auto mb-8">
            <table class="w-full border-collapse text-sm">
                <thead>
                    <tr class="text-white text-center font-semibold">
                        <th class="border border-gray-400 bg-gray-300 text-black align-middle" rowspan="2" style="min-width:180px;">NAMA</th>
                        <th class="border border-gray-400 bg-pink-200 text-black" colspan="{{ $jumlahHari }}">
                            HARI/TGL: {{ $tanggalAwal->format('d') }} s/d {{ $tanggalAkhir->format('d') }}
                            {{ $tanggalAwal->translatedFormat('F') }} {{ $tahun }}
                        </th>
                        <th class="border border-gray-400 bg-blue-400 text-black" rowspan="2">HADIR</th>
                        <th class="border border-gray-400 bg-yellow-300 text-black" colspan="3">ABSEN</th>
                    </tr>
                    <tr class="text-center text-black font-semibold">
                        @foreach ($tanggalPeriode as $tanggal)
                            @php
                                $hari = strtoupper($tanggal->translatedFormat('l'));
                                $bg = $hari === 'MINGGU' ? 'bg-gray-400' : 'bg-pink-100';
                            @endphp
                            <th class="border border-gray-400 italic {{ $bg }}">
                                {{ $hari[0] }}<br>{{ $tanggal->format('d') }}
                            </th>
                        @endforeach
                        <th class="border border-gray-400 bg-green-500 text-white">S</th>
                        <th class="border border-gray-400 bg-yellow-500 text-white">I</th>
                        <th class="border border-gray-400 bg-red-600 text-white">A</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr class="text-center hover:bg-gray-100">
                            <td class="border border-gray-400 px-2 text-left">{{ $user->name }}</td>
                            @php
                                $hadir = 0;
                                $sakit = 0;
                                $izin = 0;
                                $alpa = 0;
                            @endphp
                            @foreach ($tanggalPeriode as $tanggal)
                                @php
                                    $absen = $user->attendances->firstWhere('tanggal', $tanggal->toDateString());
                                    $status = $absen->status ?? '-';

                                    if ($status == 'H') $hadir++;
                                    elseif ($status == 'S') $sakit++;
                                    elseif ($status == 'I') $izin++;
                                    elseif ($status == 'A') $alpa++;
                                @endphp
                                <td class="border border-gray-400 px-1">{{ $status }}</td>
                            @endforeach
                            <td class="border border-gray-400 font-bold text-green-600">{{ $hadir }}</td>
                            <td class="border border-gray-400 font-bold text-green-600">{{ $sakit }}</td>
                            <td class="border border-gray-400 font-bold text-yellow-600">{{ $izin }}</td>
                            <td class="border border-gray-400 font-bold text-red-600">{{ $alpa }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ $jumlahHari + 5 }}" class="text-center text-gray-500 py-4">Tidak ada data siswa</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-12 flex justify-end mr-20">
            <div class="text-center">
                <p>WONOGIRI, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
                <p>Kepala Yayasan</p>
                <div style="height: 80px;"></div>
                <p class="font-semibold underline">[Nama Kepala Yayasan]</p>
                <p>NIP: [Nomor Induk Pegawai]</p>
            </div>
        </div>
    </div>

    <!-- Tombol Cetak hanya tampil di layar (no-print) -->

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
