<?php

namespace Database\Factories;

use App\Models\BidangKeahlian;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Jurusan>
 */
class JurusanFactory extends Factory
{
    public function definition(): array
    {
        // return [
        //     'nama' => $this->faker->unique()->randomElement([
        //         'Rekayasa Perangkat Lunak', 
        //         'Akuntansi', 
        //         'Keperawatan', 
        //         'Agribisnis Tanaman'
        //     ]),
        //     'singkatan' => $this->faker->unique()->randomElement([
        //         'RPL', 
        //         'AK', 
        //         'KN', 
        //         'AT'
        //     ]),
        //     // 'bidang_keahlian_id' => BidangKeahlian::factory(), // Relasi ke bidang_keahlian
        //     'bidang_keahlian_id' => BidangKeahlian::inRandomOrder()->first()->id,
        // ];

        return [
            'nama' => $this->faker->unique()->randomElement([
                'Rekayasa Perangkat Lunak', 
                'Akuntansi', 
                'Keperawatan', 
                'Agribisnis Tanaman',
                'Teknik Komputer dan Jaringan',
                'Multimedia',
                'Teknik Otomotif',
                'Teknik Elektro',
                'Teknik Mesin',
                'Teknik Sipil',
                'Perhotelan',
                'Pariwisata',
                'Desain Komunikasi Visual',
                'Teknik Konstruksi',
                'Pemasaran',
                'Administrasi Perkantoran',
                'Manajemen Bisnis',
                'Desain Interior',
                'Tata Boga',
                'Tata Busana'
            ]),
            'singkatan' => $this->faker->unique()->randomElement([
                'RPL', 
                'AK', 
                'KN', 
                'AT',
                'TKJ', 
                'MM', 
                'TO', 
                'TE', 
                'TM', 
                'TS', 
                'PH', 
                'PW', 
                'DKV', 
                'TK', 
                'PM', 
                'AP', 
                'MB', 
                'DI', 
                'TB', 
                'TBs'
            ]),
            'bidang_keahlian_id' => BidangKeahlian::inRandomOrder()->first()->id,
        ];

    }
}