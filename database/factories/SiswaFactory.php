<?php

namespace Database\Factories;

use App\Models\Kelas;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Siswa>
 */
class SiswaFactory extends Factory
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
            'nis' => $this->faker->unique()->numerify('##########'), // 10 digit
            'nama' => $this->faker->name(),
            'jenis_kelamin' => $this->faker->randomElement(['Laki-laki', 'Perempuan']),
            'kelas_id' => Kelas::inRandomOrder()->first()->id,
            'username' => $this->faker->userName(),
            'password' => bcrypt('password'), // bisa diubah ke nilai yang diinginkan
        ];
    }
}
