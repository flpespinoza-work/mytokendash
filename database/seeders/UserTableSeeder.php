<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $user = User::create([
            'name' => 'superadmin',
            'email' => 'superadmin@tokencash.mx',
            'password' => Hash::make('password'),
            'phone_number' => 3333333333
        ]);
        $role = Role::find(1);
        $user->assignRole($role);


        $user = User::create([
            'name' => 'administrador de grupo',
            'email' => 'groupadmin@tokencash.mx',
            'password' => Hash::make('password'),
            'phone_number' => 3333333331
        ]);
        $role = Role::find(2);
        $user->assignRole($role);


        $user = User::create([
            'name' => 'gerente',
            'email' => 'gerente@tokencash.mx',
            'password' => Hash::make('password'),
            'phone_number' => 3333333330
        ]);
        $role = Role::find(2);
        $user->assignRole($role);

    }
}
