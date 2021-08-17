<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Traits\Reports\Coupons;

class CuponesImpresos extends Component
{
    use Coupons;

    public $store;

    public function mount($store)
    {
        $this->store = $store;
    }

    public function render()
    {
        $coupons = [];
        $coupons = $this->getTodayPrintedCoupons([$this->store])->toArray();
        return view('livewire.dashboard.cupones-impresos')->with(['coupons' => $coupons[0]]);
    }
}
