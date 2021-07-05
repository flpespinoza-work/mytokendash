<?php

namespace App\Http\Livewire\Reports\Users;

use App\Traits\Reports\Users;
use Livewire\Component;

class History extends Component
{
    use Users;

    public function render()
    {
        $users = $this->getUsersHistory();
        return view('livewire.reports.users.history', compact('users'));
    }
}
