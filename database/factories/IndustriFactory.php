<?php

namespace Database\Factories;

use App\Models\Kota;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

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
        // Membuat nama siswa terlebih dahulu
        $namaSiswa = $this->faker->name;

        // Membuat user dengan nama yang sama
        $user = User::factory()->create([
            'name' => $namaSiswa, // Menggunakan nama siswa yang sama
            'email' => $this->faker->unique()->safeEmail,
            'password' => Hash::make('password'), 
        ]);

        return [
            'nama' => $namaSiswa,
            'alamat' => $this->faker->name(),
            'kota_id' => Kota::inRandomOrder()->first()->id,
            'tanggal_awal' => '11 Oktober 2024',
            'tanggal_akhir' => '31 Oktober 2024',
            'user_id' => $user->id,
        ];
    }
}
