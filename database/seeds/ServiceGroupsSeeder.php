<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceGroupsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $json = json_decode(file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'treeBranches.json'),true);

        foreach (['cashbox', 'operating_room'] as $type) {
            foreach ($json as $item) {
                DB::table('sp_groups')->insert( [
                    'name' => $item['name'],
                    'state_id' => array_random(['active','inactive']),
                    'type_id' => $type,
                    'branch' => $item['brnm'],
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s')
                ]);
            }
        }
    }
}
