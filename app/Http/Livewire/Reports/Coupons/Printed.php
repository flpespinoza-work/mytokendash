<?php

namespace App\Http\Livewire\Reports\Coupons;

use Livewire\Component;
use App\Traits\Reports\Coupons;
use Asantibanez\LivewireCharts\Models\LineChartModel;

class Printed extends Component
{
    use Coupons;

    public function render()
    {
        $coupons = $this->getPrintedCoupons();
        $couponsList = collect($coupons['REGISTROS']);

        $lineChartModel = $couponsList->reduce(function (LineChartModel $lineChartModel, $data, $key) use($couponsList) {
            $coupon = $couponsList[$key];

            return $lineChartModel->addPoint($key, $coupon['CUPONES']);
        }, (new LineChartModel())
            ->setTitle('Cupones impresos')
            ->setAnimated(true)
            ->setSmoothCurve()
            ->withGrid()
            ->setXAxisVisible(true)
        );

        $montoChartModel = $couponsList->reduce(function (LineChartModel $montoChartModel, $data, $key) use($couponsList) {
            $coupon = $couponsList[$key];

            return $montoChartModel->addPoint($key, $coupon['MONTO_IMPRESO']);
        }, (new LineChartModel())
            ->setTitle('Dinero impreso')
            ->setAnimated(true)
            ->setSmoothCurve()
            ->withGrid()
            ->setXAxisVisible(true)
        );

        return view('livewire.reports.coupons.printed')->with(['coupons' => $coupons, 'lineChartModel' => $lineChartModel, 'montoChartModel' => $montoChartModel]);
    }
}
