@extends('dashboards.app')


@section('title', 'Senarai pengguna yang dibuang')
@section('subtitle', 'Sepintas lalu senarai kenderaan yang sedang didaftarkan')
    
@section('content')

    @livewire('user.revoked')

@endsection