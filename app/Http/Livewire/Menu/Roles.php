<?php

namespace App\Http\Livewire\Menu;

use App\Models\Menu;
use Livewire\Component;
use App\Models\Role;

class Roles extends Component
{
    public function render()
    {
        $roles = Role::orderBy('id')->get();
        $menus = Menu::getMenu();
        $menuRoles = Menu::with('roles')->get()->pluck('roles', 'id')->toArray();
        return view('livewire.menu.roles', compact('roles', 'menus', 'menuRoles'));
    }
}
