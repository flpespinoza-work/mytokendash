<?php

namespace App\Http\Livewire\Group;

use Livewire\Component;
use App\Models\Store as StoreModel;
use App\Models\Group;
use App\Models\Municipality;
use App\Models\State;

class Store extends Component
{
    public Group $group;
    public StoreModel $store;
    public $states;
    public $state;
    public $municipalities = [];
    public $municipality;

    public function mount(Group $group)
    {
        $this->group = $group;
        $this->states = State::all()->pluck('name', 'id');
    }

    public function render()
    {
        return view('livewire.group.store');
    }

    public function chargeMunicipalities()
    {
        if($this->state)
        {
            $this->municipalities = Municipality::where('state_id', $this->state)->pluck('name', 'id');
        }
        else {
            $this->municipalities = [];
        }
    }
}
