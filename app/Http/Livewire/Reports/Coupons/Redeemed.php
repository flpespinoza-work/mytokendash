<?php

namespace App\Http\Livewire\Reports\Coupons;

use Livewire\Component;
use App\Traits\Reports\Coupons;
use Asantibanez\LivewireCharts\Models\AreaChartModel;

class Redeemed extends Component
{
    use Coupons;

    public function render()
    {
        $coupons = $this->getRedeemedCoupons();
        $couponsList = collect($coupons['REGISTROS']);

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

        return view('livewire.reports.coupons.redeemed')->with(['coupons' => $coupons, 'areaChartModel' => $areaChartModel, 'montoChartModel' => $montoChartModel]);
    }
}
