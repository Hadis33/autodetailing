<?php

namespace App\Livewire\Dashboard;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Rankings extends Component
{
    public int $days = 30;

    public array $topUnits = [];
    public array $topForemen = [];

    public function mount(?int $days = null): void
    {
        if ($days !== null) {
            $this->days = $days;
        }

        $this->loadRankings();
    }

    public function loadRankings(): void
    {
        $from = Carbon::now()->subDays($this->days);

        $this->topUnits = $this->getTopUnits($from);
        $this->topForemen = $this->getTopForemen($from);
    }

    private function getTopUnits(Carbon $from): array
    {
        $rows = DB::table('reservations')
            ->join('units', 'units.id', '=', 'reservations.unit_id')
            ->join('services', 'services.id', '=', 'reservations.service_id')
            ->select(
                'units.id',
                'units.name',
                DB::raw('ROUND(SUM(services.price), 2) as revenue')
            )
            ->where('reservations.status', 'accepted')
            ->where('reservations.start', '>=', $from)
            ->groupBy('units.id', 'units.name')
            ->orderByDesc('revenue')
            ->limit(3)
            ->get();

        $out = [];
        foreach ($rows as $r) {
            $out[] = [
                'id' => (int) $r->id,
                'name' => (string) $r->name,
                'revenue' => (float) $r->revenue,
            ];
        }

        return $out;
    }

    private function getTopForemen(Carbon $from): array
    {
        $rows = DB::table('reservations')
            ->join('units', 'units.id', '=', 'reservations.unit_id')
            ->join('users', 'users.id', '=', 'units.foreman_id')
            ->select(
                'users.id',
                'users.firstname',
                'users.lastname',
                'units.name as unit_name',
                DB::raw('COUNT(reservations.id) as jobs')
            )
            ->whereNotNull('units.foreman_id')
            ->where('reservations.status', 'accepted')
            ->where('reservations.start', '>=', $from)
            ->groupBy('users.id', 'users.firstname', 'users.lastname', 'units.name')
            ->orderByDesc('jobs')
            ->limit(3)
            ->get();

        $out = [];
        foreach ($rows as $r) {
            $out[] = [
                'id' => (int) $r->id,
                'name' => trim((string) $r->firstname . ' ' . (string) $r->lastname),
                'unit_name' => (string) $r->unit_name,
                'jobs' => (int) $r->jobs,
            ];
        }

        return $out;
    }

    public function render()
    {
        return view('livewire.dashboard.rankings');
    }
}
