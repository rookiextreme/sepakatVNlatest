@extends('dashboards.app')


@section('title', 'Senarai Pengguna Yang Dikunci Akses')
@section('subtitle', 'Sepintas lalu senarai kenderaan yang sedang didaftarkan')
    

@section('content')

    @livewire('user.locked')

@endsection

