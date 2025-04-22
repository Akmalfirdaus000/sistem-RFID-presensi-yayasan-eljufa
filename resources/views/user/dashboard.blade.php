<!-- resources/views/dashboard.blade.php -->
@extends('layouts.app')

@section('content')
<div class=" bg-green-700 w-full h-16">    </div>

<div class="container mx-auto p-4 mt-12 md:mt-0  ">
    <!-- Komponen Jam Kerja -->
    @include('user.components.dashboard.work-time')
    @include('user.components.dashboard.quick-acces')
    @include('user.components.dashboard.recent-attendance')


</div>
@endsection