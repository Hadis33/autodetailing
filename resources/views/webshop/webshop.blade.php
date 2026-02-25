<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                <!-- Title -->
                <div class="px-8 pt-8 bg-white border-gray-200">
                    <h1 class="text-2xl font-medium text-gray-900">
                        Web Shop
                    </h1>
                    <p class="text-gray-500 mt-2">
                        Autodetailing proizvodi
                    </p>
                </div>

                <div class="px-8 pb-8">

                    @if (Auth::check() && in_array(Auth::user()->role, ['admin', 'foreman']))
                        <a href="{{ route('webshop.add') }}">
                            <x-button class="w-max px-4 py-3 mb-4 mt-6">
                                <svg class="w-4 h-4 mr-2 text-gray-100" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                    viewBox="0 0 24 24">
                                    <path stroke="currentColor" strWoke-linecap="round" stroke-linejoin="round"
                                        stroke-width="3" d="M5 12h14m-7 7V5" />
                                </svg>
                                Dodaj novi artikal
                            </x-button>
                        </a>
                    @endif

                    <!-- Dropdown za kategorije -->
                    <form method="GET" action="{{ route('webshop') }}">
                        <div class="mb-6">
                            <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Filter po
                                kategoriji</label>
                            <select id="category" name="category"
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm py-2 px-3 cursor-pointer"
                                onchange="this.form.submit()">
                                <option value="">Sve kategorije</option>
                                @php
                                    $categories = [
                                        'cloths' => 'Krpe',
                                        'window_cleaners' => 'Sredstva za stakla',
                                        'ceramic_coat' => 'Keramički premazi',
                                        'polish' => 'Poliranje',
                                        'interior_cleaners' => 'Sredstva za unutrašnjost',
                                        'accessories' => 'Dodaci',
                                    ];
                                @endphp
                                @foreach ($categories as $key => $label)
                                    <option value="{{ $key }}"
                                        {{ request('category') === $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </form>

                    <!-- Products Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @forelse ($items as $item)
                            <div
                                class="bg-white rounded-xl shadow-md overflow-hidden transform transition duration-300 hover:scale-105">
                                <div class="h-48 bg-gray-200 flex items-center justify-center">
                                    <img src="{{ asset('storage/' . $item->image) }}" class="h-full w-full object-cover"
                                        alt="{{ $item->name }}">
                                </div>
                                <div class="p-4">
                                    <h2 class="text-lg font-semibold text-gray-800">{{ $item->name }}</h2>
                                    <p class="text-sm text-gray-500 mt-2 line-clamp-2">{{ $item->description }}</p>
                                    <div class="mt-4 flex items-center justify-between">
                                        <span
                                            class="text-xl font-bold text-gray-900">{{ number_format($item->price, 2) }}
                                            KM</span>
                                        <button
                                            class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition">Dodaj</button>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="col-span-full text-center text-gray-500 text-lg mt-10">Nema artikala.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
