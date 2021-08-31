<?php

namespace App\Http\Livewire\Reports\Users;

use Livewire\Component;
use App\Traits\Reports\Users;
use App\Models\Store;

class Activity extends Component
{
    use Users;

    public $user;
    public $stores;
    public $store;
    public $period;
    public $initialDate;
    public $finalDate;
    public $detais;

    public function mount()
    {
        $this->stores = fn_obtener_establecimientos();
    }

    public function render()
    {
        return view('livewire.reports.users.activity');
    }

    public function getDetails()
    {
        $this->details = $this->getUserDetails($this->user, $this->store, $this->initialDate, $this->finalDate, $this->period);
    }
}
