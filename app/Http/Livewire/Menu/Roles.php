<?php

namespace App\Http\Livewire\Menu;

use App\Models\Menu;
use Livewire\Component;
use App\Models\Role;
use Illuminate\Support\Facades\Cache;

class Roles extends Component
{
    protected $listeners = ['toggleMenuRole'];

    public function render()
    {
        $roles = Role::orderBy('id')->get();
        $menus = Menu::getMenu();
        $menuRoles = Menu::with('roles')->get()->pluck('roles', 'id')->toArray();
        return view('livewire.menu.roles', compact('roles', 'menus', 'menuRoles'));
    }

    public function toggleMenuRole($role, $menu, $checked)
    {
        $m = Menu::findOrFail($menu);
        if($checked)
        {
            $m->roles()->attach($role);
        }
        else{
            $m->roles()->detach($role);
        }

        cache()->tags('Menu')->forget("MenuSidebar.roleid.$role");
    }
}
