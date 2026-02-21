<?php

namespace App\Livewire;

use App\Models\Unit;
use Livewire\Component;

class UnitsTable extends Component
{
    public $search = '';
    public $sortBy = 'name';

    public $perPage = 25;
    public $sortDirection = 'asc';

    public function sort($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortBy = $field;
    }
    public function render()
    {
        $units = Unit::query()
            ->with('foreman')
            ->when($this->search, function ($query) {
                $query->where('name', 'like', "%{$this->search}%");
            })
            ->when($this->sortBy === 'foreman_id', function ($query) {
                $query->join('users', 'units.foreman_id', '=', 'users.id')
                    ->orderBy('users.firstname', $this->sortDirection)
                    ->select('units.*');
            }, function ($query) {
                $query->orderBy($this->sortBy, $this->sortDirection);
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.units-table', [
            'units' => $units
        ]);
    }
}
