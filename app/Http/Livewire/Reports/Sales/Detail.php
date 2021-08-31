<?php

namespace App\Http\Livewire\Reports\Sales;

use App\Exports\DetailSalesExport;
use App\Traits\Reports\Sales;
use Livewire\Component;
use Asantibanez\LivewireCharts\Models\AreaChartModel;
use App\Models\Store;

class Detail extends Component
{
    use Sales;

    public $sales;
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
        if(isset($this->sales['VENTAS']))
        {
            $saleList = collect($this->sales['VENTAS']);
            $areaChartModel = $saleList->reduce(function (AreaChartModel $areaChartModel, $data, $key) use($saleList) {
                $sale = $saleList[$key];
                return $areaChartModel->addPoint($key, $sale['MONTO']);

            }, (new AreaChartModel())
                ->setTitle('Ventas')
                ->setAnimated(true)
                ->setSmoothCurve()
                ->withGrid()
                ->setXAxisVisible(true)
            );

            return view('livewire.reports.sales.detail')->with(['areaChartModel' => $areaChartModel]);
        }

        return view('livewire.reports.sales.detail');
    }

    public function generateReport()
    {
        $this->sales = $this->getSalesDetail($this->store, $this->initialDate, $this->finalDate, $this->period);
    }

    public function exportReport()
    {
        return (new DetailSalesExport(collect($this->sales['VENTAS'])))->download('reporte_ventas_detallado.xlsx');
    }
}
