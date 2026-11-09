{{-- Judul halaman admin + lencana peran pengguna yang sedang login. --}}
<div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
    <div>
        <h3 class="mb-0">{{ $title }}</h3>
        @isset($subtitle)
            <p class="text-body-secondary mb-0">{{ $subtitle }}</p>
        @endisset
    </div>
    <span class="badge fs-6 {{ auth()->user()->hasRole(\App\Models\User::ROLE_ADMIN) ? 'text-bg-danger' : 'text-bg-info' }}">
        <i class="bi bi-person-badge"></i> Login sebagai {{ auth()->user()->roleLabel() }}
    </span>
</div>
