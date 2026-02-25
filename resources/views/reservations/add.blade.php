<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-100 px-3 py-8 overflow-x-hidden">
        <div class="w-full max-w-sm sm:max-w-md lg:max-w-2xl xl:max-w-3xl">
            <div class="bg-white shadow-lg rounded-xl px-4 py-6 sm:px-8 sm:py-8">

                <!-- Header -->
                <div class="text-center mb-6 sm:mb-8">
                    <h2 class="text-xl sm:text-2xl lg:text-3xl font-semibold text-gray-900 mb-2">
                        Kreiranje nove rezervacije
                    </h2>
                    <p class="text-sm sm:text-base text-gray-600">
                        Popunite podatke za rezervaciju termina
                    </p>
                </div>

                <x-validation-errors class="mb-6" />

                <!-- Form -->
                <form method="POST" action="{{ route('reservations.store') }}">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">

                        <!-- Poslovna jedinica -->
                        <div class="md:col-span-1">
                            <x-label for="unit_id" value="Poslovna jedinica" />
                            <select id="unit_id" name="unit_id"
                                class="block mt-1 w-full rounded-lg border-gray-300 focus:border-red-500 focus:ring-red-500"
                                required>
                                <option value="">-- Odaberite jedinicu --</option>

                                @foreach ($units as $unit)
                                    <option value="{{ $unit->id }}"
                                        {{ old('unit_id') == $unit->id ? 'selected' : '' }}>
                                        {{ $unit->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div id="map" class="w-full h-64 mt-6 rounded-lg shadow-md"></div>

                        <!-- Usluga -->
                        <div class="md:col-span-1">
                            <x-label for="service_id" value="Usluga" />
                            <select id="service_id" name="service_id"
                                class="block mt-1 w-full rounded-lg border-gray-300 focus:border-red-500 focus:ring-red-500"
                                required>
                                <option value="">-- Odaberite uslugu --</option>

                                @foreach ($services as $service)
                                    <option value="{{ $service->id }}" data-duration="{{ $service->duration }}"
                                        {{ old('service_id') == $service->id ? 'selected' : '' }}>
                                        {{ $service->name }}
                                        ({{ $service->duration_formatted }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Početak -->
                        <div class="md:col-span-1">
                            <x-label for="start" value="Početak rezervacije" />
                            <x-input id="start" class="block mt-1 w-full" type="datetime-local" name="start"
                                :value="old('start')" required />
                        </div>

                        <!-- Kraj (auto ili ručno) -->
                        <div class="md:col-span-1">
                            <x-label for="end" value="Kraj rezervacije" />
                            <x-input id="end" class="block mt-1 w-full bg-gray-100" type="datetime-local"
                                name="end" :value="old('end')" readonly />
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <div class="flex flex-col sm:flex-row gap-4 justify-between">

                            <x-cancel onclick="window.location='/dashboard'">
                                Odustani
                            </x-cancel>

                            <x-button type="submit" class="bg-green-700 hover:bg-green-800 focus:ring-green-600">
                                Kreiraj rezervaciju
                            </x-button>

                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>

    <!-- Auto calculate end time -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const serviceSelect = document.getElementById('service_id');
            const startInput = document.getElementById('start');
            const endInput = document.getElementById('end');

            function updateEndTime() {

                const selectedOption = serviceSelect.options[serviceSelect.selectedIndex];

                if (!selectedOption || !startInput.value) return;

                const duration = selectedOption.dataset.duration;

                if (!duration) return;

                const start = new Date(startInput.value);

                start.setMinutes(start.getMinutes() + parseInt(duration));

                const yyyy = start.getFullYear();
                const mm = String(start.getMonth() + 1).padStart(2, '0');
                const dd = String(start.getDate()).padStart(2, '0');
                const hh = String(start.getHours()).padStart(2, '0');
                const min = String(start.getMinutes()).padStart(2, '0');

                endInput.value = `${yyyy}-${mm}-${dd}T${hh}:${min}`;
            }

            serviceSelect.addEventListener('change', updateEndTime);
            startInput.addEventListener('change', updateEndTime);

        });

        document.addEventListener('DOMContentLoaded', function() {

            const unitSelect = document.getElementById('unit_id');
            let map = L.map('map').setView([44.803222, 15.869806], 12);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            let marker;

            unitSelect.addEventListener('change', function() {
                const unitId = this.value;
                if (!unitId) return;

                fetch(`/units/${unitId}/coordinates`)
                    .then(response => response.json())
                    .then(data => {
                        if (!data.coordinates) return;

                        const [lat, lng] = data.coordinates.split(',').map(Number);

                        if (marker) map.removeLayer(marker);

                        marker = L.marker([lat, lng]).addTo(map);
                        map.setView([lat, lng], 15);
                    })
                    .catch(err => console.error(err));
            });

        });
    </script>

</x-guest-layout>
