<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        \App\Models\Guru::factory()->count(10)->create();
        \App\Models\Pengaturan::factory()->count(1)->create();
        \App\Models\BidangKeahlian::factory()->count(3)->create();
        \App\Models\Jurusan::factory()->count(3)->create();
        \App\Models\Kelas::factory()->count(15)->create();
        \App\Models\Kota::factory()->count(10)->create();
        \App\Models\Industri::factory()->count(10)->create();
        \App\Models\Siswa::factory()->count(10)->create();
    }
}

// cara menjalankannya
// php artisan db:seed --class=NamaSeeder
// php artisan db:seed
