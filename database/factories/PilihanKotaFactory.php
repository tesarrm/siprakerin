<?php

namespace Database\Factories;

use App\Models\Kelas;
use App\Models\Kota;
use App\Models\Siswa;
use App\Models\User;
use App\Models\WaliSiswa;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PilihanKota>
 */
class PilihanKotaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $namaSiswa = $this->faker->name;

        $user = User::factory()->create([
            'name' => $namaSiswa, // Menggunakan nama siswa yang sama
            'email' => $this->faker->unique()->safeEmail,
            'password' => Hash::make('password'), 
        ]);

        $siswa = Siswa::factory()->create([
            'nis' => $this->faker->unique()->numerify('##########'), // 10 digit
            'jenis_kelamin' => $this->faker->randomElement(['Laki-laki', 'Perempuan']),
            'kelas_id' => Kelas::inRandomOrder()->first()->id,
            'user_id' => $user->id,
        ]);

        $kota1 = Kota::inRandomOrder()->first();
        $kota2 = Kota::inRandomOrder()->first();
        $kota3 = Kota::inRandomOrder()->first();
        // $kota2 = Kota::inRandomOrder()->where('id', '!=', $kota1->id)->first();
        // $kota3 = Kota::inRandomOrder()->whereNotIn('id', [$kota1->id, $kota2->id])->first();

        $user->assignRole('siswa');

        $user1 = User::factory()->create([
            'name' => $this->faker->name, // Menggunakan nama siswa yang sama
            'email' => $this->faker->unique()->safeEmail,
            'password' => Hash::make('password'), 
        ]);

        $walisiswa = WaliSiswa::factory()->create([
            'no_telp' => $this->faker->phoneNumber,
            'jenis_kelamin' => $this->faker->randomElement(['Laki-laki', 'Perempuan']),
            'user_id' => $user1->id,
            'siswa_id' => $siswa->id,
        ]);

        $user1->assignRole('wali_siswa');

        return [
            'siswa_id' => $siswa->id,
            'kota_id_1' => $kota1->id,
            'kota_id_2' => $kota2->id,
            'kota_id_3' => $kota3->id,
            'status' => 'on', 
        ];
    }
}
