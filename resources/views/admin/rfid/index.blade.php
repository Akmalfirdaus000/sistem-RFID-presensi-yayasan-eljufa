@extends('layouts.sidemin')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">📡 Daftar RFID</h1>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded shadow mb-6">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex justify-end mb-4">
        <a href="{{ route('admin.rfid.add') }}" class="bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white px-5 py-2 rounded-xl shadow-lg transform hover:scale-105 transition duration-300">
            + Tambah RFID
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gradient-to-r from-gray-100 to-gray-200">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">No</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">ID RFID</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">RFID</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Pengguna</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @forelse($rfids as $index => $rfid)
                    <tr class="hover:bg-gray-50 transition duration-150">
                        <td class="px-6 py-4 text-sm text-gray-800 font-medium">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $rfid->id_rfid }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $rfid->rfid }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full
                                {{ $rfid->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ ucfirst($rfid->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-700">
                            {{ $rfid->user?->name ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-sm space-x-2">
                            <a href="{{ route('admin.rfid.edit', $rfid->id_rfid) }}"
                               class="text-indigo-600 hover:text-indigo-900 font-medium transition duration-200">Edit</a>
                            <form action="{{ route('admin.rfid.destroy', $rfid->id_rfid) }}" method="POST" class="inline-block"
                                  onsubmit="return confirm('Yakin ingin menghapus RFID ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 font-medium transition duration-200">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-6 text-center text-gray-500 text-sm">Belum ada data RFID.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
