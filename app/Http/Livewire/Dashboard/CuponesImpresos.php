<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Traits\Reports\Coupons;
use Asantibanez\LivewireCharts\Models\LineChartModel;

class CuponesImpresos extends Component
{
    use Coupons;

    public $store;

    public function mount($store)
    {
        $this->store = $store;
    }

    public function render()
    {
        $coupons = $this->getLastHourPrintedCoupons([$this->store]);
        $lineChartModel = $coupons->reduce(function (LineChartModel $lineChartModel, $data) {
            return  $lineChartModel->addSeriesPoint($data->PRESUPUESTO, $data->TIEMPO_CUPON, $data->CUPONES);
        }, (new LineChartModel())
            ->setTitle('Últimos impresos')
            ->multiLine()
            ->setAnimated(true)
            ->setSmoothCurve()
            ->withGrid()
            ->setXAxisVisible(true)
        );
        return view('livewire.dashboard.cupones-impresos')->with(['lineChartModel' => $lineChartModel]);
    }
}
