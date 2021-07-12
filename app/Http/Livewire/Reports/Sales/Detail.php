<?php

namespace App\Http\Livewire\Reports\Sales;

use App\Traits\Reports\Sales;
use Livewire\Component;
use Asantibanez\LivewireCharts\Models\AreaChartModel;

class Detail extends Component
{
    use Sales;

    public function render()
    {
        $sales = $this->getSalesDetail();
        $saleList = collect($sales['VENTAS']);
        $areaChartModel = $saleList->reduce(function (AreaChartModel $areaChartModel, $data, $key) use($saleList) {
            $sale = $saleList[$key];
            return $areaChartModel->addPoint($key, $sale['VENTAS']);

        }, (new AreaChartModel())
            ->setTitle('Ventas')
            ->setAnimated(true)
            ->setSmoothCurve()
            ->withGrid()
            ->setXAxisVisible(true)
        );

        return view('livewire.reports.sales.detail')->with(['sales' => $sales, 'areaChartModel' => $areaChartModel]);
    }
}
