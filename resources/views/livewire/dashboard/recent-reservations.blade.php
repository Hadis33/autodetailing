<div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm lg:col-span-2">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-base font-semibold">Nedavne rezervacije</h2>
            <p class="text-sm text-slate-600">Najnovija aktivnost.</p>
        </div>

        <div class="flex flex-col gap-2 sm:flex-row sm:items-center">
            <div class="relative">
                <input type="text" wire:model.live.debounce.350ms="search"
                    placeholder="Pretraži klijenta, jedinicu, uslugu..."
                    class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm outline-none placeholder:text-slate-400 focus:border-slate-300 focus:ring-2 focus:ring-slate-200 sm:w-64" />
                <span class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-slate-400">⌕</span>
            </div>

            <select wire:model.live="status"
                class="rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm font-semibold text-slate-700 outline-none focus:border-slate-300 focus:ring-2 focus:ring-slate-200">
                <option value="all">Sve</option>
                <option value="waiting">Na čekanju</option>
                <option value="accepted">Prihvaćene</option>
                <option value="declined">Odbijene</option>
            </select>
        </div>
    </div>

    <div class="mt-4 overflow-hidden rounded-2xl border border-slate-200">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-wide text-slate-600">
                <tr>
                    <th class="px-4 py-3">Klijent</th>
                    <th class="px-4 py-3">Jedinica</th>
                    <th class="px-4 py-3">Usluga</th>
                    <th class="px-4 py-3">Početak</th>
                    <th class="px-4 py-3">Status</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-200 bg-white">
                @forelse ($reservations as $r)
                    <tr class="hover:bg-slate-50">
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                <div class="leading-tight">
                                    <p class="font-semibold">
                                        {{ $r->user?->firstname }} {{ $r->user?->lastname }}
                                    </p>
                                    <p class="text-xs text-slate-500">
                                        {{ $r->user?->email }}
                                    </p>
                                </div>
                            </div>
                        </td>

                        <td class="px-4 py-3">
                            {{ $r->unit?->name ?? '—' }}
                        </td>

                        <td class="px-4 py-3">
                            {{ $r->service?->name ?? '—' }}
                        </td>

                        <td class="px-4 py-3">
                            {{ optional($r->start)->format('d.m.Y H:i') }}
                        </td>

                        <td class="px-2 py-3 text-center">
                            @php
                                $pill = match ($r->status) {
                                    'accepted' => 'bg-green-700 text-white',
                                    'waiting' => 'bg-amber-300 text-slate-700',
                                    'declined' => 'bg-red-700 text-white',
                                    default => 'bg-amber-300 text-slate-700',
                                };

                                $label = match ($r->status) {
                                    'accepted' => 'Prihvaćena',
                                    'waiting' => 'Na čekanju',
                                    'declined' => 'Odbijena',
                                    default => ucfirst($r->status),
                                };
                            @endphp

                            <span
                                class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold {{ $pill }}">
                                {{ $label }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center text-sm text-slate-500">
                            Nema pronađenih rezervacija.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $reservations->links() }}
    </div>
</div>
