<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ortu>
 */
class OrtuFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::factory()->create([
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => Hash::make('password'), 
        ]);

        $user->assignRole('ortu');

        return [
            'user_id' => $user->id,
            'nama' => $this->faker->name(),
            'pekerjaan' => $this->faker->word(),
            'jenis_kelamin' => $this->faker->randomElement(['Laki-laki', 'Perempuan']),
        ];
    }
}
