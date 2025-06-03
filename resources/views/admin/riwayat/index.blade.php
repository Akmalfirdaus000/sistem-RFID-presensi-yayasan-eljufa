@extends('layouts.sidemin')

@section('content')
<div class="p-4">
    <div class="bg-gray-100 shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-4 text-gray-900">Riwayat Presensi</h2>

        <form method="GET" action="{{ route('admin.riwayat.index') }}" class="mb-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="search_name" class="block text-gray-700 font-bold mb-2">Nama Karyawan:</label>
                    <input type="text" name="search_name" id="search_name" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ request('search_name') }}">
                </div>
                <div>
                    <label for="start_date" class="block text-gray-700 font-bold mb-2">Tanggal Mulai:</label>
                    <input type="date" name="start_date" id="start_date" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ request('start_date') }}">
                </div>
                <div>
                    <label for="end_date" class="block text-gray-700 font-bold mb-2">Tanggal Selesai:</label>
                    <input type="date" name="end_date" id="end_date" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ request('end_date') }}">
                </div>
            </div>
            <div class="flex justify-end mt-4">  <!-- Atur tombol ke kanan -->
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Cari</button>
            </div>
        </form>


        <div class="overflow-x-auto">
    <div class="min-w-full">
        @php $i = 1; @endphp
        @forelse ($users as $user)
            @if ($user->attendances->isNotEmpty())
                <div class="mb-4 bg-white rounded-lg shadow-md p-4">
                    <h3 class="text-lg font-bold mb-2 text-gray-800">
                        {{ $i++ }}. {{ $user->name }}
                    </h3>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu Masuk</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu Keluar</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($user->attendances as $attendance)
                                <tr class="hover:bg-gray-100">
                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">{{ $attendance->tanggal }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">{{ $attendance->jam_masuk }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">{{ $attendance->jam_keluar }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap text-sm">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium
                                            @if ($attendance->status == 'Hadir') bg-green-100 text-green-800
                                            @elseif ($attendance->status == 'Tidak Hadir') bg-red-100 text-red-800
                                            @else bg-yellow-100 text-yellow-800 @endif">
                                            {{ $attendance->status }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        @empty
            <p class="text-gray-500 text-center">Tidak ada data presensi.</p>
        @endforelse
    </div>
</div>


        {{-- {{ $attendances->links() }} --}}
    </div>
</div>
@endsection
