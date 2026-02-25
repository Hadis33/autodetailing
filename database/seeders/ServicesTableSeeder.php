<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServicesTableSeeder extends Seeder
{
    public function run()
    {
        for ($i = 0; $i < 10; $i++) {
            Service::create([
                'name' => fake()->word() . ' Service',
                'description' => fake()->sentence(),
                'duration' => fake()->numberBetween(30, 180),
                'price' => fake()->randomFloat(2, 20, 200),
            ]);
        }
    }
}
