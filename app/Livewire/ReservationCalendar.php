<?php

namespace App\Livewire;

use Asantibanez\LivewireCalendar\LivewireCalendar;
use App\Models\Reservation;
use Illuminate\Support\Collection;

class ReservationCalendar extends LivewireCalendar
{
    public $selectedReservation = null;

    public function events($startDate = null, $endDate = null): Collection
    {
        $start = $startDate ?? $this->gridStartsAt;
        $end = $endDate ?? $this->gridEndsAt;

        $reservations = Reservation::with(['service', 'user', 'unit'])
            ->where('status', 'accepted')
            ->where(function ($query) use ($start, $end) {
                $query->whereBetween('start', [$start, $end])
                    ->orWhereBetween('end', [$start, $end])
                    ->orWhere(function ($q) use ($start, $end) {
                        $q->where('start', '<=', $start)
                            ->where('end', '>=', $end);
                    });
            })
            ->get();

        $events = [];

        foreach ($reservations as $reservation) {

            $period = \Carbon\CarbonPeriod::create($reservation->start->startOfDay(), $reservation->end->startOfDay());

            foreach ($period as $date) {
                $events[] = [
                    'id' => $reservation->id,
                    'title' => $reservation->service->name,
                    'description' => $reservation->user->firstname . ' ' . $reservation->user->lastname,
                    'date' => $date,
                    'startsAt' => $reservation->start,
                    'endsAt' => $reservation->end,
                ];
            }
        }

        return collect($events);
    }

    public function onEventClick($eventId)
    {
        $this->dispatch('openReservationModal', ['eventId' => $eventId]);
    }
}
