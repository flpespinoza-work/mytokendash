<?php

namespace App\Http\Livewire\Reports\Coupons;

use App\Traits\Reports\Coupons;
use Livewire\Component;

class LastPrinted extends Component
{
    use Coupons;

    public function render()
    {
        $coupons = $this->getLastPrintedCoupon();
        return view('livewire.reports.coupons.last-printed', compact('coupons'));
    }
}
