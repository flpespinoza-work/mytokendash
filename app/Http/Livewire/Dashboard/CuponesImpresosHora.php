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
        return view('livewire.dashboard.cupones-impresos-hora');
    }
}
