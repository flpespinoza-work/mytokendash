<?php

namespace App\Http\Livewire\Reports\Sales;

use App\Traits\Reports\Sales;
use Livewire\Component;

class History extends Component
{
    use Sales;

    public function render()
    {
        $sales = $this->getSalesHistory();
        return view('livewire.reports.sales.history', compact('sales'));
    }
}
