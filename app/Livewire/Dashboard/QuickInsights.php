<?php

namespace App\Livewire\Dashboard;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class QuickInsights extends Component
{
    public int $backlogCount = 0;
    public int $backlogPercent = 0;

    public int $declinedRate = 0;

    public string $peakHour = '—';
    public array $peakDays = [];

    public function mount(): void
    {
        $this->loadInsights();
    }

    public function loadInsights(): void
    {
        $now = Carbon::now();

        $backlogBefore = $now->copy()->subHours(24);

        $this->backlogCount = (int) DB::table('reservations')
            ->where('status', 'waiting')
            ->where('created_at', '<=', $backlogBefore)
            ->count();

        $from30 = $now->copy()->subDays(30);

        $waiting30 = (int) DB::table('reservations')
            ->where('status', 'waiting')
            ->where('created_at', '>=', $from30)
            ->count();

        $this->backlogPercent = $waiting30 > 0
            ? (int) round(min(100, ($this->backlogCount / $waiting30) * 100))
            : 0;

        $total30 = (int) DB::table('reservations')
            ->where('start', '>=', $from30)
            ->count();

        $declined30 = (int) DB::table('reservations')
            ->where('start', '>=', $from30)
            ->where('status', 'declined')
            ->count();

        $this->declinedRate = $total30 > 0
            ? (int) round(($declined30 / $total30) * 100)
            : 0;

        $peak = DB::table('reservations')
            ->select(DB::raw('HOUR(`start`) as hr'), DB::raw('COUNT(*) as cnt'))
            ->where('status', 'accepted')
            ->where('start', '>=', $from30)
            ->groupBy(DB::raw('HOUR(`start`)'))
            ->orderByDesc('cnt')
            ->limit(1)
            ->first();

        if ($peak && $peak->hr !== null) {
            $this->peakHour = str_pad((string) (int) $peak->hr, 2, '0', STR_PAD_LEFT) . ':00';
        } else {
            $this->peakHour = '—';
        }

        $days = DB::table('reservations')
            ->select(DB::raw('DAYOFWEEK(`start`) as dow'), DB::raw('COUNT(*) as cnt'))
            ->where('status', 'accepted')
            ->where('start', '>=', $from30)
            ->groupBy(DB::raw('DAYOFWEEK(`start`)'))
            ->orderByDesc('cnt')
            ->limit(2)
            ->get();

        $map = [
            1 => 'Ned',
            2 => 'Pon',
            3 => 'Uto',
            4 => 'Sri',
            5 => 'Čet',
            6 => 'Pet',
            7 => 'Sub',
        ];

        $this->peakDays = [];
        foreach ($days as $d) {
            $key = (int) $d->dow;
            if (isset($map[$key])) {
                $this->peakDays[] = $map[$key];
            }
        }
    }

    public function render()
    {
        return view('livewire.dashboard.quick-insights');
    }
}
