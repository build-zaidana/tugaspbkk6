@extends('layouts.app')

@section('title', 'Profil Jurusan')

@section('content')
<section class="relative min-h-screen flex items-center overflow-hidden">

    <img src="{{ asset('images/bg-campus.png') }}" class="absolute inset-0 w-full h-full object-cover"></div>

    <div class="relative z-10 max-w-3xl mx-auto w-full px-8 pt-24 text-center">
        <h1 class="font-serif text-4xl sm:text-5xl font-semibold leading-tight mb-8">
            {{ $nama_departemen }}
        </h1>

        <p class="text-gray-200 leading-relaxed mb-6">
            {{ $deskripsi }}
        </p>
    </div>
</section>
@endsection
