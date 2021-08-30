<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Traits\Reports\Balance;

class Saldos extends Component
{
    use Balance;
    public $store;

    public function mount($store)
    {
        $this->store = $store;
    }

    public function render()
    {
        $saldo = null;
        $saldo = $this->getBalance($this->store);
        if(!empty($saldo))
            $saldo = $saldo['BALANCES'][0];
        return view('livewire.dashboard.saldos')->with(['saldo' => $saldo]);
    }
}
