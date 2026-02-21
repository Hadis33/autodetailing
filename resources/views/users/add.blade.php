<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-100 px-3 py-8 overflow-x-hidden">
        <div class="w-full max-w-sm sm:max-w-md lg:max-w-2xl xl:max-w-3xl">
            <div class="bg-white shadow-lg rounded-xl px-4 py-6 sm:px-8 sm:py-8">
                <!-- Header -->
                <div class="text-center mb-6 sm:mb-8">
                    <h2 class="text-xl sm:text-2xl lg:text-3xl font-semibold text-gray-900 mb-2">
                        Dodavanje novog korisnika
                    </h2>
                    <p class="text-sm sm:text-base text-gray-600">
                        Popunite formu za dodavanje novog korisnika u sistem
                    </p>
                </div>

                <x-validation-errors class="mb-6" />

                <!-- Form -->
                <form method="POST" action="{{ route('users.store') }}" id="addForm">
                    @csrf

                    <!-- Grid Container for Form Fields -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                        <!-- Firstname -->
                        <div class="md:col-span-1">
                            <x-label for="firstname" value="Ime" class="text-sm sm:text-base" />
                            <x-input id="firstname" class="block mt-1 w-full text-sm sm:text-base" type="text"
                                name="firstname" :value="old('firstname')" required autofocus autocomplete="firstname" />
                        </div>

                        <!-- Lastname -->
                        <div class="md:col-span-1">
                            <x-label for="lastname" value="Prezime" class="text-sm sm:text-base" />
                            <x-input id="lastname" class="block mt-1 w-full text-sm sm:text-base" type="text"
                                name="lastname" :value="old('lastname')" required autocomplete="lastname" />
                        </div>

                        <!-- Email -->
                        <div class="md:col-span-2">
                            <x-label for="email" value="Email" class="text-sm sm:text-base" />
                            <x-input id="email" class="block mt-1 w-full text-sm sm:text-base" type="email"
                                name="email" :value="old('email')" required autocomplete="email" />
                            <p class="text-xs text-gray-500 mt-1">
                                Email će se koristiti za prijavu
                            </p>
                        </div>

                        <!-- Phone -->
                        <div class="md:col-span-2">
                            <x-label for="phone" value="Broj telefona" class="text-sm sm:text-base" />
                            <x-input id="phone" class="block mt-1 w-full text-sm sm:text-base" type="text"
                                name="phone" :value="old('phone')" required autocomplete="phone" />
                        </div>

                        <!-- Role -->
                        <div class="md:col-span-2">
                            <x-label for="role" value="Ovlast" class="text-sm sm:text-base" />
                            <select id="role" name="role"
                                class="block mt-1 w-full rounded-lg border-gray-300 focus:border-red-500
                                    focus:ring-red-500 cursor-pointer text-sm sm:text-base py-2.5 px-3"
                                required>
                                <option value="client" {{ old('role') == 'client' ? 'selected' : '' }}>
                                    Klijent
                                </option>
                                <option value="employee" {{ old('role') == 'employee' ? 'selected' : '' }}>
                                    Uposlenik
                                </option>
                                <option value="foreman" {{ old('role') == 'foreman' ? 'selected' : '' }}>
                                    Poslovođa
                                </option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>
                                    Administrator
                                </option>
                            </select>
                        </div>

                        <!-- Unit Select (Initially Hidden, Shown Only for Foreman and Employee) -->
                        <div id="unit-select" class="md:col-span-2 hidden">
                            <x-label for="unit_id" value="Poslovna jedinica" class="text-sm sm:text-base" />
                            <select id="unit_id" name="unit_id" required
                                class="block mt-1 w-full rounded-lg border-gray-300 focus:border-red-500 focus:ring-red-500 cursor-pointer text-sm sm:text-base py-2.5 px-3">
                                <option value="">-- Odaberite poslovnu jedinicu --</option>
                                @foreach ($units as $unit)
                                    <option value="{{ $unit->id }}"
                                        {{ old('unit_id') == $unit->id ? 'selected' : '' }}>
                                        {{ $unit->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Password -->
                        <div class="md:col-span-2">
                            <x-label for="password" value="Lozinka" class="text-sm sm:text-base" />
                            <x-input id="password" class="block w-full text-sm sm:text-base" type="password"
                                name="password" required autocomplete="new-password" />
                        </div>

                        <!-- Password Confirmation -->
                        <div class="md:col-span-2">
                            <x-label for="password_confirmation" value="Potvrda lozinke" class="text-sm sm:text-base" />
                            <x-input id="password_confirmation" class="block mt-1 w-full text-sm sm:text-base"
                                type="password" name="password_confirmation" required autocomplete="new-password" />
                            <p class="text-xs text-gray-500 mt-2">
                                Lozinka mora imati minimalno 8 karaktera
                            </p>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <div class="flex flex-col sm:flex-row gap-4 sm:gap-6 justify-between">
                            <!-- Left Side - Cancel Button -->
                            <div class="flex justify-center sm:justify-start">
                                <x-cancel class="w-full sm:w-auto whitespace-nowrap px-6 py-1"
                                    onclick="window.location='{{ route('users') }}'">
                                    <svg class="w-4 h-4 mr-2 inline-block" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                    </svg>
                                    Odustani
                                </x-cancel>
                            </div>

                            <!-- Right Side - Save Button -->
                            <div class="flex justify-center sm:justify-end">
                                <x-button type="submit"
                                    class="w-full sm:w-auto whitespace-nowrap px-6 py-1
                                           bg-green-700 hover:bg-green-800 focus:ring-green-600">
                                    <svg class="w-4 h-4 mr-2 inline-block" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    Dodaj korisnika
                                </x-button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const roleSelect = document.getElementById('role');
            const unitDiv = document.getElementById('unit-select');

            function toggleUnit() {
                if (roleSelect.value === 'employee' || roleSelect.value === 'foreman') {
                    unitDiv.classList.remove('hidden');
                } else {
                    unitDiv.classList.add('hidden');
                }
            }

            roleSelect.addEventListener('change', toggleUnit);

            // inicijalno provjeri (ako je old value postavljena)
            toggleUnit();
        });
    </script>
</x-guest-layout>
