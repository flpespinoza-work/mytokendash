<?php

namespace App\Http\Livewire\Reports\Coupons;

use Livewire\Component;
use App\Traits\Reports\Coupons;

class Printed extends Component
{
    use Coupons;

    public function render()
    {
        $coupons = $this->getPrintedCoupons();
        return view('livewire.reports.coupons.printed', compact('coupons'));
    }
}
