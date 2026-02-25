<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Unit;
use App\Models\User;

class UnitsTableSeeder extends Seeder
{
    public function run()
    {
        for ($i = 0; $i < 5; $i++) {
            Unit::create([
                'name' => fake()->company(),
                'address' => fake()->address(),
                'email' => fake()->unique()->companyEmail(),
                'phone' => fake()->phoneNumber(),
                'coordinates' => fake()->latitude() . ',' . fake()->longitude(),
                'foreman_id' => null,
            ]);
        }
    }
}
