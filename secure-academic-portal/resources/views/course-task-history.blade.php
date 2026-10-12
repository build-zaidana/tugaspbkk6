<section class="bg-white shadow-sm sm:rounded-lg p-6 text-gray-900" aria-labelledby="course-history-title">
    <span class="lab-eyebrow">Jejak belajar / terbaru lebih dulu</span>
    <h3 id="course-history-title" class="text-lg font-semibold">Riwayat Tugas Kuliah Saya</h3>
    <div class="mt-6 lab-timeline">
        @forelse ($courseTasks as $courseTask)
            <article>
                <h4 class="font-semibold">{{ $courseTask->judul }}</h4>
                <p class="mt-1 text-sm text-gray-600">{{ $courseTask->mata_kuliah }} · {{ $courseTask->tanggal_pengumpulan->format('d M Y') }}</p>
                @if ($courseTask->deskripsi)
                    <p class="mt-2 text-sm text-gray-700">{{ $courseTask->deskripsi }}</p>
                @endif
                @can('delete', $courseTask)
                    <form method="POST" action="{{ route('course-tasks.destroy', $courseTask) }}" class="mt-2" onsubmit="return confirm('Hapus riwayat tugas ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="min-h-11 text-sm text-red-600 hover:text-red-800 underline" aria-label="Hapus tugas {{ $courseTask->judul }}">Hapus tugas</button>
                    </form>
                @endcan
            </article>
        @empty
            <p class="text-sm text-gray-600">Belum ada riwayat tugas. Tambahkan tugas pertamamu di bawah.</p>
        @endforelse
    </div>

    <details class="mt-6 border-t pt-4" @if ($errors->hasAny(['judul', 'mata_kuliah', 'deskripsi', 'tanggal_pengumpulan'])) open @endif>
        <summary class="cursor-pointer min-h-11 text-sm font-semibold text-indigo-600">Tambah riwayat tugas</summary>
        <form method="POST" action="{{ route('course-tasks.store') }}" class="mt-4 space-y-4">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <x-input-label for="task-title" value="Judul tugas" />
                    <x-text-input id="task-title" name="judul" class="mt-1 block w-full" :value="old('judul')" required maxlength="150" />
                    <x-input-error class="mt-2" :messages="$errors->get('judul')" />
                </div>
                <div>
                    <x-input-label for="task-course" value="Mata kuliah" />
                    <x-text-input id="task-course" name="mata_kuliah" class="mt-1 block w-full" :value="old('mata_kuliah')" required maxlength="150" />
                    <x-input-error class="mt-2" :messages="$errors->get('mata_kuliah')" />
                </div>
                <div>
                    <x-input-label for="task-date" value="Tanggal pengumpulan" />
                    <x-text-input id="task-date" name="tanggal_pengumpulan" type="date" class="mt-1 block w-full" :value="old('tanggal_pengumpulan')" required />
                    <x-input-error class="mt-2" :messages="$errors->get('tanggal_pengumpulan')" />
                </div>
            </div>
            <div>
                <x-input-label for="task-description" value="Deskripsi (opsional)" />
                <textarea id="task-description" name="deskripsi" rows="3" maxlength="5000" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('deskripsi') }}</textarea>
                <x-input-error class="mt-2" :messages="$errors->get('deskripsi')" />
            </div>
            <x-primary-button>Simpan tugas</x-primary-button>
        </form>
    </details>
</section>
