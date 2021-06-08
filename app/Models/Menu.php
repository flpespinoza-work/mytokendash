<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable =
    [
        'name',
        'menu_id',
        'route',
        'order',
        'icon'
    ];

    public function group()
    {
        return $this->belongsTo(MenuGroup::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'menu_role', 'menu_id', 'role_id');
    }

    public static function getMenu($is_sidebar = false)
    {
        $menu = new Menu();
        $menus = [];
        $padres = $menu->getMenuPadre($is_sidebar);
        foreach($padres as $menuPadre)
        {
            if($menuPadre['menu_id'] !== null)
                break;
            $menuItem = [array_merge($menuPadre, ['submenu' => $menu->getMenuHijo($padres, $menuPadre)])];
            $menus = array_merge($menus, $menuItem);
        }
        return $menus;
    }

    public static function getMenuList()
    {
        $menu = Menu::all()->pluck('name', 'id');
        return $menu;
    }

    private function getMenuPadre($is_sidebar)
    {
        if($is_sidebar)
        {

        }
        else
        {
            return $this->orderby('menu_id')
            ->orderby('order')
            ->get()
            ->toArray();
        }
    }

    private function getMenuHijo($padres, $menuPadre)
    {
        $hijos = [];
        foreach($padres as $menu)
        {
            if($menuPadre['id'] == $menu['menu_id'])
            {
                $hijos = array_merge($hijos, [array_merge($menu, ['submenu' => $this->getMenuHijo($padres, $menu)])]);
            }
        }

        return $hijos;
    }
}
