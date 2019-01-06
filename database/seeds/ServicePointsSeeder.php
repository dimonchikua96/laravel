<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServicePointsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        for ($i = 1; $i <= 10; $i++){
            DB::table('sp_points')->insert(
                [
                    'code' => Carbon::now()->format('dmy') . 'SP' . str_random(12),
                    'name' => 'Some point name №' . $i,
                    'state_id' => array_random(['active','inactive']),
                    'group_id' => array_random([$i,$i+1,$i+1]),
                    'operator_ldap' => null,
                    'operator_date' => '',
                    'sort_order' => 1,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s')

                ]);
        }



    }
}
