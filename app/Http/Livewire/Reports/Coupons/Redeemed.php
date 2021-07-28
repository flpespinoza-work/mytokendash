<?php

namespace App\Http\Livewire\Reports\Coupons;

use App\Exports\RedeemedCouponsExport;
use Livewire\Component;
use App\Traits\Reports\Coupons;
use App\Models\Store;
use Asantibanez\LivewireCharts\Models\AreaChartModel;

class Redeemed extends Component
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
        if(isset($this->coupons['REGISTROS']))
        {
            $couponsList = collect($this->coupons['REGISTROS']);
            $areaChartModel = $couponsList->reduce(function (AreaChartModel $areaChartModel, $data, $key) use($couponsList) {
                $coupon = $couponsList[$key];

                return $areaChartModel->addPoint($key, $coupon['CANJES']);
            }, (new AreaChartModel())
                ->setTitle('Cupones canjeados')
                ->setAnimated(true)
                ->setSmoothCurve()
                ->withGrid()
                ->setXAxisVisible(true)
            );

            $montoChartModel = $couponsList->reduce(function (AreaChartModel $montoChartModel, $data, $key) use($couponsList) {
                $coupon = $couponsList[$key];

                return $montoChartModel->addPoint($key, $coupon['MONTO_CANJE']);
            }, (new AreaChartModel())
                ->setTitle('Dinero canjeado')
                ->setAnimated(true)
                ->setSmoothCurve()
                ->withGrid()
                ->setXAxisVisible(true)
            );
            return view('livewire.reports.coupons.redeemed')->with(['areaChartModel' => $areaChartModel, 'montoChartModel' => $montoChartModel]);
        }

        return view('livewire.reports.coupons.redeemed');
    }

    public function generateReport()
    {
        $this->coupons = $this->getRedeemedCoupons($this->store, $this->initialDate, $this->finalDate, $this->period);
    }

    public function exportReport()
    {
        return (new RedeemedCouponsExport(collect($this->coupons['REGISTROS'])))->download('reporte_cupones_canjeados.xlsx');
    }
}
