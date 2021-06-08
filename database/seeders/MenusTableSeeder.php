<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenusTableSeeder extends Seeder
{

    public function run()
    {
        $groups = [
            [
                'menu_id' => null,
                'name' => 'principal',
                'order' => 0,
                'icon' => null
            ],
            [
                'menu_id' => null,
                'name' => 'reportes',
                'order' => 1,
                'icon' => null
            ],
            [
                'menu_id' => null,
                'name' => 'administración',
                'order' => 2,
                'icon' => null
            ],
            [
                'menu_id' => 1,
                'name' => 'dashboard',
                'order' => 0,
                'icon' => 'heroicon-s-view-grid'
            ],
            [
                'menu_id' => 1,
                'name' => 'notificaciones',
                'order' => 1,
                'icon' => 'heroicon-s-bell'
            ],
            [
                'menu_id' => 2,
                'name' => 'usuarios',
                'order' => 0,
                'icon' => 'heroicon-s-users'
            ],
            [
                'menu_id' => 2,
                'name' => 'cupones',
                'order' => 1,
                'icon' => 'heroicon-s-tag'
            ],
            [
                'menu_id' => 2,
                'name' => 'ventas',
                'order' => 2,
                'icon' => 'heroicon-s-currency-dollar'
            ],
            [
                'menu_id' => 2,
                'name' => 'saldo disponible',
                'order' => 3,
                'icon' => 'heroicon-s-credit-card'
            ],
            [
                'menu_id' => 3,
                'name' => 'usuarios',
                'order' => 0,
                'icon' => 'heroicon-s-user-circle'
            ],
            [
                'menu_id' => 3,
                'name' => 'roles y permisos',
                'order' => 1,
                'icon' => 'heroicon-s-identification'
            ],
            [
                'menu_id' => 3,
                'name' => 'grupos',
                'order' => 2,
                'icon' => 'heroicon-s-office-building'
            ],
            [
                'menu_id' => 3,
                'name' => 'menús',
                'order' => 3,
                'icon' => 'heroicon-s-menu-alt-2'
            ],
            [
                'menu_id' => 6,
                'name' => 'nuevos usuarios',
                'order' => 0,
                'icon' => null
            ],
            [
                'menu_id' => 6,
                'name' => 'acumulado',
                'order' => 1,
                'icon' => null
            ],
            [
                'menu_id' => 7,
                'name' => 'impresos',
                'order' => 0,
                'icon' => null
            ],
            [
                'menu_id' => 7,
                'name' => 'canjeados',
                'order' => 1,
                'icon' => null
            ],
            [
                'menu_id' => 7,
                'name' => 'último cupón',
                'order' => 2,
                'icon' => null
            ],
            [
                'menu_id' => 7,
                'name' => 'impresos vs canjeados',
                'order' => 3,
                'icon' => null
            ],
            [
                'menu_id' => 7,
                'name' => 'acumulado canjeados e impresos',
                'order' => 4,
                'icon' => null
            ],
            [
                'menu_id' => 8,
                'name' => 'detallado',
                'order' => 0,
                'icon' => null
            ],
            [
                'menu_id' => 8,
                'name' => 'acumulado',
                'order' => 1,
                'icon' => null
            ],
        ];

        DB::table('menus')->insert($groups);
    }
}
