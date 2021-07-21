<?php

namespace App\Http\Livewire\Reports\Coupons;

use App\Exports\PrintedCouponsExport;
use Livewire\Component;
use App\Traits\Reports\Coupons;
use Asantibanez\LivewireCharts\Models\LineChartModel;
use App\Models\Store;

class Printed extends Component
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

            return view('livewire.reports.coupons.printed')->with(['lineChartModel' => $lineChartModel, 'montoChartModel' => $montoChartModel]);
        }


        return view('livewire.reports.coupons.printed');
    }

    public function generateReport()
    {
        $this->coupons = $this->getPrintedCoupons($this->store, $this->initialDate, $this->finalDate);
    }

    public function exportReport()
    {
        return (new PrintedCouponsExport(collect($this->coupons['REGISTROS'])))->download('reporte_cupones_impresos.xlsx');
    }
}
