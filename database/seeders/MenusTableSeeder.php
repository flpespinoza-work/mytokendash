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
                'name' => 'Principal',
                'order' => 0,
                'icon' => null,
                'route' => null
            ],
            [
                'menu_id' => null,
                'name' => 'Reportes',
                'order' => 1,
                'icon' => null,
                'route' => null
            ],
            [
                'menu_id' => null,
                'name' => 'Administración',
                'order' => 2,
                'icon' => null,
                'route' => null
            ],
            [
                'menu_id' => 1,
                'name' => 'Dashboard',
                'order' => 0,
                'icon' => 'heroicon-s-view-grid',
                'route' => 'dashboard'
            ],
            [
                'menu_id' => 1,
                'name' => 'Notificaciones',
                'order' => 1,
                'icon' => 'heroicon-s-bell',
                'route' => 'notifications'
            ],
            [
                'menu_id' => 2,
                'name' => 'Usuarios',
                'order' => 0,
                'icon' => 'heroicon-s-users',
                'route' => null
            ],
            [
                'menu_id' => 2,
                'name' => 'Cupones',
                'order' => 1,
                'icon' => 'heroicon-s-tag',
                'route' => null
            ],
            [
                'menu_id' => 2,
                'name' => 'Ventas',
                'order' => 2,
                'icon' => 'heroicon-s-currency-dollar',
                'route' => null
            ],
            [
                'menu_id' => 2,
                'name' => 'Saldo disponible',
                'order' => 3,
                'icon' => 'heroicon-s-credit-card',
                'route' => null
            ],
            [
                'menu_id' => 3,
                'name' => 'Usuarios',
                'order' => 0,
                'icon' => 'heroicon-s-user-circle',
                'route' => 'users.index'
            ],
            [
                'menu_id' => 3,
                'name' => 'Roles y permisos',
                'order' => 1,
                'icon' => 'heroicon-s-identification',
                'route' => null
            ],
            [
                'menu_id' => 3,
                'name' => 'Grupos',
                'order' => 2,
                'icon' => 'heroicon-s-office-building',
                'route' => null
            ],
            [
                'menu_id' => 3,
                'name' => 'Menús',
                'order' => 3,
                'icon' => 'heroicon-s-menu-alt-2',
                'route' => null
            ],
            [
                'menu_id' => 6,
                'name' => 'Nuevos usuarios',
                'order' => 0,
                'icon' => null,
                'route' => null
            ],
            [
                'menu_id' => 6,
                'name' => 'Acumulado',
                'order' => 1,
                'icon' => null,
                'route' => null
            ],
            [
                'menu_id' => 7,
                'name' => 'Impresos',
                'order' => 0,
                'icon' => null,
                'route' => null
            ],
            [
                'menu_id' => 7,
                'name' => 'Canjeados',
                'order' => 1,
                'icon' => null,
                'route' => null
            ],
            [
                'menu_id' => 7,
                'name' => 'Último cupón',
                'order' => 2,
                'icon' => null,
                'route' => null
            ],
            [
                'menu_id' => 7,
                'name' => 'Impresos vs Canjeados',
                'order' => 3,
                'icon' => null,
                'route' => null
            ],
            [
                'menu_id' => 7,
                'name' => 'Acumulado canjeados e impresos',
                'order' => 4,
                'icon' => null,
                'route' => null
            ],
            [
                'menu_id' => 8,
                'name' => 'Detallado',
                'order' => 0,
                'icon' => null,
                'route' => null
            ],
            [
                'menu_id' => 8,
                'name' => 'Acumulado',
                'order' => 1,
                'icon' => null,
                'route' => null
            ],
        ];

        DB::table('menus')->insert($groups);
    }
}
