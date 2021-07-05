<?php

namespace App\Http\Livewire\Reports\Coupons;

use Livewire\Component;
use App\Traits\Reports\Coupons;

class Redeemed extends Component
{
    use Coupons;

    public function render()
    {
        $coupons = $this->getRedeemedCoupons();
        return view('livewire.reports.coupons.redeemed',compact('coupons'));
    }
}
