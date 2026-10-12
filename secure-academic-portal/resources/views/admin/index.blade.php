<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Panel Dosen / Asisten &mdash; Tinjau Proposal</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (session('status'))
                <div class="p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg">
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-50 text-left text-gray-600">
                        <tr>
                            <th class="px-4 py-3">Judul</th>
                            <th class="px-4 py-3">Pengusul</th>
                            <th class="px-4 py-3">Tema</th>
                            <th class="px-4 py-3">Nilai</th>
                            <th class="px-4 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @foreach ($projects as $project)
                            <tr>
                                <td class="px-4 py-3">
                                    <div class="font-medium text-gray-900">{{ $project->judul }}</div>
                                    <div class="text-xs text-gray-500">{{ \Illuminate\Support\Str::limit($project->deskripsi, 90) }}</div>
                                </td>
                                <td class="px-4 py-3">{{ $project->user->name }}</td>
                                <td class="px-4 py-3">{{ $project->tema_agent }}</td>
                                <td class="px-4 py-3">{{ $project->nilai ?? '-' }}</td>
                                <td class="px-4 py-3">
                                    @can('kelola-nilai')
                                        <a href="{{ route('admin.nilai.edit', $project) }}"
                                           class="text-indigo-600 hover:text-indigo-800 font-semibold">Input Nilai</a>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{ $projects->links() }}
        </div>
    </div>
</x-app-layout>
