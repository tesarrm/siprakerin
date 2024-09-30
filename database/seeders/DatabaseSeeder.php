<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Industri;
use App\Models\Jurusan;
use App\Models\KuotaIndustri;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        \App\Models\User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);
        \App\Models\User::factory()->create([
            'name' => 'Kabeng',
            'email' => 'kabeng@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);
        \App\Models\User::factory()->create([
            'name' => 'Wali Siswa',
            'email' => 'walisiswa@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);
        \App\Models\User::factory()->create([
            'name' => 'Siswa',
            'email' => 'siswa@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);

        // \App\Models\User::factory()->count(1)->create();
        $this->call([
            AuthSeeder::class,
        ]);
        \App\Models\Guru::factory()->count(3)->create();
        \App\Models\Pengaturan::factory()->count(1)->create();
        \App\Models\BidangKeahlian::factory()->count(3)->create();
        \App\Models\Jurusan::factory()->count(3)->create();
        \App\Models\Kelas::factory()->count(3)->create();
        \App\Models\Kota::factory()->count(5)->create();
        \App\Models\Industri::factory()->count(5)->create();
        \App\Models\Ortu::factory()->count(5)->create();
        // \App\Models\Siswa::factory()->count(5)->create();
        // siswa dan pilihan kota
        \App\Models\PilihanKota::factory()->count(5)->create();
        \App\Models\Monitoring::factory()->count(3)->create();
        \App\Models\Jurnal::factory()->count(5)->create();
        // \App\Models\KuotaIndustri::factory()->create();

        // Buat data kuota industri
        // Ambil semua data industri dan jurusan
        $industris = Industri::all();
        $jurusans = Jurusan::all();
        
        // Tentukan jenis kelamin yang akan digunakan
        $jenisKelamin = ['Laki-laki', 'Perempuan'];

        // Loop melalui setiap industri, jenis kelamin, dan jurusan untuk menghasilkan data
        foreach ($industris as $industri) {
            foreach ($jenisKelamin as $kelamin) {
                foreach ($jurusans as $jurusan) {
                    KuotaIndustri::create([
                        'industri_id' => $industri->id,
                        'jenis_kelamin' => $kelamin,
                        'jurusan_id' => $jurusan->id,
                        'kuota' => rand(1, 10), 
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }

    }
}

// cara menjalankannya
// php artisan db:seed --class=NamaSeeder
// php artisan db:seed
