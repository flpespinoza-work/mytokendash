<?php

namespace App\Http\Livewire\Menu;

use Livewire\Component;
use App\Models\Menu;

class Index extends Component
{
    public $menu = [
        'name' => '',
        'route' => '',
        'order' => 0,
        'icon' => ''
    ];

    public $menus;
    public $menusPadre;
    public $menuPadre;

    public function mount()
    {
        $this->menus = Menu::getMenu();
        $this->menusPadre = Menu::getMenuList();
    }

    public function render()
    {
        return view('livewire.menu.index');
    }

}
