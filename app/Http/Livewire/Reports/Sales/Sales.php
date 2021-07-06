<?php

namespace App\Http\Livewire\Reports\Sales;

use App\Traits\Reports\Sales as ReportsSales;
use Livewire\Component;

class Sales extends Component
{
    use ReportsSales;

    public function render()
    {
        $sales = $this->getSales();
        return view('livewire.reports.sales.sales', compact('sales'));
    }
}
