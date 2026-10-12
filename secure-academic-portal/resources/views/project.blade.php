@extends('layout')

@section('title', 'Proposal Agentic AI')

@section('content')
    <section class="lab-hero">
        <span class="lab-eyebrow">Eksplorasi / Agentic AI</span>
        <h1>Rencana Proyek Agentic AI</h1>
        @if ($portfolio)
            <p>Proposal milik {{ $portfolio->name }}. Dari ide menjadi rancangan solusi.</p>
        @endif
    </section>
    <div class="row g-3 mt-2 mb-5">
        @forelse ($projects as $project)
            <div class="col-md-6">
                <article class="card h-100">
                    <div class="card-body">
                        <span class="lab-tag">{{ $project->tema_agent }}</span>
                        <h2 class="h4">{{ $project->judul }}</h2>
                        <p class="text-secondary">Tema: {{ $project->tema_agent }} · {{ $project->created_at->format('d M Y') }}</p>
                        <p>{{ $project->deskripsi ?? 'Deskripsi belum diisi.' }}</p>
                    </div>
                </article>
            </div>
        @empty
            <p>Belum ada proposal proyek.</p>
        @endforelse
    </div>
@endsection
