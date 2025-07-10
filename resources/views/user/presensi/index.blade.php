<!-- resources/views/dashboard.blade.php -->
@extends('layouts.app')

@section('content')
<div class=" bg-teal-800 w-full h-16">    </div>
<div class="container mx-auto p-4">
    @include('user.components.dashboard.work-time')
    @include('user.components.presensi.list-presensi', ['attendances' => $attendances])
    @include('user.components.presensi.izin')







</div>
@endsection
