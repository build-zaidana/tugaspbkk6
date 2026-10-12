@extends('layout')

@section('title', 'Portofolio Akademik')

@section('content')
    <section class="lab-hero" aria-labelledby="portal-title">
        <span class="lab-eyebrow">Academic Lab / Portofolio</span>
        <h1 id="portal-title">Secure Academic Portal</h1>
        <p>Jejak belajar, ide yang tumbuh.<br>Profil akademik, riwayat tugas kuliah, dan proposal Agentic AI dalam satu ruang.</p>
        <div class="lab-hero-actions">
            @auth
                <a href="{{ route('dashboard') }}" class="lab-button">Buka Dashboard &rarr;</a>
            @else
                <a href="{{ route('login') }}" class="lab-button">Masuk ke portal &rarr;</a>
            @endauth
            <a href="{{ route('project-idea') }}" class="lab-hero-link">Jelajahi ide proyek</a>
        </div>
    </section>
    <div class="lab-stats">
        <div class="lab-stat"><strong>{{ $courseTasks->count() }}</strong><span>Tugas dalam portofolio</span></div>
        <div class="lab-stat"><strong>AI</strong><span>Ruang eksplorasi Agentic AI</span></div>
    </div>
    <section class="card lab-identity" aria-labelledby="profile-title">
        <div class="card-body">
            <div class="lab-identity-heading">
                <div class="lab-avatar" aria-hidden="true">{{ $portfolio ? mb_strtoupper(mb_substr($portfolio->name, 0, 1)) : 'A' }}</div>
                <div><span class="lab-eyebrow">Identitas akademik</span><h2 id="profile-title">Portofolio Akademik</h2></div>
            </div>
            @if ($portfolio)
                <dl class="row mb-0">
                    <dt class="col-sm-3">Nama</dt><dd class="col-sm-9">{{ $portfolio->name }}</dd>
                    <dt class="col-sm-3">{{ strtoupper($portfolio->academicIdentifierField()) }}</dt><dd class="col-sm-9">{{ $portfolio->{$portfolio->academicIdentifierField()} ?? 'Belum diisi' }}</dd>
                    <dt class="col-sm-3">Departemen</dt><dd class="col-sm-9">{{ $portfolio->department }}</dd>
                </dl>
                @if ($portfolio->bio)
                    <p class="mt-3">{{ $portfolio->bio }}</p>
                @endif
                <a href="{{ route('project-idea') }}" class="btn btn-outline-primary">Lihat proposal proyek &rarr;</a>
            @else
                <p>Portofolio belum tersedia.</p>
            @endif
        </div>
    </section>
    <section aria-labelledby="history-title">
        <div class="lab-section-heading"><h2 id="history-title">Riwayat Tugas Kuliah</h2><small>Terbaru lebih dulu</small></div>
        <div class="lab-panel">
            <div class="lab-timeline">
                @forelse ($courseTasks as $courseTask)
                    <article>
                        <p class="lab-meta">{{ $courseTask->tanggal_pengumpulan->format('d M Y') }} &middot; {{ $courseTask->mata_kuliah }}</p>
                        <h3>{{ $courseTask->judul }}</h3>
                        @if ($courseTask->deskripsi)
                            <p class="mb-0">{{ $courseTask->deskripsi }}</p>
                        @endif
                    </article>
                @empty
                    <p>Belum ada riwayat tugas kuliah.</p>
                @endforelse
            </div>
        </div>
    </section>
@endsection
