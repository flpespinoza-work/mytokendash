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
    }

    public function render()
    {
        $this->store = $this->stores[array_key_first($this->stores)];
        return view('livewire.dashboard');
    }

    public function updateStore()
    {
        $this->emitTo('dashboard.cupones-impresos', 'updateStore', $this->store);
    }
}
