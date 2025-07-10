@extends('layouts.app')

@section('content')
    <div class="bg-teal-800  w-full h-16 mb-6"></div>

    @include('components.alert')

    <div class="max-w-5xl mx-auto bg-white p-8 rounded-2xl shadow-xl border border-gray-200">
        <h1 class="text-3xl font-bold text-teal-800 mb-6">Profil Pengguna</h1>

        <!-- Grid Utama: Foto + Data -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8 items-center">
            <!-- Foto Profil -->
            <div class="flex justify-center md:justify-start">
                <img src="{{ asset($user->photo ?? 'images/default-profile.png') }}"
                     alt="Foto Profil"
                     class="w-32 h-32 rounded-full border-4 border-teal-300 shadow-lg object-cover">
            </div>

            <!-- Informasi User -->
            <div class="md:col-span-2 space-y-2 text-gray-700">
                <p><strong>Nama:</strong> {{ $user->name }}</p>
                <p><strong>NIK:</strong> {{ $user->nik ?? 'Belum terdaftar' }}</p>
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>Jabatan:</strong> {{ $user->jabatan ?? 'Belum ditentukan' }}</p>
                <p><strong>Role:</strong> {{ ucfirst($user->role) }}</p>
                <p><strong>RFID:</strong> {{ $user->id_rfid ?? 'Belum terdaftar' }}</p>
            </div>
        </div>

        <hr class="my-6 border-gray-300">

        <!-- Form-Form Pengaturan -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Form Ganti Nama -->
            <div class="bg-gray-50 p-5 rounded-lg shadow">
                <h2 class="text-lg font-semibold text-teal-800 mb-3">Ganti Nama</h2>
                <form action="{{ route('profile.change.name') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 font-medium">Nama Baru</label>
                        <input type="text" name="name" id="name" value="{{ $user->name }}"
                               class="w-full px-4 py-2 border rounded-md focus:ring focus:ring-teal-300 text-gray-800">
                        @error('name')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit"
                            class="w-full bg-teal-600 text-white py-2 px-4 rounded-md hover:bg-teal-700 transition">
                        Simpan Perubahan
                    </button>
                </form>
            </div>

            <!-- Form Ganti Password -->
            <div class="bg-gray-50 p-5 rounded-lg shadow">
                <h2 class="text-lg font-semibold text-teal-800 mb-3">Ganti Password</h2>
                <form action="{{ route('profile.change.password') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="old_password" class="block text-gray-700 font-medium">Password Lama</label>
                        <input type="password" name="old_password" id="old_password"
                               class="w-full px-4 py-2 border rounded-md focus:ring focus:ring-teal-300 text-gray-800">
                        @error('old_password')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="new_password" class="block text-gray-700 font-medium">Password Baru</label>
                        <input type="password" name="new_password" id="new_password"
                               class="w-full px-4 py-2 border rounded-md focus:ring focus:ring-teal-300 text-gray-800">
                        @error('new_password')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="new_password_confirmation" class="block text-gray-700 font-medium">Konfirmasi Password</label>
                        <input type="password" name="new_password_confirmation" id="new_password_confirmation"
                               class="w-full px-4 py-2 border rounded-md focus:ring focus:ring-teal-300 text-gray-800">
                        @error('new_password_confirmation')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                            class="w-full bg-green-600 text-white py-2 px-4 rounded-md hover:bg-green-700 transition">
                        Simpan Password Baru
                    </button>
                </form>
            </div>

            <!-- Form Ganti Foto Profil -->
            <div class="bg-gray-50 p-5 rounded-lg shadow md:col-span-2">
                <h2 class="text-lg font-semibold text-teal-800 mb-3">Ganti Foto Profil</h2>
                <form action="{{ route('profile.change.photo') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label for="foto" class="block text-gray-700 font-medium">Upload Foto Baru</label>
                        <input type="file" name="foto" id="foto"
                               class="w-full px-4 py-2 border rounded-md focus:ring focus:ring-teal-300 text-gray-800">
                        @error('foto')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit"
                            class="w-full bg-purple-600 text-white py-2 px-4 rounded-md hover:bg-purple-700 transition">
                        Perbarui Foto Profil
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
