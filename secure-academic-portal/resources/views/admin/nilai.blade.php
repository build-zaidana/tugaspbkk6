<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Input Nilai Proposal</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="font-semibold text-lg">{{ $project->judul }}</h3>
                <p class="text-sm text-gray-500">Diajukan oleh {{ $project->user->name }} &middot; Tema {{ $project->tema_agent }}</p>
                @if ($project->deskripsi)
                    <p class="mt-3 text-sm text-gray-700">{{ $project->deskripsi }}</p>
                @endif

                <form method="POST" action="{{ route('admin.nilai.update', $project) }}" class="mt-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <x-input-label for="nilai" value="Nilai (0 - 100)" />
                        <x-text-input id="nilai" name="nilai" type="number" step="0.01" min="0" max="100"
                                      class="mt-1 block w-full" :value="old('nilai', $project->nilai)" required />
                        <x-input-error :messages="$errors->get('nilai')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="catatan_review" value="Catatan Review" />
                        <textarea id="catatan_review" name="catatan_review" rows="4"
                                  class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('catatan_review', $project->catatan_review) }}</textarea>
                        <x-input-error :messages="$errors->get('catatan_review')" class="mt-2" />
                    </div>

                    <div class="mt-6 flex items-center gap-4">
                        <x-primary-button>Simpan Nilai</x-primary-button>
                        <a href="{{ route('admin.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
