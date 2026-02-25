<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            UnitsTableSeeder::class,   // seedaj prvo poslovne jedinice
            UsersTableSeeder::class,   // seedaj korisnike nakon što units postoje
            ItemsTableSeeder::class,
            ServicesTableSeeder::class,
            ReservationsTableSeeder::class,
        ]);
    }
}
