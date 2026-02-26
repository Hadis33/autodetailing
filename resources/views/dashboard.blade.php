<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                    <h1 class="text-2xl font-medium text-gray-900 mb-4">
                        Evidencija rezervacija
                    </h1>

                    <x-button class="w-max px-4 py-3 my-2" onclick="window.location.href='/reservations/add'">
                        <svg class="w-4 h-4 mr-2 text-gray-100" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                d="M5 12h14m-7 7V5" />
                        </svg>
                        Kreiraj rezervaciju
                    </x-button>

                    @livewire('reservation-calendar')
                    @livewire('reservation-modal')
                </div>

                <div class="min-h-screen">
                    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                        @livewire('dashboard.kpi-cards')

                        <section class="mt-6 grid grid-cols-1 gap-4 lg:grid-cols-3">
                            @livewire('dashboard.utilization-by-unit')

                            @livewire('dashboard.quick-insights')
                        </section>

                        <section class="mt-6 grid grid-cols-1 gap-4 lg:grid-cols-3">
                            @livewire('dashboard.recent-reservations')

                            @livewire('dashboard.rankings')
                        </section>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
