<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Store;

class Dashboard extends Component
{
    public $store;

    public function mount()
    {
        $this->store = 242624;
    }

    public function render()
    {
        return view('livewire.dashboard');
    }

}
