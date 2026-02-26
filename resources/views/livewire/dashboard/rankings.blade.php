<div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
    <h2 class="text-base font-semibold">Rang lista</h2>
    <p class="text-sm text-slate-600">Najbolje poslovne jedinice i poslovođe (posljednjih {{ $days }} dana).</p>

    <div class="mt-4 space-y-4">
        <div class="rounded-2xl bg-slate-50 p-4">
            <p class="text-sm font-semibold">Najbolje jedinice</p>

            <div class="mt-3 space-y-2">
                @forelse ($topUnits as $i => $u)
                    @php
                        $badge = $i === 0 ? 'bg-red-700 text-white' : 'bg-slate-200 text-slate-700';
                    @endphp

                    <div class="flex items-center justify-between rounded-xl bg-white px-3 py-2">
                        <div class="flex items-center gap-2">
                            <span
                                class="grid h-7 w-7 place-items-center rounded-lg text-xs font-semibold {{ $badge }}">
                                {{ $i + 1 }}
                            </span>
                            <span class="text-sm font-semibold">{{ $u['name'] }}</span>
                        </div>

                        <span class="text-xs font-semibold text-slate-600">
                            +€ {{ number_format($u['revenue'], 2, '.', ',') }}
                        </span>
                    </div>
                @empty
                    <div class="rounded-xl bg-white px-3 py-2 text-sm text-slate-500">
                        Nema podataka.
                    </div>
                @endforelse
            </div>
        </div>

        <div class="rounded-2xl bg-slate-50 p-4">
            <p class="text-sm font-semibold">Najbolje poslovođe</p>

            <div class="mt-3 space-y-2">
                @forelse ($topForemen as $f)
                    <div class="flex items-center justify-between rounded-xl bg-white px-3 py-2">
                        <div class="flex items-center gap-3">
                            <div class="leading-tight">
                                <p class="text-sm font-semibold">{{ $f['name'] }}</p>
                                <p class="text-xs text-slate-500">{{ $f['unit_name'] }}</p>
                            </div>
                        </div>
                        <span class="text-xs font-semibold text-slate-600">{{ $f['jobs'] }} poslova</span>
                    </div>
                @empty
                    <div class="rounded-xl bg-white px-3 py-2 text-sm text-slate-500">
                        Nema podataka.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
