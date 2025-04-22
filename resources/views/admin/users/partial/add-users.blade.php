@extends('layouts.sidemin')

@section('content')
<div class="container mx-auto p-6">
    @include('components.alert')

    <h2 class="text-2xl font-bold mb-4">Tambah Pengguna</h2>

    <div class="bg-white shadow-md rounded-lg p-6">
        <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <label class="block mb-2">Nama</label>
            <input type="text" name="name" class="w-full p-2 border rounded mb-3" required>

            <label class="block mb-2">NIK</label>
            <input type="text" name="nik" class="w-full p-2 border rounded mb-3">

            <label class="block mb-2">Email</label>
            <input type="email" name="email" class="w-full p-2 border rounded mb-3" required>

            <label class="block mb-2">Jabatan</label>
            <input type="text" name="jabatan" class="w-full p-2 border rounded mb-3">

            <label class="block mb-2">RFID</label>
            <select name="id_rfid" class="w-full p-2 border rounded mb-3">
                <option value="">Pilih RFID</option>
                @foreach($availableRfids as $rfid)
                    <option value="{{ $rfid->id_rfid }}">{{ $rfid->id_rfid }}</option>
                @endforeach
            </select>

            <label class="block mb-2">Role</label>
            <select name="role" class="w-full p-2 border rounded mb-3">
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>

            <label class="block mb-2">Password</label>
            <input type="password" name="password" class="w-full p-2 border rounded mb-3" required>

            <label class="block mb-2">Foto Profil (Opsional)</label>
            <input type="file" name="photo" class="w-full p-2 border rounded mb-3">

            <div class="flex justify-end space-x-2">
                <a href="{{ route('admin.users.index') }}" class="px-4 py-2 bg-gray-400 text-white rounded">Batal</a>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection
