<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $groups = [
            [
                'name' => 'Gasomax',
                'contact_name' => null,
                'contact_phone' => '3333333333'
            ],
            [
                'name' => 'Shell',
                'contact_name' => null,
                'contact_phone' => '2222222222'
            ],
            [
                'name' => 'Redpetroil',
                'contact_name' => null,
                'contact_phone' => '4444444444'
            ],
        ];

        DB::table('groups')->insert($groups);
    }
}
