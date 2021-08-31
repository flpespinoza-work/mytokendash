<?php

namespace App\Http\Livewire\Reports\Coupons;

use App\Exports\PrintedCouponsExport;
use Livewire\Component;
use App\Traits\Reports\Coupons;
use Asantibanez\LivewireCharts\Models\AreaChartModel;
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
        $user = auth()->user();
        if($user->hasRole('superadmin'))
        {
            $this->stores = Store::orderBy('name')->pluck('name', 'id')->toArray();
        }
        if($user->hasRole('group admin'))
        {
            $this->stores = $user->group->stores->pluck('name', 'id')->toArray();
        }




    }

    public function render()
    {
        if(isset($this->coupons['REGISTROS']))
        {
            $lineChartModel = null;
            $montoChartModel = null;

            $couponsList = collect($this->coupons['REGISTROS']);

            $lineChartModel = $couponsList->reduce(function (AreaChartModel $lineChartModel, $data, $key) use($couponsList) {
                $coupon = $couponsList[$key];

                return $lineChartModel->addPoint($key, $coupon['CUPONES']);
            }, (new AreaChartModel())
                ->setTitle('Cupones impresos')
                ->setAnimated(true)
                ->setSmoothCurve()
                ->withGrid()
                ->setXAxisVisible(true)
            );

            $montoChartModel = $couponsList->reduce(function (AreaChartModel $montoChartModel, $data, $key) use($couponsList) {
                $coupon = $couponsList[$key];
                return $montoChartModel->addPoint($key, $coupon['MONTO_IMPRESO']);
            }, (new AreaChartModel())
                ->setTitle('Dinero impreso')
                ->setAnimated(true)
                ->setSmoothCurve()
                ->withGrid()
                ->setXAxisVisible(true)
                ->setColor('#CF0924')
            );

            return view('livewire.reports.coupons.printed')->with(['lineChartModel' => $lineChartModel, 'montoChartModel' => $montoChartModel]);
        }


        return view('livewire.reports.coupons.printed');
    }

    public function generateReport()
    {
        $this->coupons = $this->getPrintedCouponsAlt($this->store, $this->initialDate, $this->finalDate, $this->period);
    }

    public function exportReport()
    {
        return (new PrintedCouponsExport(collect($this->coupons['REGISTROS'])))->download('reporte_cupones_impresos.xlsx');
    }
}
