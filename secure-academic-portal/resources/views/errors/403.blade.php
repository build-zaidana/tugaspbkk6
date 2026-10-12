@extends('layout')

@section('title', 'Akses Ditolak')

@section('content')
    <div class="alert alert-danger">
        <h1 class="h4">403 &mdash; Akses Ditolak</h1>
        <p class="mb-0">{{ $exception->getMessage() ?: 'Anda tidak memiliki izin untuk membuka halaman ini.' }}</p>
    </div>
    <a href="{{ auth()->check() ? route('dashboard') : route('home') }}" class="btn btn-secondary">Kembali</a>
@endsection
