@extends('layouts.kepala')

@section('title', 'Dashboard Kepala Sekolah')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold text-gray-700 mb-6">Laporan Harian</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-green-500 text-white p-4 rounded-lg shadow text-center">
            <h4 class="text-lg font-semibold">Hadir Hari Ini</h4>
            <p class="text-3xl font-bold">{{ $harian['hadir'] }}</p>
        </div>
        <div class="bg-red-500 text-white p-4 rounded-lg shadow text-center">
            <h4 class="text-lg font-semibold">Absen Hari Ini</h4>
            <p class="text-3xl font-bold">{{ $harian['absen'] }}</p>
        </div>
        <div class="bg-yellow-500 text-white p-4 rounded-lg shadow text-center">
            <h4 class="text-lg font-semibold">Izin Hari Ini</h4>
            <p class="text-3xl font-bold">{{ $harian['cuti'] }}</p>
        </div>
    </div>
</div>

<div class="bg-white p-6 rounded-lg shadow-md mt-6">
    <h2 class="text-2xl font-bold text-gray-700 mb-6">Laporan Bulanan ({{ \Carbon\Carbon::now()->translatedFormat('F Y') }})</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-green-600 text-white p-4 rounded-lg shadow text-center">
            <h4 class="text-lg font-semibold">Total Hadir</h4>
            <p class="text-3xl font-bold">{{ $bulanan['hadir'] ?? 0 }}</p>
        </div>
        <div class="bg-red-600 text-white p-4 rounded-lg shadow text-center">
            <h4 class="text-lg font-semibold">Total Absen</h4>
            <p class="text-3xl font-bold">{{ $bulanan['alpa'] ?? 0 }}</p>
        </div>
        <div class="bg-yellow-600 text-white p-4 rounded-lg shadow text-center">
            <h4 class="text-lg font-semibold">Total Cuti</h4>
            <p class="text-3xl font-bold">{{ $bulanan['izin'] ?? 0 }}</p>
        </div>
    </div>
</div>
@endsection
