<?php

namespace App\Http\Livewire\Role;
use App\Models\Role;

use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public function render()
    {
        $roles = Role::with('permissions')->paginate(10);
        //dd($roles);
        return view('livewire.role.index', compact('roles'));
    }
}
