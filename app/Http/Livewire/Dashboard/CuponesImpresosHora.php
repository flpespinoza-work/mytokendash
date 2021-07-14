<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Traits\Reports\Coupons;
use Asantibanez\LivewireCharts\Models\LineChartModel;

class CuponesImpresosHora extends Component
{
    use Coupons;
    public $store;

    public function mount($store)
    {
        $this->store = $store;
    }

    public function render()
    {
        /**
         * Obtener desde el inicio del dia y agrupar por hora
         */
        $lineChartModel = null;
        $coupons = $this->getLastHourPrintedCoupons([$this->store]);
        //dd($coupons);
        $lineChartModel = $coupons->reduce(function (LineChartModel $lineChartModel, $data) {

            $lineChartModel->addSeriesPoint($data->PRESUPUESTO, $data->TIEMPO_CUPON, $data->CUPONES);
            return  $lineChartModel;

        }, (new LineChartModel())
            ->setTitle('Cupones impresos la última hora')
            ->multiLine()
            ->setAnimated(true)
            ->setSmoothCurve()
            ->withGrid()
        );

        return view('livewire.dashboard.cupones-impresos-hora')->with(['lineChartModel' => $lineChartModel]);
    }
}
