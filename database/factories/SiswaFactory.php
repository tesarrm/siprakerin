<?php

namespace Database\Factories;

use App\Models\Kelas;
use App\Models\Kota;
use App\Models\PilihanKota;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

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
        // Membuat nama siswa terlebih dahulu
        $namaSiswa = $this->faker->name;

        // Membuat user dengan nama yang sama
        $user = User::factory()->create([
            'name' => $namaSiswa, // Menggunakan nama siswa yang sama
            'email' => $this->faker->unique()->safeEmail,
            'password' => Hash::make('password'), 
        ]);

        // Memberikan peran 'siswa' kepada user
        $user->assignRole('siswa');

        // Mengembalikan data siswa dengan user_id yang sesuai
        return [
            'nis' => $this->faker->unique()->numerify('##########'), // 10 digit
            'nama_lengkap' => $namaSiswa, // Nama siswa yang sama dengan nama user
            'jenis_kelamin' => $this->faker->randomElement(['Laki-laki', 'Perempuan']),
            'kelas_id' => Kelas::inRandomOrder()->first()->id,
            'user_id' => $user->id,
        ];


        // Memilih tiga kota secara acak dari tabel kotas
        $kota1 = Kota::inRandomOrder()->first();
        $kota2 = Kota::inRandomOrder()->first();
        $kota3 = Kota::inRandomOrder()->first();
        // $kota2 = Kota::inRandomOrder()->where('id', '!=', $kota1->id)->first();
        // $kota3 = Kota::inRandomOrder()->whereNotIn('id', [$kota1->id, $kota2->id])->first();

        // Mengisi data pilihan kota
        PilihanKota::create([
            'siswa_id' => $siswa->id,
            'kota_id_1' => $kota1->id,
            'kota_id_2' => $kota2->id,
            'kota_id_3' => $kota3->id,
            'status' => 'proses', // Status default
        ]);

        
    }
}
