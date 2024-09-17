<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Guru>
 */
class GuruFactory extends Factory
{
    public function definition(): array
    {
        return [
            // 'gambar' => $this->faker->imageUrl(),
            'nip' => $this->faker->unique()->numerify('##########'), // 10 digit
            'nama_guru' => $this->faker->name(),
            'jenis_kelamin' => $this->faker->randomElement(['Laki-laki', 'Perempuan']),
            'peran' => $this->faker->randomElement(['Admin', 'Kepala Bengkel', 'Guru']),
            'wali_kelas' => $this->faker->word(),
            'username' => $this->faker->userName(),
            'password' => bcrypt('password'), // bisa diubah ke nilai yang diinginkan
        ];
    }
}