<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Store;

class Dashboard extends Component
{
    public $store;
    public $stores;

    public function mount()
    {
        $this->stores = Store::all()->pluck('id', 'name')->toArray();
        $this->store = 46;
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}
