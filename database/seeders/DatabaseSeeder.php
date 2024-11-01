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
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // $role_siswa = Role::updateOrCreate(
        //     ['name' => 'siswa'],
        //     ['name' => 'siswa']
        // );
        // $permission_r_jurnal = Permission::updateOrCreate(
        //     ['name' => 'r_jurnal'],
        //     ['name' => 'r_jurnal']
        // );
        // $role_siswa->givePermissionTo($permission_r_jurnal);

        // ======>
        \App\Models\User::factory()->create([
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);
        // ======>

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

        // ======>
        \App\Models\TahunAjaran::factory()->create([
            'nama' => '2024/2025',
        ]);
        \App\Models\TahunAjaran::factory()->create([
            'nama' => '2025/2026',
        ]);
        \App\Models\TahunAjaran::factory()->create([
            'nama' => '2026/2027',
        ]);

        $this->call([
            AuthSeeder::class,
        ]);
        \App\Models\Pengaturan::factory()->count(1)->create();
        // ======>

        // \App\Models\Guru::factory()->count(10)->create();
        // \App\Models\BidangKeahlian::factory()->count(3)->create();
        // \App\Models\Jurusan::factory()->count(5)->create();
        // \App\Models\Kelas::factory()->count(5)->create();
        // \App\Models\Kota::factory()->count(5)->create();
        // \App\Models\Industri::factory()->count(10)->create();

        // ====== Buat data kuota industri
        // $industris = Industri::all();
        // $jurusans = Jurusan::all();
        // $jenisKelamin = ['Laki-laki', 'Perempuan'];
        // foreach ($industris as $industri) {
        //     foreach ($jenisKelamin as $kelamin) {
        //         foreach ($jurusans as $jurusan) {
        //             // $probabilitas = [0, 0, 0, 0, 0, 0, 0, 0, 1, 2];
        //             $probabilitas = [0, 0, 1, 2];
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
        // \App\Models\PilihanKota::factory()->count(50)->create();

        // \App\Models\Jurnal::factory()->count(100)->create();

        // // ======= capaian dan tujuran 
        // $faker = Faker::create();
        // $jurusans = Jurusan::all();

        // foreach ($jurusans as $jurusan) {
        //     // Generate antara 1 hingga 5 capaian untuk setiap jurusan
        //     $capaianCount = rand(1, 5);
        //     for ($i = 0; $i < $capaianCount; $i++) {
        //         // Buat capaian pembelajaran untuk jurusan ini
        //         $capaian = CapaianPembelajaran::create([
        //             'jurusan_id' => $jurusan->id,
        //             'nama' => $faker->sentence,
        //         ]);

        //         // Generate antara 1 hingga 3 tujuan untuk setiap capaian
        //         $tujuanCount = rand(1, 3);
        //         for ($j = 0; $j < $tujuanCount; $j++) {
        //             TujuanPembelajaran::create([
        //                 'capaian_pembelajaran_id' => $capaian->id,
        //                 'nama' => $faker->sentence . " " . $faker->sentence,
        //             ]);
        //         }
        //     }
        // }

        // // \App\Models\Monitoring::factory()->count(3)->create();
    }
}

// cara menjalankannya
// php artisan db:seed --class=NamaSeeder
// php artisan db:seed
