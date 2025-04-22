@extends('layouts.app')

@section('content')
    @include('user.components.dashboard.work-time')

    <div class="max-w-6xl mt-5 mx-auto p-6 bg-white shadow-lg rounded-lg">
        {{-- <h2 class="text-2xl font-bold text-gray-700 mb-4">Riwayat Presensi</h2> --}}

        {{-- Include Partial View untuk Menampilkan Data --}}
        @include('user.riwayat.partial.get')
    </div>
@endsection
