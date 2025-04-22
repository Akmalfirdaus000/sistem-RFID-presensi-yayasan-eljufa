<div class="bg-white p-6 rounded-lg shadow-xl">
    <h2 class="text-2xl font-bold text-gray-700 mb-4">Riwayat Presensi</h2>

    @if($riwayatPresensi->isEmpty())
        <p class="text-gray-600 text-center">Belum ada riwayat presensi.</p>
    @else
     <form method="GET" action="{{ route('riwayat.index') }}" class="mb-4 flex gap-2">
            <input type="date" id="search_date" name="search_date" class="border p-2 rounded w-full" value="{{ request('search_date', date('Y-m-d')) }}">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">Cari</button>
        </form>
        <div class="overflow-x-auto">
            <table class="w-full border-collapse border border-gray-300 shadow-sm">
                <thead>
                    <tr class="bg-gray-100 text-gray-700 text-sm">
                        <th class="px-4 py-2 border">No</th>
                        <th class="px-4 py-2 border">Tanggal</th>
                        <th class="px-4 py-2 border">Status</th>
                        <th class="px-4 py-2 border">Jam Masuk</th>
                        <th class="px-4 py-2 border">Jam Keluar</th>
                        <th class="px-4 py-2 border">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($riwayatPresensi as $index => $attendance)
                        <tr class="hover:bg-gray-50 text-sm">
                            <td class="px-4 py-2 border text-center">{{ $loop->iteration }}</td>
                            <td class="px-4 py-2 border text-center">{{ $attendance->tanggal }}</td>
                            <td class="px-4 py-2 border text-center capitalize">{{ $attendance->status }}</td>
                            <td class="px-4 py-2 border text-center">{{ $attendance->jam_masuk ?? '-' }}</td>
                            <td class="px-4 py-2 border text-center">{{ $attendance->jam_keluar ?? '-' }}</td>
                            <td class="px-4 py-2 border text-center">
                                <button onclick="openDetailModal({{ json_encode($attendance) }})" 
                                    class="px-3 py-1 bg-blue-500 text-white text-xs rounded hover:bg-blue-600 transition">
                                    Detail
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="flex justify-center items-center mt-4">
            {{ $riwayatPresensi->links('pagination::tailwind') }}
        </div>
    @endif
</div>

<!-- Modal Detail Presensi -->
<div id="modalDetail" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-96 max-w-lg">
        <h2 class="text-xl font-semibold mb-4">Detail Izin/Cuti</h2>
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

<!-- Script Modal -->
<script>
    function openDetailModal(attendance) {
        document.getElementById("detailNamaUser").innerText = "{{ Auth::user()->name }}";
        document.getElementById("detailTanggal").innerText = attendance.tanggal;
        document.getElementById("detailStatus").innerText = attendance.status;
        document.getElementById("detailKeterangan").innerText = attendance.keterangan || '-';
        
        const lampiranEl = document.getElementById("detailLampiran");
        if (attendance.lampiran) {
            lampiranEl.href = `/storage/${attendance.lampiran}`;
            lampiranEl.style.display = 'inline';
        } else {
            lampiranEl.style.display = 'none';
        }

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
