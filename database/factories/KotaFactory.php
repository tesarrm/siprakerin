<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Kota>
 */
class KotaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'nama' => $this->faker->city(),
            'biaya' => 'Rp 3.000.000',
            'keterangan' => $this->faker->randomElement([
                '', 
                '', 
                'Biaya akomodasi, mess, dan makan ditanggung industri', 
            ]),
        ];
    }
}
