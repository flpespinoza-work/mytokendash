<?php

namespace App\Http\Livewire\Reports\Balance;

use App\Traits\Reports\Balance as ReportsBalance;
use Livewire\Component;

class Balance extends Component
{
    use ReportsBalance;

    public function render()
    {
        $balance = $this->getBalance();
        return view('livewire.reports.balance.balance', compact('balance'));
    }
}
