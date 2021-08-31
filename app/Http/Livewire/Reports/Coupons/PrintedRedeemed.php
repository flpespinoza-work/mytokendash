<?php

namespace App\Http\Livewire\Reports\Coupons;

use App\Exports\PrintedRedeemedCouponsExport;
use App\Traits\Reports\Coupons;
use Livewire\Component;
use Asantibanez\LivewireCharts\Models\LineChartModel;
use App\Models\Store;

class PrintedRedeemed extends Component
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
        $this->stores = fn_obtener_establecimientos();
    }

    public function render()
    {
        if(isset($this->coupons['REGISTROS']))
        {
            $couponsList = collect($this->coupons['REGISTROS']);

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
            return view('livewire.reports.coupons.printed-redeemed')->with(['lineChartModel' => $lineChartModel]);
        }

        return view('livewire.reports.coupons.printed-redeemed');
    }

    public function generateReport()
    {
        $this->coupons = $this->getPrintedRedeemedCouponsAlt($this->store, $this->initialDate, $this->finalDate, $this->period);
    }

    public function exportReport()
    {
        return (new PrintedRedeemedCouponsExport(collect($this->coupons['REGISTROS'])))->download('reporte_cupones_impresos_canjeados.xlsx');
    }
}
