<?php

namespace App\Http\Livewire\Reports\Coupons;

use App\Traits\Reports\Coupons;
use Livewire\Component;
use Livewire\WithPagination;

class DetailRedeemed extends Component
{
    use Coupons, WithPagination;

    public function render()
    {
        $coupons = $this->getRedemedCouponsDetail();
        return view('livewire.reports.coupons.detail-redeemed', compact('coupons'));
    }
}
