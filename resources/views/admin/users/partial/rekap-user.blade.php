<div class="bg-white shadow-md rounded-lg p-6 mt-6">
    <h3 class="text-xl font-semibold mb-4">Rekapitulasi Presensi</h3>

    <table class="w-full border-collapse border">
        <thead>
            <tr class="bg-gray-100">
                <th class="p-3 border">Bulan</th>
                <th class="p-3 border">Total Hadir</th>
                <th class="p-3 border">Total Cuti</th>
                <th class="p-3 border">Total Izin</th>
                <th class="p-3 border">Total Absen</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rekapPresensi as $bulan => $rekap)
            <tr class="border">
                <td class="p-3 border">{{ \Carbon\Carbon::parse($bulan)->translatedFormat('F Y') }}</td>
                <td class="p-3 border">{{ $rekap['hadir'] }}</td>
                <td class="p-3 border">{{ $rekap['cuti'] }}</td>
                <td class="p-3 border">{{ $rekap['izin'] }}</td>
                <td class="p-3 border">{{ $rekap['absen'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
