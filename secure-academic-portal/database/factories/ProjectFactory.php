<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Project>
 */
class ProjectFactory extends Factory
{
    protected $model = Project::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $peran = fake()->randomElement([
            'Asisten Riset', 'Penjadwal Kuliah', 'Code Reviewer', 'Analis Keamanan Web',
            'Tutor Pemrograman', 'Pengelola Inventaris Lab', 'Perangkum Jurnal', 'Customer Service',
        ]);
        $domain = fake()->randomElement([
            'Mahasiswa Informatika ITS', 'UMKM Surabaya', 'Perpustakaan ITS',
            'Laboratorium Jaringan', 'Tim DevOps', 'Klinik Kampus',
        ]);
        $kemampuan = fake()->randomElements([
            'membaca dokumen PDF', 'memanggil REST API eksternal', 'menjalankan query SQL',
            'mencari referensi di web', 'menulis dan menguji kode', 'mengirim notifikasi email',
            'mengelola kalender', 'menganalisis log server',
        ], 3);

        return [
            'user_id' => User::factory(),
            'judul' => "Agent {$peran} untuk {$domain}",
            'deskripsi' => 'Agent otonom yang mampu '.implode(', ', $kemampuan)
                .'. '.fake()->sentence(12),
            'tema_agent' => fake()->randomElement(['Ollama', 'LangChain', 'CrewAI', 'AutoGen', 'LlamaIndex']),
            'api_key_secure' => 'sk-'.fake()->regexify('[A-Za-z0-9]{32}'),
            'created_at' => fake()->dateTimeBetween('-2 months'),
        ];
    }
}
