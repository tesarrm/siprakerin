<?php

namespace Database\Factories;

use App\Models\Siswa;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Jurnal>
 */
class JurnalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'siswa_id' => Siswa::inRandomOrder()->first()->id,
            'tanggal_waktu' => $this->faker->date(),
            'kegiatan' => $this->faker->text(),
            'keterangan' => $this->faker->text(),
        ];
    }
}
