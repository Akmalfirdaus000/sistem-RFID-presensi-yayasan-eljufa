@extends('layouts.kepala')

@section('title', 'List Pengguna')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-lg">
    <h1 class="text-2xl font-bold text-gray-700 mb-4">List Pengguna</h1>

    <!-- Form Pencarian -->
    <form method="GET" action="{{ route('kepala.pengguna.index') }}" class="mb-4 flex items-center gap-2">
        <input type="text" name="search" placeholder="Cari nama / email / jabatan..." value="{{ request('search') }}"
            class="w-full px-4 py-2 border rounded-md focus:ring focus:ring-blue-300">
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">Cari</button>
    </form>

    <!-- Tabel -->
    <div class="overflow-x-auto">
        <table class="w-full table-auto border-collapse border border-gray-200 shadow-sm">
            <thead class="bg-gray-100 text-gray-700 text-sm">
                <tr>
                    <th class="px-4 py-2 border">No</th>
                    <th class="px-4 py-2 border">Nama</th>
                    <th class="px-4 py-2 border">Email</th>
                    <th class="px-4 py-2 border">Jabatan</th>
                    <th class="px-4 py-2 border">Role</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $index => $user)
                    <tr class="hover:bg-green-50 text-sm text-center">
                        <td class="px-4 py-2 border">{{ $users->firstItem() + $index }}</td>
                        <td class="px-4 py-2 border">{{ $user->name }}</td>
                        <td class="px-4 py-2 border">{{ $user->email }}</td>
                        <td class="px-4 py-2 border">{{ $user->jabatan ?? '-' }}</td>
                        <td class="px-4 py-2 border capitalize">{{ $user->role }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-gray-500">Tidak ada data pengguna.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $users->withQueryString()->links('pagination::tailwind') }}
    </div>
</div>
@endsection
