<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard Portofolio
            </h2>
            <a href="{{ route('projects.create') }}"
               class="inline-flex items-center px-4 py-2 bg-gray-800 rounded-md text-xs font-semibold text-white uppercase tracking-widest hover:bg-gray-700">
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

            <div class="bg-white shadow-sm sm:rounded-lg p-6 text-gray-900">
                <h3 class="text-lg font-semibold">Profil Saya</h3>
                <dl class="mt-3 grid grid-cols-1 sm:grid-cols-3 gap-4 text-sm">
                    <div><dt class="text-gray-500">Nama</dt><dd class="font-medium">{{ $user->name }}</dd></div>
                    <div><dt class="text-gray-500">Email</dt><dd class="font-medium">{{ $user->email }}</dd></div>
                    <div><dt class="text-gray-500">Peran</dt><dd class="font-medium capitalize">{{ $user->role }}</dd></div>
                </dl>

                @can('kelola-nilai')
                    <a href="{{ route('admin.index') }}"
                       class="mt-4 inline-block text-sm font-semibold text-indigo-600 hover:text-indigo-800">
                        Buka panel input nilai proposal &rarr;
                    </a>
                @endcan
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg p-6 text-gray-900">
                <h3 class="text-lg font-semibold">Rencana Proyek Agentic AI Saya</h3>

                @forelse ($projects as $project)
                    <div class="mt-4 border-t pt-4">
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
                    </div>
                @empty
                    <p class="mt-4 text-sm text-gray-500">Belum ada proposal. Ajukan ide proyek pertamamu!</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
