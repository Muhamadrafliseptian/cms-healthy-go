@extends('layouts.main')

@section('title', 'Halaman Tidak Ditemukan')

@section('content')
    <div class="text-center mt-5">
        <h1 class="display-4">404</h1>
        <p class="lead">Oops! Halaman yang kamu cari tidak ditemukan.</p>
        <a href="{{ route('dashboard') }}" class="btn btn-primary">Kembali ke Dashboard</a>
    </div>
@endsection
