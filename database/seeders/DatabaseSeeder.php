<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\CapaianPembelajaran;
use App\Models\Industri;
use App\Models\Jurusan;
use App\Models\KuotaIndustri;
use App\Models\TujuanPembelajaran;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // \App\Models\User::factory()->create([
        //     'name' => 'Admin',
        //     'email' => 'admin@gmail.com',
        //     'email_verified_at' => now(),
        //     'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        //     'remember_token' => Str::random(10),
        // ]);
        // \App\Models\User::factory()->create([
        //     'name' => 'Kabeng',
        //     'email' => 'kabeng@gmail.com',
        //     'email_verified_at' => now(),
        //     'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        //     'remember_token' => Str::random(10),
        // ]);
        // \App\Models\User::factory()->create([
        //     'name' => 'Wali Siswa',
        //     'email' => 'walisiswa@gmail.com',
        //     'email_verified_at' => now(),
        //     'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        //     'remember_token' => Str::random(10),
        // ]);
        // \App\Models\User::factory()->create([
        //     'name' => 'Siswa',
        //     'email' => 'siswa@gmail.com',
        //     'email_verified_at' => now(),
        //     'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        //     'remember_token' => Str::random(10),
        // ]);

        // // \App\Models\User::factory()->count(1)->create();
        // $this->call([
        //     AuthSeeder::class,
        // ]);
        // \App\Models\Pengaturan::factory()->count(1)->create();
        // // \App\Models\Ortu::factory()->count(5)->create();
        // \App\Models\Guru::factory()->count(200)->create();
        // \App\Models\BidangKeahlian::factory()->count(4)->create();
        // \App\Models\Jurusan::factory()->count(20)->create();
        // \App\Models\Kelas::factory()->count(30)->create();
        // \App\Models\Kota::factory()->count(20)->create();
        // \App\Models\Industri::factory()->count(400)->create();

        // // ====== Buat data kuota industri
        // $industris = Industri::all();
        // $jurusans = Jurusan::all();
        // $jenisKelamin = ['Laki-laki', 'Perempuan'];
        // foreach ($industris as $industri) {
        //     foreach ($jenisKelamin as $kelamin) {
        //         foreach ($jurusans as $jurusan) {
        //             $probabilitas = [0, 0, 0, 0, 0, 0, 0, 1, 2];
        //             $kuota = $probabilitas[array_rand($probabilitas)];
        //             KuotaIndustri::create([
        //                 'industri_id' => $industri->id,
        //                 'jenis_kelamin' => $kelamin,
        //                 'jurusan_id' => $jurusan->id,
        //                 'kuota' => $kuota, 
        //                 'created_at' => now(),
        //                 'updated_at' => now(),
        //             ]);
        //         }
        //     }
        // }

        // // ======= siswa dan pilihan kota
        // \App\Models\PilihanKota::factory()->count(2000)->create();

        // \App\Models\Monitoring::factory()->count(3)->create();
        // \App\Models\Jurnal::factory()->count(500000)->create();

        // ======= capaian dan tujuran 
        $faker = Faker::create();
        $jurusans = Jurusan::all();

        foreach ($jurusans as $jurusan) {
            // Generate antara 1 hingga 5 capaian untuk setiap jurusan
            $capaianCount = rand(1, 5);
            for ($i = 0; $i < $capaianCount; $i++) {
                // Buat capaian pembelajaran untuk jurusan ini
                $capaian = CapaianPembelajaran::create([
                    'jurusan_id' => $jurusan->id,
                    'nama' => $faker->sentence,
                ]);

                // Generate antara 1 hingga 3 tujuan untuk setiap capaian
                $tujuanCount = rand(1, 3);
                for ($j = 0; $j < $tujuanCount; $j++) {
                    TujuanPembelajaran::create([
                        'capaian_pembelajaran_id' => $capaian->id,
                        'nama' => $faker->sentence . " " . $faker->sentence,
                    ]);
                }
            }
        }

        
        // \App\Models\KuotaIndustri::factory()->create();

    }
}

// cara menjalankannya
// php artisan db:seed --class=NamaSeeder
// php artisan db:seed
