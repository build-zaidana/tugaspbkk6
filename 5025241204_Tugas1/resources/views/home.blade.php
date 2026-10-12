@extends('layouts.app')

@section('title', 'Beranda - ' . $nama)

@section('content')
<section class="relative min-h-screen flex items-center overflow-hidden">

    <img src="{{ asset('images/bg-campus.png') }}" class="absolute inset-0 w-full h-full object-cover"></div>

    <div class="relative z-10 max-w-7xl mx-auto w-full px-8 pt-24">
        <h1 class="font-serif text-3xl sm:text-5xl md:text-6xl font-semibold mb-8 animate-typing overflow-hidden whitespace-nowrap border-r-3 border-r-white pr-5">
            Selamat Datang!
        </h1>

        <dl class="grid grid-cols-[110px_1fr] gap-y-1 text-sm sm:text-base mb-10 max-w-sm">
            <dt class="font-semibold">Nama</dt>
            <dd>: {{ $nama }}</dd>

            <dt class="font-semibold">NRP</dt>
            <dd>: {{ $nrp }}</dd>

            <dt class="font-semibold">Kelas</dt>
            <dd>: {{ $kelas }}</dd>

            <dt class="font-semibold">Kelompok</dt>
            <dd>: {{ $kelompok }}</dd>
        </dl>

        <a href="{{ route('project') }}"
           class="inline-block bg-white text-blue-900 font-semibold rounded-full px-6 py-3 text-sm hover:bg-gray-100 transition">
            Rencana Proyek
        </a>
    </div>
</section>
@endsection
