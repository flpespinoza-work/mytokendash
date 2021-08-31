<?php

namespace App\Http\Livewire\Reports\Sales;

use App\Exports\SalesExport;
use App\Traits\Reports\Sales as ReportsSales;
use Livewire\Component;
use Asantibanez\LivewireCharts\Models\AreaChartModel;
use App\Models\Store;

class Sales extends Component
{
    use ReportsSales;

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
                return $areaChartModel->addPoint($sale['FECHA_VENTA'], $sale['MONTO']);

            }, (new AreaChartModel())
                ->setTitle('Ventas realizadas')
                ->setColor('#f6ad55')
                ->setAnimated(true)
                ->setSmoothCurve()
                ->withGrid()
                ->setXAxisVisible(true)
            );
            return view('livewire.reports.sales.sales')->with(['areaChartModel' => $areaChartModel]);
        }

        return view('livewire.reports.sales.sales');
    }

    public function generateReport()
    {
        $this->sales = $this->getSales($this->store, $this->initialDate, $this->finalDate, $this->period);
    }

    public function exportReport()
    {
        return (new SalesExport(collect($this->sales['VENTAS'])))->download('reporte_ventas.xlsx');
    }
}
