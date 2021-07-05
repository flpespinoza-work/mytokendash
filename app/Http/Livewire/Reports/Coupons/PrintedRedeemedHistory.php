<?php

namespace App\Http\Livewire\Reports\Coupons;

use App\Traits\Reports\Coupons;
use Livewire\Component;

class PrintedRedeemedHistory extends Component
{
    use Coupons;
    public function render()
    {
        $coupons = $this->getPrintedRedeemedCouponsHistory();
        return view('livewire.reports.coupons.printed-redeemed-history', compact('coupons'));
    }
}
