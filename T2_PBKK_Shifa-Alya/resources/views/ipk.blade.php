@extends('layouts.app')

@section('title', 'Kalkulator IPK')

@section('content')

<div class="text-center py-4">
    <h1 class="fw-bold">Kalkulator IPK</h1>
    <p class="text-muted">
        Menghitung rata-rata IPK dua semester
    </p>
</div>

<div class="card shadow-sm mx-auto" style="max-width: 650px;">
    <div class="card-body p-5 text-center">

        <div class="row">

            <div class="col-md-6">
                <small class="text-muted">
                    IPK Semester 1
                </small>

                <h2 class="fw-bold text-primary">
                    {{ number_format($ipk1, 2) }}
                </h2>
            </div>

            <div class="col-md-6">
                <small class="text-muted">
                    IPK Semester 2
                </small>

                <h2 class="fw-bold text-primary">
                    {{ number_format($ipk2, 2) }}
                </h2>
            </div>

        </div>

        <hr class="my-4">

        <small class="text-muted">
            Rata-rata IPK
        </small>

        <h1 class="display-4 fw-bold text-primary">
            {{ number_format($rataRata, 2) }}
        </h1>

    </div>
</div>

@endsection