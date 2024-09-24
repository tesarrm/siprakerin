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
            'nama' => $this->faker->unique()->randomElement([
                'X', 
                'XI', 
                'XII', 
            ]),
            'tahun_ajaran' => "2024/2025",
            'jurusan_id' => \App\Models\Jurusan::inRandomOrder()->first()->id, 
            'klasifikasi' => $this->faker->randomElement(['A', 'B', 'C']),
            'guru_id' => \App\Models\Guru::inRandomOrder()->first()->id, 
        ];
    }
}