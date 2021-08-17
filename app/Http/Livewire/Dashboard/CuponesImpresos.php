<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Traits\Reports\Coupons;

class CuponesImpresos extends Component
{
    use Coupons;

    public $store;

    protected $listeners = ['updateStore'];

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

    public function updateStore($store)
    {
        dd($store);
        $this->store = $store;
    }
}
