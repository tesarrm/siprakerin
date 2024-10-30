<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pengaturan>
 */
class PengaturanFactory extends Factory
{
    public function definition(): array
    {
        return [
            'tahun_ajaran_id' => 1,
            'penilaian_2' => 'off',
        ];
    }
}
