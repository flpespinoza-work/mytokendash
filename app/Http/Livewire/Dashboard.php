<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Coupon;
use App\Models\TokencashUser;
use App\Models\Store;
use Asantibanez\LivewireCharts\Facades\LivewireCharts;

class Dashboard extends Component
{
    public $nodos;

    public function mount()
    {
        $this->nodos =  Store::all()->pluck('tokencash_nodo');
    }

    public function render()
    {
        return view('livewire.dashboard');
    }

    private function getCouponsChart()
    {
        $coupons = Coupon::whereIn('CUP_PRESUPUESTO', ['supra'])
                         ->whereBetween('CUP_TS', ['2021-06-13','2021-06-14'])
                         ->get();

        $couponsChartModel = $coupons
            ->reduce(function ($lineChartModel, $data) use ($coupon) {
                $index = $coupons->search($data);

                $amountSum = $expenses->take($index + 1)->sum('amount');

                if ($index == 6) {
                    $lineChartModel->addMarker(7, $amountSum);
                }

                if ($index == 11) {
                    $lineChartModel->addMarker(12, $amountSum);
                }

                return $lineChartModel->addPoint($index, $data->amount, ['id' => $data->id]);
            }, LivewireCharts::lineChartModel()
                //->setTitle('Expenses Evolution')
                ->setAnimated($this->firstRun)
                ->withOnPointClickEvent('onPointClick')
                ->setSmoothCurve()
                ->setXAxisVisible(true)
                ->setDataLabelsEnabled($this->showDataLabels)
                ->sparklined()
            );
    }
}
