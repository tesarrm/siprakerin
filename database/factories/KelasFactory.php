<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Kelas>
 */
class KelasFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nama' => $this->faker->word(),
            // 'tahun_ajaran' => $this->faker->year() . '/' . $this->faker->year(),
            'tahun_ajaran' => "2024/2025",
            'jurusan_id' => \App\Models\Jurusan::inRandomOrder()->first()->id, // Relasi ke jurusan
            'klasifikasi' => $this->faker->randomElement(['A', 'B', 'C']),
            'guru_id' => \App\Models\Guru::inRandomOrder()->first()->id, // Relasi ke guru
        ];
    }
}