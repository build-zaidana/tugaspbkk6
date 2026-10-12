@extends('layouts.app')

@section('title', 'Kalkulator')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-6">

        <div class="card shadow-sm">
            <div class="card-body text-center p-4">

                <h1 class="h3 fw-bold mb-4">
                    Kalkulator Laravel
                </h1>

                <div class="fs-4">
                    {{ $angka1 }}
                    {{ $simbol }}
                    {{ $angka2 }}
                    =
                    <strong>{{ $hasil }}</strong>
                </div>

            </div>
        </div>

    </div>
</div>

@endsection