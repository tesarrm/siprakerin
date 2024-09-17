<?php

namespace Database\Factories;

use App\Models\BidangKeahlian;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BidangKeahlian>
 */
class BidangKeahlianFactory extends Factory
{
    protected $model = BidangKeahlian::class;

    public function definition(): array
    {
        return [
            'nama' => $this->faker->randomElement([
                'Teknologi Informasi dan Komunikasi', 
                'Bisnis dan Manajemen', 
                'Kesehatan', 
                'Pertanian'
            ]),
        ];
    }
}