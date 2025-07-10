<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Presensi Real-Time</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
</head>

<body class="bg-slate-100 p-6">
    @include('components.alert')

    <div class="bg-teal-800 p-6 mt-5 rounded-xl shadow-2xl space-y-4">
        <h2 class="text-2xl font-semibold text-white border-b border-white pb-2">Presensi Harian</h2>

        <form method="GET" action="{{ route('presensi.index') }}" class="flex gap-2">
            <input type="date" id="search_date" name="search_date"
                class="border p-2 rounded w-full" value="{{ request('search_date', date('Y-m-d')) }}">
            <button type="submit"
                class="bg-sky-600 text-white px-4 py-2 rounded-md hover:bg-sky-700 transition">Cari</button>
        </form>

        <div class="text-white">
            <p>Nama: <span class="font-semibold">{{ $user->name }}</span></p>
            <p>Jabatan: <span class="font-semibold">{{ $user->jabatan }}</span></p>
        </div>

        <button onclick="openModal()"
            class="bg-amber-500 text-white px-4 py-2 rounded-md hover:bg-amber-600 transition">Ajukan Izin Ketidakhadiran</button>

        <div class="overflow-x-auto mt-4">
            <table class="w-full table-auto border-collapse border border-gray-300 shadow-sm">
                <thead>
                    <tr class="bg-teal-700 text-white text-sm uppercase tracking-wide">
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
                        <tr class="bg-white hover:bg-teal-100 text-gray-800 transition" data-id="{{ $attendance->id_attendance }}">
                            <td class="px-4 py-2 border text-center">{{ $index + 1 }}</td>
                            <td class="px-4 py-2 border text-center">{{ $attendance->tanggal }}</td>
                            <td class="px-4 py-2 border text-center capitalize">{{ $attendance->status }}</td>
                            <td class="px-4 py-2 border text-center">{{ $attendance->jam_masuk ?? '-' }}</td>
                            <td class="px-4 py-2 border text-center">{{ $attendance->jam_keluar ?? '-' }}</td>
                            <td class="px-4 py-2 border text-center">
                                <button onclick="openDetailModal({{ json_encode($attendance) }})"
                                    class="bg-sky-600 text-white px-3 py-1 rounded-md hover:bg-sky-700 transition">Detail</button>
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

    <!-- Modal Detail -->
<div id="modalDetail" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white p-6 md:p-8 rounded-2xl shadow-2xl w-full max-w-md border-l-4 border-teal-600 transition-all duration-300">
        <h2 class="text-2xl font-bold text-teal-700 mb-4 flex items-center gap-2">
            <i class="fas fa-info-circle text-teal-600 text-xl"></i> Detail Izin
        </h2>

        <div class="space-y-2 text-gray-700 text-sm">
            <p><span class="font-semibold text-gray-800">Nama:</span> <span id="detailNamaUser">-</span></p>
            <p><span class="font-semibold text-gray-800">Tanggal:</span> <span id="detailTanggal">-</span></p>
            <p><span class="font-semibold text-gray-800">Status:</span> <span id="detailStatus">-</span></p>
            <p><span class="font-semibold text-gray-800">Keterangan:</span> <span id="detailKeterangan">-</span></p>
            <p>
                <span class="font-semibold text-gray-800">Lampiran:</span>
                <a id="detailLampiran" href="#" target="_blank" class="text-sky-600 hover:text-sky-800 underline">Lihat Dokumen</a>
            </p>
        </div>

        <!-- Foto Bukti -->
        <div class="mt-4 max-h-60 overflow-y-auto border border-gray-200 rounded-lg p-2 bg-gray-50">
            <img id="detailFoto" src="#" alt="Bukti Izin" class="rounded-lg w-full h-auto object-cover">
        </div>

        <!-- Tombol Tutup -->
        <div class="flex justify-end mt-6">
            <button id="closeDetailBtn"
                class="bg-gray-600 hover:bg-gray-700 text-white px-5 py-2 rounded-md text-sm font-semibold shadow-sm">
                <i class="fas fa-times mr-1"></i> Tutup
            </button>
        </div>
    </div>
