<?php

namespace Database\Factories;

use App\Models\CourseTask;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CourseTask>
 */
class CourseTaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'judul' => fake()->randomElement(['Implementasi autentikasi', 'Perancangan basis data', 'Laporan pengujian', 'Analisis algoritma']),
            'mata_kuliah' => fake()->randomElement(['Pemrograman Berbasis Kerangka Kerja', 'Basis Data', 'Pemrograman Web', 'Analisis dan Desain Algoritma']),
            'deskripsi' => fake()->paragraph(),
            'tanggal_pengumpulan' => fake()->dateTimeBetween('-2 months', 'now')->format('Y-m-d'),
        ];
    }
}
