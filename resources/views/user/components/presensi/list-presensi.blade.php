<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Presensi Real-Time</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
</head>
<body class="bg-gray-100 p-6">
    <div class="bg-green-700 p-6 mt-5 rounded-lg shadow-xl items-center justify-between space-x-6 md:space-x-8">
        <h2 class="text-2xl font-semibold mb-4 text-white">Daftar Presensi</h2>
        
        <form method="GET" action="{{ route('presensi.index') }}" class="mb-4 flex gap-2">
            <input type="date" id="search_date" name="search_date" class="border p-2 rounded w-full" value="{{ request('search_date', date('Y-m-d')) }}">
            <button type="submit" class="bg-blue-700 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">Cari</button>
        </form>

        <div class="mb-4">
            <p class="text-white">Nama: <span class="font-semibold">{{ $user->name }}</span></p>
            <p class="text-white">Jabatan: <span class="font-semibold">{{ $user->jabatan }}</span></p>
        </div>

        <button id="openModalBtn" class="bg-blue-700 text-white px-4 py-2 rounded-md hover:bg-blue-800 transition shadow-md">
            + Ajukan Izin/Cuti
        </button>

        <div class="overflow-x-auto mt-4">
            <table class="w-full table-auto border-collapse border border-gray-300 shadow-sm">
                <thead>
                    <tr class="bg-gray-200 text-gray-700">
                        <th class="px-4 py-2 border">No</th>
                        <th class="px-4 py-2 border">Tanggal</th>
                        <th class="px-4 py-2 border">Status</th>
                        <th class="px-4 py-2 border">Jam Masuk</th>
                        <th class="px-4 py-2 border">Jam Keluar</th>
                        <th class="px-4 py-2 border">Aksi</th>
                    </tr>
                </thead>
                <tbody id="attendance-table">
                    @foreach($attendances as $index => $attendance)
                        <tr class="hover:bg-green-500 text-white" data-id="{{ $attendance->id_attendance }}">
                            <td class="px-4 py-2 border text-center">{{ $index + 1 }}</td>
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
    <div id="modalIzinCuti" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-96">
        <h2 class="text-xl font-semibold mb-4">Ajukan Izin/Cuti</h2>
        
        <form id="formIzinCuti" method="POST" action="{{ route('presensi.izin') }}" enctype="multipart/form-data">
            @csrf

            <!-- Input Tanggal -->
            <label class="block text-sm font-medium text-gray-700">Tanggal</label>
            <input type="date" name="tanggal" id="tanggal" class="border p-2 w-full rounded mb-3" required>

            <!-- Input Jenis Izin -->
            <label class="block text-sm font-medium text-gray-700">Jenis Izin</label>
            <select name="status" id="status" class="border p-2 w-full rounded mb-3" required>
                <option value="izin">Izin</option>
                <option value="cuti">Cuti</option>
            </select>

            <!-- Input Keterangan -->
            <label class="block text-sm font-medium text-gray-700">Keterangan</label>
            <textarea name="keterangan" id="keterangan" class="border p-2 w-full rounded mb-3" required></textarea>

            <!-- Input File Lampiran -->
            <label class="block text-sm font-medium text-gray-700">Lampiran (PDF/Dokumen)</label>
            <input type="file" name="lampiran" id="lampiran" class="border p-2 w-full rounded mb-3" accept=".pdf,.doc,.docx">

            <!-- Input Foto Bukti -->
            <label class="block text-sm font-medium text-gray-700">Foto Bukti</label>
            <input type="file" name="foto" id="foto" class="border p-2 w-full rounded mb-3" accept="image/*">

            <div class="flex justify-end">
                <button type="button" id="closeModalBtn" class="mr-2 bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition">
                    Batal
                </button>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                    Kirim
                </button>
            </div>
        </form>
    </div>
</div>
    <!-- /modalizin -->

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

<script>
    function openDetailModal(attendance) {
        // document.getElementById("detailNamaUser").innerText = attendance.nama_user || 'Tidak diketahui';
        document.getElementById("detailNamaUser").innerText = "{{ Auth::user()->name }}";

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
<!-- Script Modal Handling -->
<script>
    document.getElementById("openModalBtn").addEventListener("click", () => {
        document.getElementById("modalIzinCuti").classList.remove("hidden");
    });

    document.getElementById("closeModalBtn").addEventListener("click", () => {
        document.getElementById("modalIzinCuti").classList.add("hidden");
    });
</script>

    <script>
        Pusher.logToConsole = false;
        var pusher = new Pusher("{{ env('PUSHER_APP_KEY') }}", { cluster: "{{ env('PUSHER_APP_CLUSTER') }}", forceTLS: true });
        var channel = pusher.subscribe("attendance-channel");
        channel.bind("attendance.updated", function(data) {
            let tableBody = document.getElementById("attendance-table");
            let existingRow = document.querySelector(`tr[data-id="${data.attendance.id_attendance}"]`);
            
            if (existingRow) {
                existingRow.cells[4].innerText = data.attendance.jam_keluar ?? '-';
            } else {
                let newRow = document.createElement("tr");
                newRow.classList.add("hover:bg-gray-50");
                newRow.setAttribute("data-id", data.attendance.id_attendance);
                newRow.innerHTML = `
                    <td class="px-4 py-2 border text-center">-</td>
                    <td class="px-4 py-2 border text-center">${data.attendance.tanggal}</td>
                    <td class="px-4 py-2 border text-center capitalize">${data.attendance.status}</td>
                    <td class="px-4 py-2 border text-center">${data.attendance.jam_masuk ?? '-'}</td>
                    <td class="px-4 py-2 border text-center">${data.attendance.jam_keluar ?? '-'}</td>
                    <td class="px-4 py-2 border text-center">
                        <button class="bg-blue-500 text-white px-3 py-1 rounded-md hover:bg-blue-600 transition" onclick="openDetailModal(data.attendance)">Detail</button>
                    </td>
                `;
                tableBody.prepend(newRow);
                Array.from(tableBody.rows).forEach((row, index) => {
                    row.cells[0].innerText = index + 1;
                });
            }
        });
        
       
    </script>
</body>
</html>
