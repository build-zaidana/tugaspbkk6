<?php

namespace Database\Seeders;

use App\Models\Achievement;
use Illuminate\Database\Seeder;

class AchievementSeeder extends Seeder
{
    public function run(): void
    {
        $achievements = [
            ['title' => '3rd Place Winner — National Scientific Essay Competition', 'organizer' => 'Universitas Sebelas Maret (UNS)', 'year' => 2023, 'rank' => '3rd Winner', 'category' => 'competition', 'image_path' => 'images/achievements/ach_2023_nsec.png'],
            ['title' => 'Top 5 Finalist — National Essay Competition (LEN)', 'organizer' => 'Universitas Negeri Surabaya (UNESA)', 'year' => 2023, 'rank' => 'Top 5 Finalist', 'category' => 'competition', 'image_path' => 'images/achievements/ach_2023_unesa.png'],
            ['title' => 'Finalist — Scientific Festival', 'organizer' => 'Universitas Tidar', 'year' => 2023, 'rank' => 'Finalist', 'category' => 'competition', 'image_path' => 'images/achievements/ach_2023_tidar.png'],
            ['title' => 'Top 50 National Finalist — Digihack', 'organizer' => 'Digistar Club, Telkom Indonesia', 'year' => 2025, 'rank' => 'Top 50', 'category' => 'hackathon', 'image_path' => 'images/achievements/ach_2025_digihack.png'],
            ['title' => 'Top 10 National Finalist — Dinacom 11.0', 'organizer' => 'Dinacom App Competition', 'year' => 2025, 'rank' => 'Top 10', 'category' => 'hackathon', 'image_path' => 'images/achievements/ach_2025_dinacom.png'],
            ['title' => 'Top 8 National Finalist — Hult Prize Indonesia', 'organizer' => 'Hult Prize Indonesia National Summit', 'year' => 2026, 'rank' => 'Top 8', 'category' => 'competition', 'image_path' => 'images/achievements/ach_2026_hultprize.png'],
            ['title' => 'Finalist — BRIN AIDeaNation', 'organizer' => 'Badan Riset dan Inovasi Nasional (BRIN)', 'year' => 2026, 'rank' => 'Finalist', 'category' => 'competition', 'image_path' => null],
            ['title' => 'Semifinalist — Datathon RISTEK UI', 'organizer' => 'RISTEK Universitas Indonesia', 'year' => 2026, 'rank' => 'Semifinalist', 'category' => 'hackathon', 'image_path' => null],
        ];

        foreach ($achievements as $achievement) {
            Achievement::updateOrCreate(
                ['title' => $achievement['title'], 'year' => $achievement['year']],
                $achievement
            );
        }
    }
}
