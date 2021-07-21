<?php

namespace App\Http\Livewire\Reports\Users;

use App\Exports\NewUserExport;
use App\Traits\Reports\Users;
use Livewire\Component;
use App\Models\Store;

class NewUsers extends Component
{
    use Users;

    public $users;
    public $stores;
    public $store;
    public $period;
    public $initialDate;
    public $finalDate;

    public function mount()
    {
        $this->stores = Store::orderBy('name')->pluck('name', 'id')->toArray();
    }

    public function render()
    {
        return view('livewire.reports.users.new-users');
    }

    public function generateReport()
    {
        $this->users = $this->getUsers($this->store, $this->initialDate, $this->finalDate);
    }

    public function exportReport()
    {
        return (new NewUserExport(collect($this->users['USUARIOS'])))->download('reporte_nuevos_usuarios.xlsx');
    }
}
