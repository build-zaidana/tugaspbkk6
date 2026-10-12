@extends('layouts.app')

@section('title', 'Collection — Angela Vania Sugiyono')

@section('content')
{{-- UC4: Melihat Personal Collection Author (achievements/sertifikat), dikelompokkan per tahun --}}
<h1 class="font-script text-4xl md:text-5xl text-brand-pink-dark mb-6 reveal">Achievements</h1>

@foreach ($achievements as $year => $items)
    <section class="mb-10 reveal">
        <h2 class="text-lg font-bold text-white/90 mb-3">{{ $year }}</h2>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach ($items as $item)
                <div class="window-card hover-lift">
                    <div class="window-titlebar">
                        <span class="dot" style="background:#ff5f57"></span>
                        <span class="dot" style="background:#febc2e"></span>
                        <span class="dot" style="background:#28c840"></span>
                    </div>
                    @if ($item->image_path)
                        <img src="{{ asset($item->image_path) }}" alt="{{ $item->title }}" class="w-full h-40 object-cover">
                    @else
                        <div class="w-full h-40 flex items-center justify-center bg-pink-50 text-brand-pink-dark text-3xl">🏆</div>
                    @endif
                    <div class="p-3.5">
                        @if ($item->rank)
                            <span class="font-tech text-[10px] font-bold bg-yellow-200 text-brand-frame px-2 py-0.5 rounded-full">{{ $item->rank }}</span>
                        @endif
                        <h3 class="font-bold text-brand-pink-dark text-sm mt-1.5">{{ $item->title }}</h3>
                        <p class="text-xs text-brand-frame/80">{{ $item->organizer }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endforeach
@endsection
