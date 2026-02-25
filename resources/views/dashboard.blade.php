<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                    <h1 class="text-2xl font-medium text-gray-900 mb-4">
                        Evidencija rezervacija
                    </h1>
                    @livewire('reservation-calendar')
                    @livewire('reservation-modal')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
