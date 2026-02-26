<div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm lg:col-span-2">
    <div class="flex items-start justify-between">
        <div>
            <h2 class="text-base font-semibold">
                Iskorištenost po {{ $mode === 'units' ? 'jedinici' : 'usluzi' }}
            </h2>
            <p class="text-sm text-slate-600">
                Obim prihvaćenih rezervacija (posljednjih {{ $days }} dana).
            </p>
        </div>

        <div class="flex items-center gap-2">
            <button type="button" wire:click="setMode('units')"
                class="rounded-xl border border-slate-200 px-3 py-2 text-xs font-semibold
                       {{ $mode === 'units' ? 'bg-gray-800 text-white border-gray-800' : 'bg-white hover:bg-gray-100' }}">
                Jedinice
            </button>

            <button type="button" wire:click="setMode('services')"
                class="rounded-xl border border-gray-200 px-3 py-2 text-xs font-semibold
                       {{ $mode === 'services' ? 'bg-gray-800 text-white border-gray-800' : 'bg-white hover:bg-gray-100' }}">
                Usluge
            </button>
        </div>
    </div>

    <div class="mt-4 rounded-2xl bg-slate-50 p-4">
        <div class="grid grid-cols-6 items-end gap-3">
            @foreach ($bars as $bar)
                @php
                    $isEmpty = $bar['empty'] ?? false;
                    $h = max(10, (int) $bar['percent']);
                @endphp

                <div class="flex flex-col items-center gap-2">
                    <div class="w-full rounded-xl {{ $isEmpty ? 'bg-slate-200' : 'bg-red-700' }}"
                        style="height: {{ $h }}px"
                        title="{{ $bar['label'] ? $bar['label'] . ' — ' . $bar['value'] : '' }}"></div>

                    <div class="w-full text-center">
                        <p class="truncate text-[10px] font-semibold text-slate-600">
                            {{ $bar['label'] ?: '—' }}
                        </p>
                        <p class="text-[10px] text-slate-500">
                            {{ $bar['value'] ?: '' }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4 grid grid-cols-3 gap-3">
            <div class="rounded-xl bg-white p-3">
                <p class="text-xs text-slate-500">Najopterećenija</p>
                <p class="text-sm font-semibold">
                    {{ $mostBusy['label'] ?? '—' }}
                </p>
                <p class="text-xs text-slate-500">
                    {{ isset($mostBusy['value']) ? $mostBusy['value'] . ' prihvaćenih' : 'Nema podataka' }}
                </p>
            </div>

            <div class="rounded-xl bg-white p-3">
                <p class="text-xs text-slate-500">Najmanje opterećena</p>
                <p class="text-sm font-semibold">
                    {{ $leastBusy['label'] ?? '—' }}
                </p>
                <p class="text-xs text-slate-500">
                    {{ isset($leastBusy['value']) ? $leastBusy['value'] . ' prihvaćenih' : 'Nema podataka' }}
                </p>
            </div>

            <div class="rounded-xl bg-white p-3">
                <p class="text-xs text-slate-500">Konflikti</p>
                <p class="text-sm font-semibold">{{ $conflicts }}</p>
                <p class="text-xs text-slate-500">Potencijalna preklapanja</p>
            </div>
        </div>
    </div>
</div>
