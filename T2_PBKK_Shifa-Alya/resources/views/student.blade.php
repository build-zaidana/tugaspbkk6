@extends('layouts.app')

@section('title', 'Profil Mahasiswa')

@section('content')

<div class="text-center py-4">
    <h1 class="fw-bold">Profil Mahasiswa</h1>
    <p class="text-muted">
        Detail mahasiswa berdasarkan NRP
    </p>
</div>

<div class="card shadow-sm mx-auto" style="max-width: 750px;">
    <div class="card-body p-5">

        <h2 class="h3 fw-bold mb-4">
            {{ $nama }}
        </h2>

        <div class="row g-4">

            <div class="col-md-6">
                <small class="text-muted">NRP</small>
                <h5>{{ $nrp }}</h5>
            </div>

            <div class="col-md-6">
                <small class="text-muted">Departemen</small>
                <h5>{{ $departemen }}</h5>
            </div>

            <div class="col-md-6">
                <small class="text-muted">Universitas</small>
                <h5>{{ $universitas }}</h5>
            </div>

            <div class="col-md-6">
                <small class="text-muted">Status</small>
                <h5>{{ $status }}</h5>
            </div>

            <div class="col-12">
                <small class="text-muted">Minat Akademik</small>
                <h5>{{ $minat }}</h5>
            </div>

        </div>

    </div>
</div>

@endsection