<?php

namespace Database\Factories;

use App\Models\Guru;
use App\Models\Industri;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Monitoring>
 */
class MonitoringFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'guru_id' => Guru::inRandomOrder()->first()->id,
            'industri_id' => Industri::inRandomOrder()->first()->id,
            'tanggal' => '24 Oktober 2024', 
        ];
    }
}
