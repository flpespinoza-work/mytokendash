<?php

namespace App\Http\Livewire\Reports\Coupons;

use App\Traits\Reports\Coupons;
use Livewire\Component;
use App\Models\Store;

class PrintedRedeemedHistory extends Component
{
    use Coupons;

    public $coupons;
    public $stores;
    public $store;

    public function mount()
    {
        $this->stores = Store::orderBy('name')->pluck('name', 'id')->toArray();
    }

    public function render()
    {
        return view('livewire.reports.coupons.printed-redeemed-history');
    }

    public function generateReport()
    {
        $this->coupons = $this->getPrintedRedeemedCouponsHistory($this->store);
    }
}
