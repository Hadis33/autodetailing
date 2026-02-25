<?php

namespace App\Livewire;

use App\Models\Reservation;
use Livewire\Component;

class ReservationModal extends Component
{
    public $show = false;
    public $selectedReservation = null;

    protected $listeners = ['openReservationModal'];

    public function openReservationModal($eventId = null)
    {
        $this->selectedReservation = Reservation::with(['service', 'user', 'unit'])
            ->where('id', $eventId)
            ->get()
            ->first();
        $this->show = true;
    }
    public function closeModal()
    {
        $this->show = false;
    }

    public function render()
    {
        return view('livewire.reservation-modal');
    }
}
