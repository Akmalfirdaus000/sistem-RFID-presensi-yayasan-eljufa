@extends('layouts.sidemin')

@section('content')
    @include('components.alert')

<div class="container max-w-lg">
    <h1 class="text-xl font-bold mb-4">Tambah RFID Baru</h1>

    <form action="{{ route('admin.rfid.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label>ID RFID</label>
            <input type="text" name="id_rfid" class="w-full border p-2" value="{{ old('id_rfid') }}" required>
            @error('id_rfid') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <label>RFID</label>
            <input type="text" name="rfid" class="w-full border p-2" value="{{ old('rfid') }}" required>
            @error('rfid') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <label>Status</label>
            <select name="status" class="w-full border p-2" required>
                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
            </select>
            @error('status') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Simpan</button>
        <a href="{{ route('admin.rfid.index') }}" class="ml-2 text-gray-600 hover:underline">Batal</a>
    </form>
</div>
@endsection
