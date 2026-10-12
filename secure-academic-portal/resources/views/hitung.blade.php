{{-- <!DOCTYPE html>
<html>
    <head>
        <title>Kalkulator Dinamis</title>
    </head>


    <body>
        <div>
            <h1>
                Kalkulator Dinamis
            </h1>
            <p>
                Hasil dari {{$angka1}} {{$operasi}} {{$angka2}} adalah {{$hasil}}
            </p>
        </div>
    </body>
</html> --}}


@extends('layout')

@section('title', 'Kalkulator Dinamis')

@section('content')
    <h1>
        Kalkulator Dinamis
    </h1>
    <p>
        Hasil dari {{$angka1}} {{$operasi}} {{$angka2}} adalah {{$hasil}}
    </p>
@endsection
