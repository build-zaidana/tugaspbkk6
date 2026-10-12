<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $projects = [
            [
                'title' => 'CLARITAS',
                'slug' => 'claritas',
                'role' => 'Chief of Product Officer',
                'year' => '2025 - Present',
                'type' => 'project',
                'summary' => 'Platform AI health-tech untuk skrining risiko Alzheimer melalui analisis linguistik.',
                'description' => "Product Overview: Platform AI-driven health-tech yang dirancang untuk membantu tenaga medis melakukan skrining risiko Alzheimer secara proaktif melalui analisis linguistik tingkat lanjut.\n\nProduct Strategy & Vision: Memimpin end-to-end product lifecycle dan membentuk visi produk inti agar solusi cognitive monitoring ini benar-benar menjawab tantangan nyata di dunia kesehatan.\n\nCross-Functional Leadership: Mengorkestrasi kolaborasi lintas tim riset, engineering, dan desain agar kemampuan model AI selaras dengan tujuan bisnis dan ekspektasi pengguna.\n\nBusiness Impact & Recognition: Berhasil membawa produk dari tahap konseptualisasi awal hingga prototype tervalidasi dengan dampak tinggi, meraih posisi Top 8 National Finalist di Hult Prize Indonesia 2026 dan pendanaan sebesar IDR 17.500.000 dari ITS Youth Technopreneur.",
                'image_path' => 'images/projects/claritas_mockup.png',
                'link' => null,
            ],
            [
                'title' => 'TAPPCOM (Tailor App Community)',
                'slug' => 'tappcom',
                'role' => 'Product Developer / UI-UX Designer',
                'year' => '2023',
                'type' => 'project',
                'summary' => 'Aplikasi Android untuk mendigitalisasi UMKM jasa tailor lokal.',
                'description' => "Product Overview: Aplikasi mobile yang dibangun untuk memberdayakan UMKM tailor lokal dengan mendigitalisasi layanan mereka, memperluas jangkauan pasar, dan meningkatkan citra digital mereka.\n\nDigital Transformation Strategy: Memelopori transisi bisnis tailor tradisional ke ekonomi digital dengan mengembangkan platform yang menjembatani praktik bisnis offline konvensional dan ekspektasi konsumen modern.\n\nSocio-Economic Impact: Memberikan solusi digital praktis yang secara langsung meningkatkan ketahanan ekonomi pengrajin lokal, memungkinkan mereka tetap relevan, profesional, dan kompetitif di pasar digital modern.",
                'image_path' => 'images/projects/tappcom_mockup.png',
                'link' => null,
            ],
            [
                'title' => 'Green Saldo',
                'slug' => 'green-saldo',
                'role' => 'Developer (Rumah Teknologi)',
                'year' => '2022 - 2023',
                'type' => 'project',
                'summary' => 'Aplikasi Android berbasis Kodular untuk isu pengelolaan sampah.',
                'description' => "Aplikasi fokus pada pengelolaan sampah melalui daur ulang dan penggunaan kembali, bertujuan mengendalikan jumlah sampah yang terus bertambah. Dikembangkan menggunakan Kodular sebagai bagian dari komunitas Rumah Teknologi yang berkolaborasi dengan pemerintah Kota Surakarta untuk mempercepat era Society 5.0. Aplikasi ini juga mendorong kolaborasi antar pemangku kepentingan, bekerja sama dengan UMKM untuk mengelola sampah menjadi produk yang bernilai dan layak jual.",
                'image_path' => null,
                'link' => null,
            ],
            [
                'title' => 'Operating Systems Teaching Assistant',
                'slug' => 'os-teaching-assistant',
                'role' => 'Teaching Assistant — ITS Surabaya',
                'year' => 'Mar 2026 - Present',
                'type' => 'experience',
                'summary' => 'Membimbing 80+ mahasiswa dalam praktikum OS fundamentals dan debugging C/C++.',
                'description' => "Memimpin sesi lab teknis tentang fundamental OS: Linux, Concurrency (IPC), Booting sequences, dan Filesystem in Userspace (FUSE).\n\nMelakukan code review teknis dalam C/C++, membimbing mahasiswa pada konsep low-level memory management dan debugging tingkat lanjut.\n\nMembimbing lebih dari 80 mahasiswa dalam sesi lab serta menyusun modul praktikum FUSE yang menantang pemahaman mahasiswa terhadap implementasi filesystem.",
                'image_path' => 'images/experience/exp_osta_camera.png',
                'link' => null,
            ],
            [
                'title' => 'Staff of Research & Technology — HMTC ITS',
                'slug' => 'staff-research-technology-hmtc',
                'role' => 'Staff Research and Technology',
                'year' => 'Mar 2026 - Present',
                'type' => 'experience',
                'summary' => 'Memimpin komunitas kompetitif Elite TC dan menyusun kurikulum riset Bluecamp.',
                'description' => "Bagian dari bureau khusus yang fokus meningkatkan ekosistem akademik dan kompetitif di jurusan Informatika melalui program ilmiah, pengembangan riset, dan manajemen komunitas teknis.\n\nMenjabat sebagai Project-in-Charge (PIC) untuk Elite TC Community, memimpin tim inti 15 mentor dan 5 volunteer untuk membangun lingkungan kompetitif berkinerja tinggi.\n\nMenjadi Project Lead untuk seminar departemen bertajuk 'Static and Dynamic Malware Analysis with Real Malware Samples from Honeypot'.\n\nMerancang Bluecamp Scientific Curriculum, pelatihan riset dan kompetisi komprehensif untuk lebih dari 80 mahasiswa baru.",
                'image_path' => 'images/experience/exp_rnt_camera.png',
                'link' => null,
            ],
            [
                'title' => 'Frontend Developer — ITS Nabu',
                'slug' => 'frontend-developer-its-nabu',
                'role' => 'Frontend Developer',
                'year' => 'Aug 2026 - Present',
                'type' => 'experience',
                'summary' => 'Mengembangkan sisi frontend untuk proyek ITS Nabu.',
                'description' => "Bergabung sebagai Frontend Developer di ITS Nabu, berkontribusi pada pengembangan antarmuka pengguna untuk proyek yang sedang berjalan.",
                'image_path' => null,
                'link' => null,
            ],
            [
                'title' => 'General Secretary — Youth Green Hackathon',
                'slug' => 'youth-green-hackathon',
                'role' => 'General Secretary of Administration',
                'year' => 'Apr 2025 - Jun 2025',
                'type' => 'experience',
                'summary' => 'Program keberlanjutan yang menjangkau 475 peserta webinar di Boyolali, Jawa Tengah.',
                'description' => "Program keberlanjutan yang digerakkan oleh pemuda untuk meningkatkan kesadaran soal green industry dan isu lingkungan, berhasil menjangkau 475 peserta webinar, menginkubasi 5 ide inovatif, dan mengeksekusi 90% target carbon offset & reforestasi.\n\nTerlibat dalam implementasi proyek yang mempromosikan peluang green industry di Boyolali, Jawa Tengah, didukung climate innovation grant sekitar USD 12.000 dari ChildFund International Indonesia. Berperan sebagai Sekretaris yang mengawasi tanggung jawab administratif sepanjang proyek berjalan, termasuk notulensi rapat, korespondensi resmi, dan laporan progres.",
                'image_path' => 'images/experience/exp_ygh_camera.png',
                'link' => 'https://instagram.com/youthgreen.hackathon',
            ],
        ];

        foreach ($projects as $project) {
            Project::updateOrCreate(['slug' => $project['slug']], $project);
        }
    }
}
