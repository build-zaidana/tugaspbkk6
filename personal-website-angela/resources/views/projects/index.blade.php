@extends('layouts.app')

@section('title', 'Projects — Angela Vania Sugiyono')

@section('content')
{{-- UC3: Melihat Projects Pribadi Author --}}
<h1 class="font-script text-4xl md:text-5xl text-brand-pink-dark mb-6 reveal">Projects &amp; Experience</h1>

<div class="grid sm:grid-cols-2 gap-5">
    @foreach ($projects as $project)
        <a href="{{ route('projects.show', $project) }}" class="window-card block hover-lift reveal">
            <div class="window-titlebar">
                <span class="dot" style="background:#ff5f57"></span>
                <span class="dot" style="background:#febc2e"></span>
                <span class="dot" style="background:#28c840"></span>
            </div>
            @if ($project->image_path)
                <img src="{{ asset($project->image_path) }}" alt="{{ $project->title }}" class="w-full h-36 object-cover">
            @else
                <div class="w-full h-36 flex items-center justify-center bg-pink-50 text-brand-pink-dark font-script text-2xl">
                    {{ $project->title }}
                </div>
            @endif
            <div class="p-4">
                <span class="font-tech text-[10px] uppercase tracking-wide text-brand-pink">{{ $project->type === 'project' ? 'Project' : 'Experience' }} · {{ $project->year }}</span>
                <h2 class="text-base font-bold text-brand-pink-dark mt-1">{{ $project->title }}</h2>
                <p class="text-xs text-brand-frame/80">{{ $project->role }}</p>
                <p class="text-sm mt-2 line-clamp-3">{{ $project->summary }}</p>
            </div>
        </a>
    @endforeach
</div>
@endsection
