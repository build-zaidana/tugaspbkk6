<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     * Semua akun memakai password: password
     */
    public function run(): void
    {
        // 1. Akun demo penguji (dosen) dengan portofolio siap pakai.
        $dosen = User::factory()->dosen()->create([
            'name' => 'Dosen PBKK',
            'email' => 'dosenpbkk@its.ac.id',
        ]);

        $dosen->projects()->createMany([
            [
                'judul' => 'Agentic Web Security Auditor',
                'deskripsi' => 'Aplikasi desktop berbasis Laravel, Livewire, dan NativePHP yang memakai LLM '
                    .'sebagai orchestration layer untuk memetakan attack surface, menjalankan security tools, '
                    .'dan menyusun rekomendasi remediation.',
                'tema_agent' => 'Ollama',
                'api_key_secure' => 'sk-demo-dosen-auditor',
            ],
            [
                'judul' => 'Asisten Penilaian Tugas Otomatis',
                'deskripsi' => 'Agent yang membaca repositori GitHub mahasiswa, menjalankan test, '
                    .'lalu memberi draf umpan balik sesuai rubrik.',
                'tema_agent' => 'LangChain',
                'api_key_secure' => 'sk-demo-dosen-grader',
            ],
        ]);

        // 2. Akun demo asisten dosen dan mahasiswa.
        User::factory()->asdos()->create([
            'name' => 'Asisten Dosen PBKK',
            'email' => 'asdospbkk@its.ac.id',
        ]);

        User::factory()
            ->has(Project::factory()->count(2))
            ->create([
                'name' => 'Mahasiswa Demo',
                'email' => 'mahasiswa@student.its.ac.id',
            ]);

        // 3. 15 mahasiswa acak, masing-masing memiliki 2 project dummy.
        User::factory()
            ->count(15)
            ->has(Project::factory()->count(2))
            ->create();
    }
}
