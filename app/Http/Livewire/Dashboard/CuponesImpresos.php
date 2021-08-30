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
        $coupons = null;
        $coupons = $this->getTodayPrintedCouponsAlt($this->store);
        if(!empty($coupons))
            $coupons = $coupons[0];

        return view('livewire.dashboard.cupones-impresos')->with(['coupons' => $coupons]);
    }
}
