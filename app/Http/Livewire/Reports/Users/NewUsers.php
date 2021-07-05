<?php

namespace App\Http\Livewire\Reports\Users;

use App\Traits\Reports\Users;
use Livewire\Component;

class NewUsers extends Component
{
    use Users;
    public function render()
    {
        $users = $this->getUsers();
        return view('livewire.reports.users.new-users', compact('users'));
    }
}
