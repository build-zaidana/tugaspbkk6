@extends('layouts.app')

@section('title', 'Home — Angela Vania Sugiyono')

@section('content')
{{-- UC1.1: Melihat Showcase / About Me Author --}}
<section class="grid md:grid-cols-2 gap-8 items-center reveal">
    <div class="flex justify-center order-2 md:order-1">
        <img src="{{ asset($profile['photo']) }}" alt="Foto {{ $profile['name'] }}"
             class="w-48 md:w-60 rounded-xl border-4 border-brand-frame shadow-[4px_4px_0_rgba(122,59,71,0.4)] hover-lift">
    </div>

    <div class="order-1 md:order-2">
        <h1 class="font-script text-4xl md:text-5xl text-brand-pink-dark mb-1">About Me</h1>
        <p class="text-brand-frame font-semibold text-sm mb-4">{{ $profile['tagline'] }}</p>

        <div class="window-card">
            <div class="window-titlebar">
                <span class="dot" style="background:#ff5f57"></span>
                <span class="dot" style="background:#febc2e"></span>
                <span class="dot" style="background:#28c840"></span>
            </div>
            <p class="p-4 leading-relaxed text-sm">
                {{ $profile['about'] }}
            </p>
        </div>

        <a href="{{ route('resume.download') }}"
           class="inline-block mt-4 px-4 py-2 rounded-full bg-brand-pink-dark text-white text-sm font-bold shadow hover:bg-pink-800 transition-colors">
            ⬇ Download Resume
        </a>
    </div>
</section>

{{-- Education --}}
<section class="mt-16 reveal">
    <h2 class="font-script text-3xl md:text-4xl text-brand-pink-dark mb-4">Education</h2>
    <div class="grid md:grid-cols-2 gap-4">
        @foreach ($profile['education'] as $edu)
            <div class="window-card hover-lift">
                <div class="window-titlebar"><span class="dot" style="background:#ff5f57"></span></div>
                <div class="p-4">
                    <p class="font-bold text-brand-pink-dark text-sm">{{ $edu['school'] }}</p>
                    <p class="text-xs mt-0.5">{{ $edu['degree'] }}</p>
                    <p class="text-xs mt-1.5 text-brand-frame/80">{{ $edu['score'] }} · {{ $edu['period'] }}</p>
                </div>
            </div>
        @endforeach
    </div>
</section>

{{-- Skills --}}
<section class="mt-16 reveal">
    <h2 class="font-script text-3xl md:text-4xl text-brand-pink-dark mb-4">Skills</h2>
    <div class="window-card p-4">
        <p class="text-xs font-bold uppercase tracking-wide text-brand-pink-dark mb-2">Hard Skills</p>
        <div class="flex flex-wrap gap-1.5 mb-4">
            @foreach ($profile['hard_skills'] as $skill)
                <span class="font-tech text-[11px] bg-pink-100 text-brand-frame px-2.5 py-1 rounded-full">{{ $skill }}</span>
            @endforeach
        </div>
        <p class="text-xs font-bold uppercase tracking-wide text-brand-pink-dark mb-2">Soft Skills</p>
        <div class="flex flex-wrap gap-1.5">
            @foreach ($profile['soft_skills'] as $skill)
                <span class="font-tech text-[11px] bg-purple-100 text-brand-frame px-2.5 py-1 rounded-full">{{ $skill }}</span>
            @endforeach
        </div>
    </div>
</section>
@endsection
