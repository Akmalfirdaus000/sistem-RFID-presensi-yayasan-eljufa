@extends('layouts.sidemin')

@section('content')
<div class="container mx-auto ">
    @include('components.alert')

    <h2 class="text-2xl font-bold mb-4">Daftar Pengguna</h2>

    <!-- Tabel Users -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-100 border-b">
                    <th class="p-3">#</th>
                    <th class="p-3">Nama</th>
                    <th class="p-3">NIK</th>
                    <th class="p-3">Email</th>
                    <th class="p-3">Jabatan</th>
                    <th class="p-3">RFID</th>
                    <th class="p-3">Role</th>
                    <th class="p-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $index => $user)
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-3">{{ $index + 1 }}</td>
                    <td class="p-3">{{ $user->name }}</td>
                    <td class="p-3">{{ $user->nik ?? '-' }}</td>
                    <td class="p-3">{{ $user->email }}</td>
                    <td class="p-3">{{ $user->jabatan ?? '-' }}</td>
                    <td class="p-3">{{ $user->id_rfid ?? '-' }}</td>
                    <td class="p-3">
                        <span class="px-2 py-1 text-xs font-semibold rounded-full
                        {{ $user->role === 'admin' ? 'bg-green-200 text-green-800' : 'bg-blue-200 text-blue-800' }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td class="p-3 flex space-x-2">
                         <a href="{{ route('admin.users.show', $user->id) }}" class="px-3 py-1 bg-blue-500 text-white rounded-md">Detail</a>
                        <button onclick="openEditModal({{ json_encode($user) }})" class="px-3 py-1 bg-yellow-500 text-white rounded-md">Edit</button>
                        <button onclick="openDeleteModal('{{ $user->id }}')" class="px-3 py-1 bg-red-500 text-white rounded-md">Hapus</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Edit -->
<div id="editModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 hidden flex items-center justify-center">
    <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
        <h2 class="text-xl font-bold mb-4">Edit Pengguna</h2>
        <form id="editForm">
            @csrf
            <input type="hidden" id="editUserId">
            <label class="block mb-2">Nama</label>
            <input type="text" id="editName" class="w-full p-2 border rounded mb-3">

            <label class="block mb-2">NIK</label>
            <input type="text" id="editNIK" class="w-full p-2 border rounded mb-3">

            <label class="block mb-2">Email</label>
            <input type="email" id="editEmail" class="w-full p-2 border rounded mb-3">

            <label class="block mb-2">Jabatan</label>
            <input type="text" id="editJabatan" class="w-full p-2 border rounded mb-3">

            <label class="block mb-2">RFID</label>
            <select id="editRFID" class="w-full p-2 border rounded mb-3">
                <option value="">Pilih RFID</option>
                @foreach($availableRfids as $rfid)
                    <option value="{{ $rfid->id_rfid }}">{{ $rfid->id_rfid }}</option>
                @endforeach
            </select>

            <label class="block mb-2">Role</label>
            <select id="editRole" class="w-full p-2 border rounded mb-3">
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>

            <div class="flex justify-end space-x-2">
                <button type="button" onclick="closeEditModal()" class="px-4 py-2 bg-gray-400 text-white rounded">Batal</button>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Simpan</button>
            </div>
        </form>
    </div>
</div>
<!-- Modal Konfirmasi Hapus -->
<div id="deleteModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 hidden flex items-center justify-center">
    @include('components.alert')

    <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
        <h2 class="text-xl font-bold mb-4">Konfirmasi Hapus</h2>
        <p>Apakah Anda yakin ingin menghapus pengguna ini?</p>
        <input type="hidden" id="deleteUserId">
        <div class="flex justify-end space-x-2 mt-4">

            <button onclick="closeDeleteModal()" class="px-4 py-2 bg-gray-400 text-white rounded">Batal</button>
            <button onclick="deleteUser()" class="px-4 py-2 bg-red-500 text-white rounded">Hapus</button>
        </div>
    </div>
</div>

<script>
    function openDeleteModal(userId) {
        document.getElementById('deleteUserId').value = userId;
        document.getElementById('deleteModal').classList.remove('hidden');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }

    function deleteUser() {
        const userId = document.getElementById('deleteUserId').value;
        fetch(`/admin/users/${userId}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
        }).then(response => response.json()).then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Gagal menghapus pengguna.');
            }
        });
    }
</script>


<script>
    function openEditModal(user) {
        document.getElementById('editUserId').value = user.id;
        document.getElementById('editName').value = user.name;
        document.getElementById('editNIK').value = user.nik || '';
        document.getElementById('editEmail').value = user.email;
        document.getElementById('editJabatan').value = user.jabatan || '';
        document.getElementById('editRFID').value = user.id_rfid || '';
        document.getElementById('editRole').value = user.role;
        document.getElementById('editModal').classList.remove('hidden');
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
    }

    document.getElementById('editForm').addEventListener('submit', function (event) {
        event.preventDefault();
        const userId = document.getElementById('editUserId').value;

        fetch(`/admin/users/${userId}`, {
            method: 'PUT',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' },
            body: JSON.stringify({
                name: document.getElementById('editName').value,
                nik: document.getElementById('editNIK').value,
                email: document.getElementById('editEmail').value,
                jabatan: document.getElementById('editJabatan').value,
                id_rfid: document.getElementById('editRFID').value,
                role: document.getElementById('editRole').value,
            })
        }).then(response => response.ok && location.reload());
    });
</script>
@endsection
