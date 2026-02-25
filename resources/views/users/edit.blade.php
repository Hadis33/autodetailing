<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-100 px-3 py-8 overflow-x-hidden">
        <div class="w-full max-w-sm sm:max-w-md lg:max-w-2xl xl:max-w-3xl">
            <div class="bg-white shadow-lg rounded-xl px-4 py-6 sm:px-8 sm:py-8">
                <!-- Header -->
                <div class="text-center mb-6 sm:mb-8">
                    <h2 class="text-xl sm:text-2xl lg:text-3xl font-semibold text-gray-900 mb-2">
                        Uređivanje korisnika
                    </h2>
                    <p class="text-sm sm:text-base text-gray-600">
                        {{ $user->firstname }} {{ $user->lastname }}
                    </p>
                    <p class="text-xs sm:text-sm text-gray-500 mt-1">
                        Email: {{ $user->email }}
                    </p>
                </div>

                <x-validation-errors class="mb-6" />

                <!-- Form -->
                <form method="POST" action="{{ route('users.update', $user->id) }}" id="editForm">
                    @csrf
                    @method('PUT')

                    <!-- Grid Container for Form Fields -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                        <!-- Firstname -->
                        <div class="md:col-span-1">
                            <x-label for="firstname" value="Ime" class="text-sm sm:text-base" />
                            <x-input id="firstname" class="block mt-1 w-full text-sm sm:text-base" type="text"
                                name="firstname" :value="old('firstname', $user->firstname)" required autofocus autocomplete="firstname" />
                        </div>

                        <!-- Lastname -->
                        <div class="md:col-span-1">
                            <x-label for="lastname" value="Prezime" class="text-sm sm:text-base" />
                            <x-input id="lastname" class="block mt-1 w-full text-sm sm:text-base" type="text"
                                name="lastname" :value="old('lastname', $user->lastname)" required autocomplete="lastname" />
                        </div>

                        <!-- Email -->
                        <div class="md:col-span-2">
                            <x-label for="email" value="Email" class="text-sm sm:text-base" />
                            <x-input id="email" class="block mt-1 w-full text-sm sm:text-base" type="email"
                                name="email" :value="old('email', $user->email)" required autocomplete="email" />
                        </div>

                        <!-- Phone -->
                        <div class="md:col-span-2">
                            <x-label for="phone" value="Broj telefona" class="text-sm sm:text-base" />
                            <x-input id="phone" class="block mt-1 w-full text-sm sm:text-base" type="text"
                                name="phone" :value="old('phone', $user->phone)" required autocomplete="phone" />
                        </div>

                        <!-- Role -->
                        <div class="md:col-span-2">
                            <x-label for="role" value="Ovlast" class="text-sm sm:text-base" />
                            <select id="role" name="role"
                                class="block mt-1 w-full rounded-lg border-gray-300 focus:border-red-500
                                       focus:ring-red-500 cursor-pointer text-sm sm:text-base py-2.5 px-3">
                                <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>
                                    Administrator
                                </option>
                                <option value="employee"
                                    {{ old('role', $user->role) === 'employee' ? 'selected' : '' }}>
                                    Uposlenik
                                </option>
                                <option value="client" {{ old('role', $user->role) === 'client' ? 'selected' : '' }}>
                                    Klijent
                                </option>
                            </select>
                        </div>

                        @if (!is_null($user->unit_id))
                            <div class="md:col-span-2">
                                <x-label for="unit_id" value="Poslovna jedinica" class="text-sm sm:text-base" />
                                <select name="unit_id" id="unit_id"
                                    class="block mt-1 w-full rounded-lg border-gray-300 focus:border-red-500 focus:ring-red-500 cursor-pointer text-sm sm:text-base py-2.5 px-3"
                                    required>
                                    @foreach ($units as $unit)
                                        <option value="{{ $unit->id }}"
                                            {{ old('unit_id', $user->unit_id) == $unit->id ? 'selected' : '' }}>
                                            {{ $unit->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        <!-- Password -->
                        <div class="md:col-span-2">
                            <x-label for="password" value="Nova lozinka" class="text-sm sm:text-base" />
                            <p class="text-xs text-gray-500 mb-2">
                                Ostavite prazno ako ne želite mijenjati lozinku
                            </p>
                            <x-input id="password" class="block w-full text-sm sm:text-base" type="password"
                                name="password" autocomplete="new-password" />

                        </div>

                        <!-- Password Confirmation -->
                        <div class="md:col-span-2">
                            <x-label for="password_confirmation" value="Potvrda lozinke" class="text-sm sm:text-base" />
                            <x-input id="password_confirmation" class="block mt-1 w-full text-sm sm:text-base"
                                type="password" name="password_confirmation" autocomplete="new-password" />
                            <p class="text-xs text-gray-500 mt-2">
                                Minimalno 8 karaktera
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

                            <!-- Right Side - Save and Delete Buttons -->
                            <div class="flex flex-col sm:flex-row gap-4 sm:gap-4">
                                <!-- Save Button -->
                                <x-button type="submit"
                                    class="w-full sm:w-auto whitespace-nowrap px-6 py-1
                                           bg-blue-600 hover:bg-blue-700 focus:ring-blue-500">
                                    <svg class="w-4 h-4 mr-2 inline-block" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                                    </svg>
                                    Spremi promjene
                                </x-button>
                </form>

            </div>

        </div>
        <div class="flex items-center mt-8 w-full justify-center">
            <form method="POST" action="{{ route('users.destroy', $user->id) }}" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('Jeste li sigurni da želite obrisati korisnika?')"
                    class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs
                                                text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none
                                                focus:ring-2 focus:ring-red-600 focus:ring-offset-2 disabled:opacity-50 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    OBRIŠI KORISNIKA
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>
