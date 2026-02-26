<div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
    <h2 class="text-base font-semibold">Brzi uvidi</h2>
    <p class="text-sm text-slate-600">Operativni pokazatelji.</p>

    <div class="mt-4 space-y-3">
        <div class="rounded-2xl bg-slate-50 p-4">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-semibold">Zaostatak</p>
                    <p class="text-xs text-slate-500">Na čekanju &gt; 24h</p>
                </div>
                <span class="rounded-full bg-white px-2 py-1 text-xs font-semibold text-slate-800">
                    {{ $backlogCount }}
                </span>
            </div>

            <div class="mt-3 h-2 w-full rounded-full bg-slate-200">
                <div class="h-2 rounded-full bg-slate-900" style="width: {{ $backlogPercent }}%"></div>
            </div>

            <p class="mt-2 text-[11px] text-slate-500">
                {{ $backlogPercent }}% od ukupno na čekanju (posljednjih 30 dana)
            </p>
        </div>

        <div class="rounded-2xl bg-slate-50 p-4">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-semibold">Stopa odbijenih</p>
                    <p class="text-xs text-slate-500">Posljednjih 30 dana</p>
                </div>
                <span class="rounded-full bg-white px-2 py-1 text-xs font-semibold text-slate-800">
                    {{ $declinedRate }}%
                </span>
            </div>

            <div class="mt-3 h-2 w-full rounded-full bg-slate-200">
                <div class="h-2 rounded-full bg-red-700" style="width: {{ $declinedRate }}%"></div>
            </div>
        </div>

        <div class="rounded-2xl bg-slate-50 p-4">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-semibold">Vrijeme najveće aktivnosti</p>
                    <p class="text-xs text-slate-500">Najčešći sat (prihvaćene, 30 dana)</p>
                </div>
                <span class="rounded-full bg-white px-2 py-1 text-xs font-semibold text-slate-800">
                    {{ $peakHour }}
                </span>
            </div>

            <div class="mt-3 flex flex-wrap gap-2">
                @php
                    $allDays = ['Pon', 'Uto', 'Sri', 'Čet', 'Pet', 'Sub', 'Ned'];
                @endphp

                @foreach ($allDays as $d)
                    <span
                        class="rounded-full px-2.5 py-1 text-xs font-semibold
                        {{ in_array($d, $peakDays, true) ? 'bg-red-700 text-white' : 'bg-white text-slate-700' }}">
                        {{ $d }}
                    </span>
                @endforeach
            </div>
        </div>
    </div>
</div>
