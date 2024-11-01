<?php

namespace Database\Factories;

use App\Models\Guru;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Kelas>
 */
class KelasFactory extends Factory
{

    public function definition(): array
    {
        $guru_id = \App\Models\Guru::inRandomOrder()->first()->id;
        $guru = Guru::with('user')->findOrFail($guru_id);
        $user = User::findOrFail($guru->user->id);
        $user->assignRole('wali_kelas');

        return [
            'nama' => $this->faker->randomElement([
                'X', 
                'XI', 
                'XII', 
            ]),
            'jurusan_id' => \App\Models\Jurusan::inRandomOrder()->first()->id, 
            'klasifikasi' => $this->faker->randomElement(['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J']),
            'guru_id' => \App\Models\Guru::inRandomOrder()->first()->id, 
        ];
    }
}