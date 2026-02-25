<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Unit;
use App\Models\Service;
use Carbon\Carbon;

class ReservationsTableSeeder extends Seeder
{
    public function run()
    {
        $users = User::all();
        $units = Unit::all();
        $services = Service::all();

        for ($i = 0; $i < 15; $i++) {
            $service = $services->random();

            $day = fake()->numberBetween(1, 28);
            $hour = fake()->numberBetween(8, 17);
            $minute = fake()->numberBetween(0, 59);

            $start = Carbon::create(2026, 2, $day, $hour, $minute);
            $end = (clone $start)->addMinutes($service->duration);

            Reservation::create([
                'user_id' => $users->random()->id,
                'unit_id' => $units->random()->id,
                'service_id' => $service->id,
                'start' => $start,
                'end' => $end,
                'status' => fake()->randomElement(['waiting', 'accepted', 'declined']),
            ]);
        }
    }
}