</div>


    <!-- Modal Ajukan Izin -->
    <div id="modalIzinCuti" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-50">
        <div class="bg-white p-6 rounded-xl shadow-xl w-full max-w-md border-t-4 border-amber-500">
            <h2 class="text-xl font-semibold mb-4">Ajukan Izin Ketidakhadiran</h2>
            <form id="formIzinCuti" method="POST" action="{{ route('presensi.izin') }}" enctype="multipart/form-data">
                @csrf
                <label class="block text-sm font-medium text-gray-700">Tanggal</label>
                <input type="date" name="tanggal" class="border p-2 w-full rounded mb-3" required>

                <label class="block text-sm font-medium text-gray-700">Jenis Izin</label>
                <select name="status" class="border p-2 w-full rounded mb-3" required>
                    <option value="izin">izin</option>
                    <option value="sakit">Sakit</option>
                    <option value="lainnya">Lainnya</option>
                </select>

                <label class="block text-sm font-medium text-gray-700">Keterangan</label>
                <textarea name="keterangan" class="border p-2 w-full rounded mb-3" required></textarea>

                <label class="block text-sm font-medium text-gray-700">Lampiran (PDF/Dokumen)</label>
                <input type="file" name="lampiran" class="border p-2 w-full rounded mb-3" accept=".pdf,.doc,.docx">

                <label class="block text-sm font-medium text-gray-700">Foto Bukti</label>
                <input type="file" name="foto" class="border p-2 w-full rounded mb-3" accept="image/*">

                <div class="flex justify-end">
                    <button type="button" onclick="closeModal()"
                        class="mr-2 bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Batal</button>
                    <button type="submit" class="bg-teal-700 text-white px-4 py-2 rounded hover:bg-teal-800">Kirim</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal() {
            document.getElementById('modalIzinCuti').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('modalIzinCuti').classList.add('hidden');
        }

        function openDetailModal(attendance) {
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

    <script>
        Pusher.logToConsole = false;
        var pusher = new Pusher("{{ env('PUSHER_APP_KEY') }}", {
            cluster: "{{ env('PUSHER_APP_CLUSTER') }}",
            forceTLS: true
        });

        var channel = pusher.subscribe("attendance-channel");
        channel.bind("attendance.updated", function (data) {
            let tableBody = document.getElementById("attendance-table");
            let existingRow = document.querySelector(`tr[data-id="${data.attendance.id_attendance}"]`);

            if (existingRow) {
                existingRow.cells[4].innerText = data.attendance.jam_keluar ?? '-';
            } else {
                let newRow = document.createElement("tr");
                newRow.classList.add("hover:bg-teal-100", "text-gray-800", "transition", "bg-white");
                newRow.setAttribute("data-id", data.attendance.id_attendance);
                newRow.innerHTML = `
                    <td class="px-4 py-2 border text-center">-</td>
                    <td class="px-4 py-2 border text-center">${data.attendance.tanggal}</td>
                    <td class="px-4 py-2 border text-center capitalize">${data.attendance.status}</td>
                    <td class="px-4 py-2 border text-center">${data.attendance.jam_masuk ?? '-'}</td>
                    <td class="px-4 py-2 border text-center">${data.attendance.jam_keluar ?? '-'}</td>
                    <td class="px-4 py-2 border text-center">
                        <button onclick="openDetailModal(data.attendance)" class="bg-sky-600 text-white px-3 py-1 rounded-md hover:bg-sky-700 transition">Detail</button>
                    </td>`;
                tableBody.prepend(newRow);
                Array.from(tableBody.rows).forEach((row, index) => {
                    row.cells[0].innerText = index + 1;
                });
            }
        });
    </script>
</body>

</html>
