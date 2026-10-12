@extends('layout')

@section('title', 'Tentang Profil')

@section('content')
    <section class="lab-hero"><span class="lab-eyebrow">Kenali / Profil akademik</span><h1>Tentang Profil Akademik</h1><p>Perjalanan belajar dimulai dari mengenal siapa yang ada di balik ide.</p></section>
    @if ($portfolio)
        <article class="card mt-4 lab-identity">
            <div class="card-body">
                <h2 class="h4">{{ $portfolio->name }}</h2>
                <p class="text-secondary">{{ $portfolio->department }} · Institut Teknologi Sepuluh Nopember</p>
                <p>{{ $portfolio->bio ?? 'Profil ini belum memiliki deskripsi.' }}</p>
                <a href="{{ route('home') }}" class="btn btn-outline-primary">Lihat riwayat tugas</a>
            </div>
        </article>
    @else
        <p>Portofolio belum tersedia.</p>
    @endif
@endsection
