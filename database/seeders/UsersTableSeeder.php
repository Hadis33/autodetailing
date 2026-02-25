<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Unit;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $units = Unit::all();

        // Specifični admin user
        User::create([
            'firstname' => 'Hadis',
            'lastname' => 'Mahmutović',
            'email' => 'hadis@test.com',
            'phone' => '066677627',
            'password' => Hash::make('test1234'),
            'role' => 'admin',
            'unit_id' => null,
        ]);

        for ($i = 0; $i < 10; $i++) {
            $role = fake()->randomElement(['employee', 'foreman', 'client']);

            User::create([
                'firstname' => fake()->firstName(),
                'lastname' => fake()->lastName(),
                'email' => fake()->unique()->safeEmail(),
                'phone' => fake()->phoneNumber(),
                'password' => Hash::make('password'),
                'role' => $role,
                'unit_id' => in_array($role, ['employee', 'foreman']) ? $units->random()->id : null,
            ]);
        }

        // Svakom unit-u dodijelimo jednog foremana iz onih koji imaju role 'foreman'
        foreach ($units as $unit) {
            $foreman = User::where('role', 'foreman')->whereNotNull('unit_id')->inRandomOrder()->first();
            if ($foreman) {
                $unit->foreman_id = $foreman->id;
                $unit->save();
            }
        }
    }
}
