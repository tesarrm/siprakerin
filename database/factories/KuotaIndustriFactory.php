<?php

namespace Database\Factories;

use App\Models\Industri;
use App\Models\Jurusan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\KuotaIndustri>
 */
class KuotaIndustriFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        // Ambil semua data industri dan jurusan
        $industris = Industri::all();
        $jurusans = Jurusan::all();
        
        // Tentukan jenis kelamin yang akan digunakan
        $jenisKelamin = ['Laki-laki', 'Perempuan'];

        $kuotaIndustri = [];

        // Loop melalui setiap industri, jenis kelamin, dan jurusan untuk menghasilkan data
        foreach ($industris as $industri) {
            foreach ($jenisKelamin as $kelamin) {
                foreach ($jurusans as $jurusan) {
                    $kuotaIndustri[] = [
                        'industri_id' => $industri->id,
                        'jenis_kelamin' => $kelamin,
                        'jurusan_id' => $jurusan->id,
                        'kuota' => $this->faker->numberBetween(10, 100), // Atur jumlah kuota sesuai kebutuhan
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
        }

        return $kuotaIndustri;
    }
}
