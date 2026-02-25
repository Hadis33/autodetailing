<x-modal title="Rezervacija" blur="base" wire:model.defer="show" align="center"
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">

    <div class="bg-white p-6 rounded-lg w-96">

        <h2 class="text-xl font-bold mb-4">
            Detalji rezervacije
        </h2>

        <p>
            <strong>Klijent:</strong>
            {{ $selectedReservation?->user?->firstname . ' ' . $selectedReservation?->user?->lastname ?? '' }}
        </p>

        <p>
            <strong>Usluga:</strong>
            {{ $selectedReservation?->service?->name ?? '' }}
        </p>

        <p>
            <strong>Poslovna jedinica:</strong>
            {{ $selectedReservation?->unit?->name ?? '' }}
        </p>

        <p>
            <strong>Početak:</strong>
            {{ $selectedReservation?->start?->format('d.m.Y H:i') ?? '' }}
        </p>

        <p>
            <strong>Kraj:</strong>
            {{ $selectedReservation?->end?->format('d.m.Y H:i') ?? '' }}
        </p>

        <p>
            <strong>Status:</strong>
            {{ $selectedReservation?->status ?? '' }}
        </p>

        <x-button wire:click="closeModal" class="mt-4 bg-red-500 text-white px-4 py-2 rounded focus:invisible">
            Zatvori
        </x-button>

    </div>

</x-modal>
