<?php

namespace App\Http\Livewire\Reports\Sales;

use App\Traits\Reports\Sales as ReportsSales;
use Livewire\Component;
use Asantibanez\LivewireCharts\Models\AreaChartModel;

class Sales extends Component
{
    use ReportsSales;

    public function render()
    {
        $sales = $this->getSales();
        $saleList = collect($sales['VENTAS']);

        $areaChartModel = $saleList->reduce(function (AreaChartModel $areaChartModel, $data, $key) use($saleList) {
            $sale = $saleList[$key];
            return $areaChartModel->addPoint($sale['FECHA_VENTA'], $sale['MONTO']);

        }, (new AreaChartModel())
            ->setTitle('Ventas realizadas')
            ->setColor('#f6ad55')
            ->setAnimated(true)
            ->setSmoothCurve()
            ->withGrid()
            ->setXAxisVisible(true)
        );
        return view('livewire.reports.sales.sales')->with(['sales' => $sales, 'areaChartModel' => $areaChartModel]);
    }
}
