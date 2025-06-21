@extends('layouts.app')

@section('content')
<div class=" bg-green-700 w-full h-16">    </div>

    @include('components.alert')

    <div class="max-w-3xl mx-auto bg-white p-6  rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold text-gray-700 mb-4">Halaman Profil</h1>

        <!-- Informasi Data User -->
        <div class="flex items-center space-x-6">
            <!-- Foto Profil -->
           <img src="{{ asset($user->photo ?? 'images/default-profile.png') }}"
     alt="Foto Profil"
     class="w-24 h-24 rounded-full border-4 border-gray-300 shadow-lg">

            <!-- Data User -->
            <div class="text-gray-700">
                <p><strong>Nama:</strong> {{ $user->name }}</p>
                <p><strong>NIK:</strong> {{ $user->nik ?? 'Belum terdaftar' }}</p>
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>Jabatan:</strong> {{ $user->jabatan ?? 'Belum ditentukan' }}</p>
                <p><strong>Role:</strong> {{ ucfirst($user->role) }}</p>
                <p><strong>RFID:</strong> {{ $user->id_rfid ?? 'Belum terdaftar' }}</p>
            </div>
        </div>

        <hr class="my-4 border-gray-300">

        <!-- Form Edit Nama User -->
        <h2 class="text-lg font-semibold text-gray-800 mb-2">Ganti Nama</h2>
        <form action="{{ route('profile.change.name') }}" method="POST" class="mb-6">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-medium">Nama</label>
                <input type="text" name="name" id="name" value="{{ $user->name }}"
                    class="w-full px-4 py-2 border rounded-md focus:ring focus:ring-blue-300 text-gray-800">
                @error('name')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit"
                class="w-full bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 transition">
                Ubah Nama
            </button>
        </form>

        <hr class="my-4 border-gray-300">

        <!-- Form Ganti Password -->
        <h2 class="text-lg font-semibold text-gray-800 mb-2">Ganti Password</h2>
        <form action="{{ route('profile.change.password') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="old_password" class="block text-gray-700 font-medium">Password Lama</label>
                <input type="password" name="old_password" id="old_password"
                    class="w-full px-4 py-2 border rounded-md focus:ring focus:ring-blue-300 text-gray-800">
                @error('old_password')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="new_password" class="block text-gray-700 font-medium">Password Baru</label>
                <input type="password" name="new_password" id="new_password"
                    class="w-full px-4 py-2 border rounded-md focus:ring focus:ring-blue-300 text-gray-800">
                @error('new_password')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="new_password_confirmation" class="block text-gray-700 font-medium">Ulangi Password Baru</label>
                <input type="password" name="new_password_confirmation" id="new_password_confirmation"
                    class="w-full px-4 py-2 border rounded-md focus:ring focus:ring-blue-300 text-gray-800">
                @error('new_password_confirmation')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                class="w-full bg-green-500 text-white py-2 px-4 rounded-md hover:bg-green-600 transition">
                Ubah Password
            </button>
        </form>

        <hr class="my-4 border-gray-300">

        <!-- Form Edit RFID -->
        {{-- <h2 class="text-lg font-semibold text-gray-800 mb-2">Perbarui RFID</h2>
        <form action="{{ route('profile.change.rfid') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="rfid" class="block text-gray-700 font-medium">Nomor RFID</label>
                <input type="text" name="rfid" id="rfid" value="{{ $user->rfid }}"
                    class="w-full px-4 py-2 border rounded-md focus:ring focus:ring-blue-300 text-gray-800">
                @error('rfid')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit"
                class="w-full bg-yellow-500 text-white py-2 px-4 rounded-md hover:bg-yellow-600 transition">
                Ubah RFID
            </button>
        </form> --}}

        <hr class="my-4 border-gray-300">

        <!-- Form Upload Foto -->
        <h2 class="text-lg font-semibold text-gray-800 mb-2">Ganti Foto Profil</h2>
       <form action="{{ route('profile.change.photo') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-4">
        <label for="foto" class="block text-gray-700 font-medium">Unggah Foto</label>
        <input type="file" name="foto" id="foto" class="w-full px-4 py-2 border rounded-md focus:ring focus:ring-blue-300 text-gray-800">
        @error('foto')
            <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror
    </div>
    <button type="submit" class="w-full bg-purple-500 text-white py-2 px-4 rounded-md hover:bg-purple-600 transition">
        Ubah Foto Profil
    </button>
</form>

    </div>
@endsection
