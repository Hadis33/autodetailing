<?php

namespace App\Livewire\Dashboard;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class UtilizationByUnit extends Component
{
    public string $mode = 'units'; // 'units' | 'services'
    public int $days = 7;
    public array $bars = [];

    public ?array $mostBusy = null;
    public ?array $leastBusy = null;
    public int $conflicts = 0;

    public function mount(?int $days = null): void
    {
        if ($days !== null) {
            $this->days = $days;
        }

        $this->loadData();
    }

    public function setMode(string $mode): void
    {
        if (!in_array($mode, ['units', 'services'], true)) {
            return;
        }

        $this->mode = $mode;
        $this->loadData();
    }

    public function loadData(): void
    {
        $from = Carbon::now()->subDays($this->days);

        if ($this->mode === 'units') {
            $this->loadUnits($from);
        } else {
            $this->loadServices($from);
        }

        $this->conflicts = $this->countConflicts($from);
    }

    private function loadUnits(Carbon $from): void
    {
        $rows = DB::table('reservations')
            ->join('units', 'units.id', '=', 'reservations.unit_id')
            ->select(
                'reservations.unit_id',
                'units.name as label',
                DB::raw('COUNT(*) as cnt')
            )
            ->where('reservations.status', 'accepted')
            ->where('reservations.start', '>=', $from)
            ->groupBy('reservations.unit_id', 'units.name')
            ->orderByDesc('cnt')
            ->limit(6)
            ->get();

        $this->hydrateBarsFromRows($rows);

        $this->mostBusy = $this->bars[0] ?? null;
        $this->leastBusy = !empty($this->bars) ? $this->bars[count($this->bars) - 1] : null;

        if ($this->mostBusy && $this->leastBusy && $this->mostBusy['label'] === $this->leastBusy['label']) {
            $this->leastBusy = null;
        }
    }

    private function loadServices(Carbon $from): void
    {
        $rows = DB::table('reservations')
            ->join('services', 'services.id', '=', 'reservations.service_id')
            ->select(
                'reservations.service_id',
                'services.name as label',
                DB::raw('COUNT(*) as cnt')
            )
            ->where('reservations.status', 'accepted')
            ->where('reservations.start', '>=', $from)
            ->groupBy('reservations.service_id', 'services.name')
            ->orderByDesc('cnt')
            ->limit(6)
            ->get();

        $this->hydrateBarsFromRows($rows);

        $this->mostBusy = $this->bars[0] ?? null;
        $this->leastBusy = !empty($this->bars) ? $this->bars[count($this->bars) - 1] : null;

        if ($this->mostBusy && $this->leastBusy && $this->mostBusy['label'] === $this->leastBusy['label']) {
            $this->leastBusy = null;
        }
    }

    private function hydrateBarsFromRows($rows): void
    {
        $max = 0;
        foreach ($rows as $r) {
            $max = max($max, (int) $r->cnt);
        }
        $max = max($max, 1);

        $bars = [];
        foreach ($rows as $r) {
            $value = (int) $r->cnt;

            $bars[] = [
                'label' => (string) $r->label,
                'value' => $value,
                'percent' => (int) round(($value / $max) * 100),
            ];
        }

        while (count($bars) < 6) {
            $bars[] = [
                'label' => '',
                'value' => 0,
                'percent' => 10,
                'empty' => true,
            ];
        }

        $this->bars = $bars;
    }

    private function countConflicts(Carbon $from): int
    {
        $count = (int) DB::table('reservations as r1')
            ->join('reservations as r2', function ($join) {
                $join->on('r1.unit_id', '=', 'r2.unit_id')
                    ->whereColumn('r1.id', '<', 'r2.id')
                    ->whereColumn('r1.start', '<', 'r2.end')
                    ->whereColumn('r2.start', '<', 'r1.end');
            })
            ->where('r1.status', 'accepted')
            ->where('r2.status', 'accepted')
            ->where('r1.start', '>=', $from)
            ->where('r2.start', '>=', $from)
            ->count();

        return $count;
    }

    public function render()
    {
        return view('livewire.dashboard.utilization-by-unit');
    }
}
