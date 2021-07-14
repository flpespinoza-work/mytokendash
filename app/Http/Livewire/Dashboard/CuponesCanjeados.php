<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Traits\Reports\Coupons;

class CuponesCanjeados extends Component
{
    use Coupons;

    public $store;

    public function mount($store)
    {
        $this->store = $store;
    }

    public function render()
    {
        $coupons = $this->getTodayRedeemedCoupons()->toArray();
        return view('livewire.dashboard.cupones-canjeados')->with(['coupons' => $coupons[0]]);
    }
}
