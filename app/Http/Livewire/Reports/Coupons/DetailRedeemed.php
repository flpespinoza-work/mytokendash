<?php

namespace App\Http\Livewire\Reports\Coupons;

use App\Exports\DetailRedeemedCouponsExport;
use App\Traits\Reports\Coupons;
use Livewire\Component;
use App\Models\Store;

class DetailRedeemed extends Component
{
    use Coupons;

    public $coupons;
    public $stores;
    public $store;
    public $period;
    public $initialDate;
    public $finalDate;

    public function mount()
    {
        $this->stores = Store::orderBy('name')->pluck('name', 'id')->toArray();
    }

    public function render()
    {
        //$coupons = $this->getRedemedCouponsDetail();
        return view('livewire.reports.coupons.detail-redeemed');
    }

    public function generateReport()
    {
        $this->coupons = $this->getRedemedCouponsDetail($this->store, $this->initialDate, $this->finalDate, $this->period);
        //dd($this->coupons);
    }

    public function exportReport()
    {
        return (new DetailRedeemedCouponsExport(collect($this->coupons['REGISTROS'])))->download('reporte_detallado_cupones_canjeados.xlsx');
    }
}
