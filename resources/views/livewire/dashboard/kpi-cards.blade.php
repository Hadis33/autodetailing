<section class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
    <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500">DANAS</p>
                <p class="mt-1 text-2xl font-bold">{{ $todayTotal }}</p>
                <p class="mt-1 text-sm text-slate-600">Ukupan broj rezervacija</p>
            </div>
            <div class="grid h-10 w-10 place-items-center rounded-xl bg-slate-100 text-slate-700">📅</div>
        </div>

        <div class="mt-4 grid grid-cols-3 gap-2">
            <div class="rounded-xl bg-slate-50 p-2 text-center">
                <p class="text-xs text-slate-500">Na čekanju</p>
                <p class="text-sm font-semibold">{{ $todayWaiting }}</p>
            </div>
            <div class="rounded-xl bg-slate-50 p-2 text-center">
                <p class="text-xs text-slate-500">Prihvaćene</p>
                <p class="text-sm font-semibold">{{ $todayAccepted }}</p>
            </div>
            <div class="rounded-xl bg-slate-50 p-2 text-center">
                <p class="text-xs text-slate-500">Odbijene</p>
                <p class="text-sm font-semibold">{{ $todayDeclined }}</p>
            </div>
        </div>
    </div>

    <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500">PRIHOD</p>
                <p class="mt-1 text-2xl font-bold">€ {{ number_format($revenue30, 2, '.', ',') }}</p>
                <p class="mt-1 text-sm text-slate-600">Posljednjih 30 dana</p>
            </div>
            <div class="grid h-10 w-10 place-items-center rounded-xl bg-slate-100 text-slate-700">💶</div>
        </div>

        <div class="mt-4">
            <div class="flex items-center justify-between text-xs text-slate-500">
                <span>Napredak</span>
                <span>{{ $revenueProgress }}%</span>
            </div>
            <div class="mt-2 h-2 w-full rounded-full bg-slate-100">
                <div class="h-2 rounded-full bg-red-700" style="width: {{ $revenueProgress }}%"></div>
            </div>
        </div>
    </div>

    <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500">AKTIVNI KLIJENTI</p>
                <p class="mt-1 text-2xl font-bold">{{ $activeClients30 }}</p>
                <p class="mt-1 text-sm text-slate-600">Jedinstveni (30 dana)</p>
            </div>
            <div class="grid h-10 w-10 place-items-center rounded-xl bg-slate-100 text-slate-700">👥</div>
        </div>
    </div>

    <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500">PROSJEČNO TRAJANJE</p>
                <p class="mt-1 text-2xl font-bold">{{ $avgDuration7 }} min</p>
                <p class="mt-1 text-sm text-slate-600">Posljednjih 7 dana</p>
            </div>
            <div class="grid h-10 w-10 place-items-center rounded-xl bg-slate-100 text-slate-700">⏱️</div>
        </div>

        <div class="mt-4 flex items-center justify-between rounded-xl bg-slate-50 p-3">
            <div>
                <p class="text-xs text-slate-500">Trend</p>
                <p class="text-sm font-semibold text-slate-800">
                    {{ $avgDurationTrend >= 0 ? '+' : '' }}{{ $avgDurationTrend }} min
                </p>
            </div>
            <span class="text-xs font-semibold text-slate-600">u odnosu na prethodni period</span>
        </div>
    </div>
</section>
