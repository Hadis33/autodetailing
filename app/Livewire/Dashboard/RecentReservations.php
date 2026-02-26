<?php

namespace App\Livewire\Dashboard;

use App\Models\Reservation;
use Livewire\Component;
use Livewire\WithPagination;

class RecentReservations extends Component
{
    use WithPagination;

    public string $search = '';
    public string $status = 'all';
    public int $perPage = 6;

    protected $queryString = [
        'search' => ['except' => ''],
        'status' => ['except' => 'all'],
        'page' => ['except' => 1],
    ];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingStatus(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $q = Reservation::query()
            ->with(['user:id,firstname,lastname,email', 'unit:id,name', 'service:id,name'])
            ->latest('start');

        if ($this->status !== 'all') {
            $q->where('status', $this->status);
        }

        $search = trim($this->search);
        if ($search !== '') {
            $q->where(function ($qq) use ($search) {
                $qq->whereHas('user', function ($u) use ($search) {
                    $u->where('firstname', 'like', "%{$search}%")
                        ->orWhere('lastname', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                })
                    ->orWhereHas('unit', function ($u) use ($search) {
                        $u->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('service', function ($s) use ($search) {
                        $s->where('name', 'like', "%{$search}%");
                    });
            });
        }

        return view('livewire.dashboard.recent-reservations', [
            'reservations' => $q->paginate($this->perPage),
        ]);
    }
}
