<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        @session('status')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ $value }}
            </div>
        @endsession

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-label for="email" value="Email" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                    autofocus autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="Lozinka" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required
                    autocomplete="current-password" />
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" name="remember" />
                    <span class="ms-2 text-sm text-gray-600">Zapamti me</span>
                </label>
            </div>

            <div class="mt-4 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}"
                        class="text-sm text-gray-600 underline hover:text-gray-900 rounded-md
                   focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500
                   whitespace-nowrap">
                        Zaboravljena lozinka?
                    </a>
                @endif
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                    <x-button class="w-full sm:w-auto whitespace-nowrap">
                        Prijavi se
                    </x-button>
                </div>
            </div>

            <div class="mt-4">
                <span
                    class="text-sm text-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    Nemate nalog?
                    <a href="/register" class="underline hover:text-gray-900">
                        Registrirajte se
                    </a>
                </span>
            </div>


        </form>
    </x-authentication-card>
</x-guest-layout>
