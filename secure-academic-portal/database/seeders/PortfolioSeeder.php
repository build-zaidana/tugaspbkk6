<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class PortfolioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (User::all() as $user) {
            if ($user->bio === null) {
                $user->update([
                    'bio' => $user->hasRole(User::ROLE_MAHASISWA)
                        ? 'Mahasiswa Teknik Informatika ITS yang mempelajari pengembangan aplikasi web, basis data, dan Agentic AI.'
                        : 'Pengajar dan pendamping proyek akademik di bidang pengembangan aplikasi web dan Agentic AI.',
                ]);
            }

            if ($user->email === 'mahasiswa@student.its.ac.id' && $user->nrp === null
                && ! User::where('nrp', '5025241151')->exists()) {
                $user->update(['nrp' => '5025241151']);
            }

            foreach ([
                ['judul' => 'Routing dan Blade Template', 'deskripsi' => 'Membangun halaman portofolio dengan route, controller, dan template Blade.', 'tanggal_pengumpulan' => '2026-09-21'],
                ['judul' => 'Middleware dan Autentikasi', 'deskripsi' => 'Mengimplementasikan login Breeze, middleware peran, Gate, dan Policy.', 'tanggal_pengumpulan' => '2026-10-05'],
                ['judul' => 'Migration, Eloquent, Factory dan Seeder', 'deskripsi' => 'Merancang relasi users dan projects, proteksi mass assignment, serta data dummy akademik.', 'tanggal_pengumpulan' => '2026-10-12'],
            ] as $task) {
                $user->courseTasks()->firstOrCreate(
                    ['judul' => $task['judul'], 'mata_kuliah' => 'Pemrograman Berbasis Kerangka Kerja'],
                    $task,
                );
            }
        }
    }
}
