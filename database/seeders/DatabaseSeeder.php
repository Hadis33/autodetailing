<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            UnitsTableSeeder::class,
            UsersTableSeeder::class,
            ItemsTableSeeder::class,
            ServicesTableSeeder::class,
            ReservationsTableSeeder::class,
        ]);
    }
}
