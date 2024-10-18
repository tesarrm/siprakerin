<?php

namespace Database\Factories;

use App\Models\Kota;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Industri>
 */
class IndustriFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => $this->faker->name(),
            'alamat' => $this->faker->name(),
            'kota_id' => Kota::inRandomOrder()->first()->id,
            'tahun_ajaran' => '2024/2025',
            'tanggal_awal' => '11 Oktober 2024',
            'tanggal_akhir' => '31 Oktober 2024',
        ];
    }
}
