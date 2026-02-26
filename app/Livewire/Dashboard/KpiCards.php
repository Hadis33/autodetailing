<?php

namespace App\Livewire\Dashboard;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class KpiCards extends Component
{
    public int $revenueGoal = 4000;

    public int $todayTotal = 0;
    public int $todayWaiting = 0;
    public int $todayAccepted = 0;
    public int $todayDeclined = 0;

    public float $revenue30 = 0;
    public int $revenueProgress = 0;

    public int $activeClients30 = 0;

    public int $avgDuration7 = 0;
    public int $avgDurationTrend = 0;

    public function mount(?int $revenueGoal = null): void
    {
        if ($revenueGoal !== null) {
            $this->revenueGoal = $revenueGoal;
        }

        $this->loadKpis();
    }

    public function loadKpis(): void
    {
        $todayStart = Carbon::today();
        $todayEnd = Carbon::tomorrow();

        $rows = DB::table('reservations')
            ->select('status', DB::raw('COUNT(*) as cnt'))
            ->where('start', '>=', $todayStart)
            ->where('start', '<', $todayEnd)
            ->groupBy('status')
            ->get();

        $counts = [
            'waiting' => 0,
            'accepted' => 0,
            'declined' => 0,
        ];

        foreach ($rows as $r) {
            if (isset($counts[$r->status])) {
                $counts[$r->status] = (int) $r->cnt;
            }
        }

        $this->todayWaiting = $counts['waiting'];
        $this->todayAccepted = $counts['accepted'];
        $this->todayDeclined = $counts['declined'];
        $this->todayTotal = $this->todayWaiting + $this->todayAccepted + $this->todayDeclined;

        $from30 = Carbon::now()->subDays(30);

        $revenue = DB::table('reservations')
            ->join('services', 'services.id', '=', 'reservations.service_id')
            ->where('reservations.status', 'accepted')
            ->where('reservations.start', '>=', $from30)
            ->sum('services.price');

        $this->revenue30 = (float) $revenue;

        $this->revenueProgress = $this->revenueGoal > 0
            ? (int) round(min(100, ($this->revenue30 / $this->revenueGoal) * 100))
            : 0;

        $this->activeClients30 = (int) DB::table('reservations')
            ->where('status', 'accepted')
            ->where('start', '>=', $from30)
            ->distinct('user_id')
            ->count('user_id');

        $from7 = Carbon::now()->subDays(7);

        $avgNow = (float) DB::table('reservations')
            ->where('status', 'accepted')
            ->where('start', '>=', $from7)
            ->avg(DB::raw('TIMESTAMPDIFF(MINUTE, start, end)'));

        $this->avgDuration7 = (int) round($avgNow);

        $prev7From = Carbon::now()->subDays(14);
        $prev7To = Carbon::now()->subDays(7);

        $avgPrev = (float) DB::table('reservations')
            ->where('status', 'accepted')
            ->where('start', '>=', $prev7From)
            ->where('start', '<', $prev7To)
            ->avg(DB::raw('TIMESTAMPDIFF(MINUTE, start, end)'));

        $this->avgDurationTrend = (int) round($this->avgDuration7 - (int) round($avgPrev));
    }

    public function render()
    {
        return view('livewire.dashboard.kpi-cards');
    }
}
