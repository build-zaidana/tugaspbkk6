{{-- <!DOCTYPE html>
<html>
    <head>
        <title>Selamat Datang</title>
    </head>

    <body>
        <div>
            <h1>
                Selamat datang di
                Departemen Teknik Informatika
            </h1>
            <p>
                Nama : {{ $nama }} <br> NRP : {{ $nrp }}
            </p>
        </div>
    </body>
</html> --}}

@extends('layout')

@section('title', 'Selamat Datang')

@section('content')
    <h1>
        Selamat datang di
        Departemen Teknik Informatika
    </h1>
    <p>
        Nama : {{ $nama }} <br> NRP : {{ $nrp }}
    </p>

    <div class="card mt-4">
        <div class="card-body">
            <h2 class="h5">Secure Academic Portal</h2>
            <p class="mb-2">Portal ini memiliki tiga area:</p>
            <ul>
                <li><strong>Area Publik</strong> &mdash; halaman sambutan dan info umum (bebas diakses).</li>
                <li><strong>Area Mahasiswa</strong> &mdash; mengisi rencana proyek kelompok Agentic AI (wajib login).</li>
                <li><strong>Area Dosen/Asisten</strong> &mdash; meninjau proposal dan mengisi nilai (khusus role dosen/asdos).</li>
            </ul>
            @auth
                <a href="{{ route('dashboard') }}" class="btn btn-primary">Buka Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                <a href="{{ route('register') }}" class="btn btn-outline-primary">Register</a>
            @endauth
        </div>
    </div>
@endsection


