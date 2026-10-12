<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Sunting Proposal Proyek</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('projects.update', $project) }}">
                    @csrf
                    @method('PUT')
                    @include('projects._form')
                    <div class="mt-6 flex items-center gap-4">
                        <x-primary-button>Simpan</x-primary-button>
                        <a href="{{ route('dashboard') }}" class="text-sm text-gray-600 hover:text-gray-900">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
