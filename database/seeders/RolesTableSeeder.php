<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $arrayOfRoles = [
            [
                'name' => 'superadmin',
                'description' => 'Acceso a todos los módulos y funciones del dashboard'
            ],
            [
                'name' => 'group admin',
                'description' => 'Administrador de un grupo, puede administrar todas las estaciones pertenecientes a su grupo'
            ],
            [
                'name' => 'gerente',
                'description' => 'Gerente de estacion'
            ]
        ];

        $roles = collect($arrayOfRoles)->map(function($role){
            return [
                'name' => $role['name'],
                'guard_name' => 'web',
                'description' => $role['description']
            ];
        });

        DB::table('roles')->insert($roles->toArray());
    }
}
