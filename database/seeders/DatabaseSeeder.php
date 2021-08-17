<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            PermissionsTableSeeder::class,
            RolesTableSeeder::class,
            StatesTableSeeder::class,
            MunicipalitiesTableSeeder::class,
            MenusTableSeeder::class,
            MenuRoleTableSeeder::class,
            UserTableSeeder::class,
            GroupsTableSeeder::class,
            StoreTableSeeder::class
        ]);
    }
}
