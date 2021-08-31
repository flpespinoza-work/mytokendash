<?php

namespace App\Http\Livewire\Reports\Sales;

use App\Traits\Reports\Sales;
use Livewire\Component;
use App\Models\Store;

class History extends Component
{
    use Sales;

    public $sales;
    public $stores;
    public $store;

    public function mount()
    {
        $this->stores = fn_obtener_establecimientos();
    }

    public function render()
    {
        return view('livewire.reports.sales.history');
    }

    public function generateReport()
    {
        $this->sales = $this->getSalesHistory($this->store);
    }
}
