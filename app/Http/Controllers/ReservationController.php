<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Service;
use App\Models\Unit;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function create()
    {
        return view('reservations.add', [
            'units' => Unit::all(),
            'services' => Service::all(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'unit_id' => ['required', 'exists:units,id'],
            'service_id' => ['required', 'exists:services,id'],
            'start' => ['required', 'date'],
        ]);

        $service = Service::findOrFail($request->service_id);

        $start = Carbon::parse($request->start);

        $end = $start->copy()->addMinutes($service->duration);

        Reservation::create([
            'user_id' => auth()->id(),
            'unit_id' => $request->unit_id,
            'service_id' => $request->service_id,
            'start' => $start,
            'end' => $end,
            'status' => 'waiting',
        ]);

        return redirect()
            ->route('dashboard')
            ->with('success', 'Rezervacija je uspješno poslana.');
    }
}
