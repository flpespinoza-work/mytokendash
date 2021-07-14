<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Traits\Reports\Sales;

class Pagos extends Component
{
    use Sales;

    public $store;

    public function mount($store)
    {
        $this->store = $store;
    }

    public function render()
    {
        $sales = $this->getSales();
        //dd($sales);
        return view('livewire.dashboard.pagos')->with(['sales' => $sales]);
    }
}
