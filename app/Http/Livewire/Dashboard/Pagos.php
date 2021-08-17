<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Traits\Reports\Sales;

class Pagos extends Component
{
    use Sales;

    public $store;

    protected $listeners = ['updateStore'];

    public function mount($store)
    {
        $this->store = $store;
    }

    public function render()
    {
        $sales = $this->getSales($this->store, date('Y-m-d ' . '00:00:00'), date('Y-m-d H:i:s'));
        if(empty($sales))
        {
            $sales['TOTALS']['sales'] = 0;
            $sales['TOTALS']['ammount'] = 0;
        }
        return view('livewire.dashboard.pagos')->with(['sales' => $sales]);
    }

    public function updateStore($store)
    {
        $this->store = $store;
    }
}
