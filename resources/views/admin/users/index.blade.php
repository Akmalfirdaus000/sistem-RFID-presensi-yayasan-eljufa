@extends('layouts.sidemin')
@section('content')
    @include('components.alert')

        @include('admin.users.partial.list-users')
    
@endsection