<?php

namespace App\Http\Livewire\Reports\Coupons;

use App\Traits\Reports\Coupons;
use Livewire\Component;
use Asantibanez\LivewireCharts\Models\LineChartModel;

class PrintedRedeemed extends Component
{
    use Coupons;

    public function render()
    {
        $coupons = $this->getPrintedRedeemedCoupons();
        $couponsList = collect($coupons['REGISTROS']);

        $lineChartModel = $couponsList->reduce(function (LineChartModel $lineChartModel, $data, $key) use($couponsList) {
            $coupon = $couponsList[$key];

            $lineChartModel->addSeriesPoint('Cupones impresos', $key, $coupon['CUPONES']);
            if(isset($coupon['CANJES']))
                $lineChartModel->addSeriesPoint('Cupones canjeados', $key, $coupon['CANJES']);
            else
                $lineChartModel->addSeriesPoint('Cupones canjeados', $key, 0);

            return $lineChartModel;

        }, (new LineChartModel())
            ->setTitle('Cupones impresos y canjeados')
            ->multiLine()
            ->setAnimated(true)
            ->setSmoothCurve()
            ->withGrid()
            ->setXAxisVisible(true)
            ->setColors(['#E86300', '#FFA35E'])
        );
        //dd($lineChartModel);
        return view('livewire.reports.coupons.printed-redeemed')->with(['coupons' => $coupons, 'lineChartModel' => $lineChartModel]);
    }
}
