@extends('layouts.app')

@section('title', $project->title . ' — Angela Vania Sugiyono')

@section('content')
<a href="{{ route('projects.index') }}" class="text-sm font-bold text-brand-pink-dark hover:underline">&larr; Kembali ke Projects</a>

<div class="window-card mt-4 reveal">
    <div class="window-titlebar">
        <span class="dot" style="background:#ff5f57"></span>
        <span class="dot" style="background:#febc2e"></span>
        <span class="dot" style="background:#28c840"></span>
        <span class="ml-auto font-tech text-[11px] text-brand-frame/80">{{ $project->title }}</span>
    </div>

    @if ($project->image_path)
        <img src="{{ asset($project->image_path) }}" alt="{{ $project->title }}" class="w-full max-h-96 object-contain bg-white">
    @endif

    <div class="p-6">
        <span class="font-tech text-[10px] uppercase tracking-wide text-brand-pink">{{ $project->type === 'project' ? 'Project' : 'Experience' }} · {{ $project->year }}</span>
        <h1 class="text-2xl font-bold text-brand-pink-dark mt-1">{{ $project->title }}</h1>
        <p class="text-brand-frame font-semibold text-sm mb-4">{{ $project->role }}</p>

        <p class="whitespace-pre-line leading-relaxed text-sm">{{ $project->description }}</p>

        @if ($project->link)
            <a href="{{ $project->link }}" target="_blank" class="inline-block mt-5 px-4 py-2 rounded-full bg-brand-pink text-white font-bold text-xs hover:bg-pink-700 transition-colors">
                Kunjungi Link ↗
            </a>
        @endif
    </div>
</div>
@endsection
