<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-100 px-3 py-8 overflow-x-hidden">
        <div class="w-full max-w-sm sm:max-w-md lg:max-w-2xl xl:max-w-3xl">
            <div class="bg-white shadow-lg rounded-xl px-4 py-6 sm:px-8 sm:py-8">

                <!-- Header -->
                <div class="text-center mb-6 sm:mb-8">
                    <h2 class="text-xl sm:text-2xl lg:text-3xl font-semibold text-gray-900 mb-2">
                        Dodavanje novog artikla
                    </h2>
                    <p class="text-sm sm:text-base text-gray-600">
                        Popunite podatke za novi proizvod u webshopu
                    </p>
                </div>

                <x-validation-errors class="mb-6" />

                <!-- Form -->
                <form method="POST" action="{{ route('webshop.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">

                        <!-- Naziv -->
                        <div class="md:col-span-2">
                            <x-label for="name" value="Naziv artikla" />
                            <x-input id="name" class="block mt-1 w-full" type="text" name="name"
                                :value="old('name')" required />
                        </div>

                        <!-- Opis -->
                        <div class="md:col-span-2">
                            <x-label for="description" value="Opis" />
                            <textarea name="description"
                                class="block mt-1 w-full rounded-lg border-gray-300 focus:border-green-600 focus:ring-green-600" rows="4"
                                required>{{ old('description') }}</textarea>
                        </div>

                        <!-- Cijena -->
                        <div>
                            <x-label for="price" value="Cijena (KM)" />
                            <x-input id="price" class="block mt-1 w-full" type="number" step="0.01"
                                name="price" :value="old('price')" required />
                        </div>

                        <!-- Kategorija -->
                        <div>
                            <x-label for="category" value="Kategorija" />
                            <select name="category"
                                class="block mt-1 w-full rounded-lg border-gray-300 focus:border-green-600 focus:ring-green-600"
                                required>
                                <option value="">-- Odaberite kategoriju --</option>
                                <option value="cloths" {{ old('category') == 'cloths' ? 'selected' : '' }}>
                                    Krpe / Microfiber
                                </option>
                                <option value="window_cleaners"
                                    {{ old('category') == 'window_cleaners' ? 'selected' : '' }}>
                                    Sredstva za stakla
                                </option>
                                <option value="ceramic_coat" {{ old('category') == 'ceramic_coat' ? 'selected' : '' }}>
                                    Keramički premaz
                                </option>
                                <option value="polish" {{ old('category') == 'polish' ? 'selected' : '' }}>
                                    Pasta za poliranje
                                </option>
                                <option value="interior_cleaners"
                                    {{ old('category') == 'interior_cleaners' ? 'selected' : '' }}>
                                    Sredstva za enterijer
                                </option>
                                <option value="accesories" {{ old('category') == 'accesories' ? 'selected' : '' }}>
                                    Dodaci
                                </option>
                            </select>
                        </div>

                        <!-- Status -->
                        <div class="md:col-span-2">
                            <x-label for="status" value="Status proizvoda" />
                            <select name="status"
                                class="block mt-1 w-full rounded-lg border-gray-300 focus:border-green-600 focus:ring-green-600"
                                required>
                                <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>
                                    Dostupno
                                </option>
                                <option value="unavailable" {{ old('status') == 'unavailable' ? 'selected' : '' }}>
                                    Nedostupno
                                </option>
                            </select>
                        </div>

                        <!-- Slika -->
                        <div class="md:col-span-2">
                            <x-label for="image" value="Slika proizvoda" />
                            <input type="file" name="image" accept="image/*"
                                class="block mt-1 w-full border border-gray-300 rounded-lg p-2" required>
                            <p class="text-xs text-gray-500 mt-1">
                                Dozvoljeni formati: JPG, PNG. Max 2MB.
                            </p>
                        </div>

                    </div>

                    <!-- Buttons -->
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <div class="flex flex-col sm:flex-row gap-4 justify-between">

                            <!-- Cancel -->
                            <div>
                                <x-cancel onclick="window.location='{{ route('webshop') }}'">
                                    Odustani
                                </x-cancel>
                            </div>

                            <!-- Submit -->
                            <div>
                                <x-button type="submit" class="bg-green-700 hover:bg-green-800 focus:ring-green-600">
                                    Dodaj artikl
                                </x-button>
                            </div>

                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
