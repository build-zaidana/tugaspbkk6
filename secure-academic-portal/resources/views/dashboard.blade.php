<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard Portofolio
            </h2>
            <a href="{{ route('projects.create') }}"
               class="lab-button">
                + Ajukan Proposal
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (session('status'))
                <div class="p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg">
                    {{ session('status') }}
                </div>
            @endif

            <section class="lab-hero" aria-labelledby="welcome-title">
                <span class="lab-eyebrow">Ruang akademik / {{ $user->role }}</span>
                <h1 id="welcome-title">Halo, {{ $user->name }}.</h1>
                <p class="mb-0">Setiap tugas adalah langkah baru. Simpan perjalanan belajarmu dan kembangkan ide Agentic AI berikutnya.</p>
            </section>
            <div class="lab-stats">
                <div class="lab-stat"><strong>{{ $courseTasks->count() }}</strong><span>Riwayat tugas kuliah</span></div>
                <div class="lab-stat"><strong>{{ $projects->count() }}</strong><span>Proposal Agentic AI</span></div>
            </div>
            <div class="bg-white shadow-sm sm:rounded-lg p-6 text-gray-900 lab-identity">
                <div class="lab-identity-heading">
                    <div class="lab-avatar" aria-hidden="true">{{ mb_strtoupper(mb_substr($user->name, 0, 1)) }}</div>
                    <div><span class="lab-eyebrow">Identitas akademik</span><h3 class="text-lg font-semibold">Profil Saya</h3></div>
                </div>
                <dl class="mt-3 grid grid-cols-1 sm:grid-cols-3 gap-4 text-sm">
                    <div><dt class="text-gray-500">Nama</dt><dd class="font-medium">{{ $user->name }}</dd></div>
                    <div><dt class="text-gray-500">{{ strtoupper($user->academicIdentifierField()) }}</dt><dd class="font-medium">{{ $user->{$user->academicIdentifierField()} ?? 'Belum diisi' }}</dd></div>
                    <div><dt class="text-gray-500">Departemen</dt><dd class="font-medium">{{ $user->department }}</dd></div>
                    <div><dt class="text-gray-500">Email</dt><dd class="font-medium">{{ $user->email }}</dd></div>
                    <div><dt class="text-gray-500">Peran</dt><dd class="font-medium capitalize">{{ $user->role }}</dd></div>
                </dl>
                @if ($user->bio)
                    <p class="mt-4 text-sm text-gray-700">{{ $user->bio }}</p>
                @endif
                <a href="{{ route('profile.edit') }}" class="mt-4 inline-block text-sm font-semibold text-indigo-600 hover:text-indigo-800">Edit profil</a>

                @can('kelola-nilai')
                    <a href="{{ route('admin.index') }}"
                       class="mt-4 inline-block text-sm font-semibold text-indigo-600 hover:text-indigo-800">
                        Buka panel input nilai proposal &rarr;
                    </a>
                @endcan
            </div>

            @include('course-task-history')

            <div class="bg-white shadow-sm sm:rounded-lg p-6 text-gray-900">
                <span class="lab-eyebrow">Dari gagasan menjadi rancangan</span>
                <h3 class="text-lg font-semibold">Rencana Proyek Agentic AI Saya</h3>
                <div class="lab-project-grid">
                    @forelse ($projects as $project)
                        <article class="lab-project">
                            <div class="flex flex-wrap items-start justify-between gap-2">
                                <div>
                                    <h4 class="font-semibold">{{ $project->judul }}</h4>
                                    <p class="text-xs text-gray-500">
                                        Tema: {{ $project->tema_agent }} &middot;
                                        Diajukan {{ $project->created_at->translatedFormat('d M Y H:i') }}
                                    </p>
                                </div>
                                <span class="text-sm px-2 py-1 rounded {{ $project->nilai === null ? 'bg-gray-100 text-gray-600' : 'bg-indigo-50 text-indigo-700' }}">
                                    Nilai: {{ $project->nilai ?? 'belum dinilai' }}
                                </span>
                            </div>
                            @if ($project->deskripsi)
                                <p class="mt-2 text-sm text-gray-700">{{ $project->deskripsi }}</p>
                            @endif
                            @if ($project->catatan_review)
                                <p class="mt-2 text-sm italic text-gray-600">Catatan reviewer: {{ $project->catatan_review }}</p>
                            @endif

                            <div class="mt-3 flex gap-4 text-sm">
                                @can('update', $project)
                                    <a href="{{ route('projects.edit', $project) }}" class="text-indigo-600 hover:text-indigo-800">Edit</a>
                                @endcan
                                @can('delete', $project)
                                    <form method="POST" action="{{ route('projects.destroy', $project) }}"
                                          onsubmit="return confirm('Hapus proposal ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800">Hapus</button>
                                    </form>
                                @endcan
                            </div>
                        </article>
                    @empty
                        <p class="mt-4 text-sm text-gray-500">Belum ada proposal. Ajukan ide proyek pertamamu!</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
