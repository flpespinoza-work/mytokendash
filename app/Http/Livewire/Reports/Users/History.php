<?php

namespace App\Http\Livewire\Reports\Users;

use App\Traits\Reports\Users;
use Livewire\Component;
use App\Models\Store;

class History extends Component
{
    use Users;


    public $users = [];
    public $stores;
    public $store;

    public function mount()
    {
        $this->stores = Store::orderBy('name')->pluck('name', 'id')->toArray();
    }

    public function render()
    {
        return view('livewire.reports.users.history');
    }

    public function generateReport()
    {
        $this->users = $this->getUsersHistory($this->store);
    }
}
