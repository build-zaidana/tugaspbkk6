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
@endsection


