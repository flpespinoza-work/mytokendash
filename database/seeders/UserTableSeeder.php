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
            'street' => 'Avenidad Hidalgo 3328',
            'municipality_id' => 578,
            'phone_number' => 3333333333
        ]);
        $role = Role::find(1);
        $user->assignRole($role);
    }
}
