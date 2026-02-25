<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;

class ItemsTableSeeder extends Seeder
{
    public function run()
    {
        $categories = ['cloths', 'window_cleaners', 'ceramic_coat', 'polish', 'interior_cleaners', 'accessories'];
        $statuses = ['available', 'unavailable'];

        for ($i = 0; $i < 20; $i++) {
            Item::create([
                'name' => fake()->word(),
                'description' => fake()->sentence(),
                'price' => fake()->randomFloat(2, 5, 100),
                'category' => fake()->randomElement($categories),
                'status' => fake()->randomElement($statuses),
                'image' => 'https://picsum.photos/200/200?random=' . $i,
            ]);
        }
    }
}
