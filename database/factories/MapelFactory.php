<?php

namespace Database\Factories;

use App\Models\Mapel;
use Illuminate\Database\Eloquent\Factories\Factory;

class MapelFactory extends Factory
{
    protected $model = Mapel::class;

    public function definition(): array
    {
        return [
            'nama_mapel' => $this->faker->randomElement([
                'Matematika', 
                'Bahasa Indonesia', 
                'Bahasa Inggris', 
                'Pemrograman Web', 
                'Basis Data'
            ]),
        ];
    }
}