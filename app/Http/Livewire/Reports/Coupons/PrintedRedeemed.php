<?php

namespace App\Http\Livewire\Reports\Coupons;

use App\Traits\Reports\Coupons;
use Livewire\Component;

class PrintedRedeemed extends Component
{
    use Coupons;

    public function render()
    {
        $coupons = $this->getPrintedRedeemedCoupons();
        return view('livewire.reports.coupons.printed-redeemed', compact('coupons'));
    }
}
