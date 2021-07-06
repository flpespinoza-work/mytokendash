<?php

namespace App\Http\Livewire\Reports\Sales;

use App\Traits\Reports\Sales;
use Livewire\Component;

class Detail extends Component
{
    use Sales;

    public function render()
    {
        $sales = $this->getSalesDetail();
        return view('livewire.reports.sales.detail', compact('sales'));
    }
}
