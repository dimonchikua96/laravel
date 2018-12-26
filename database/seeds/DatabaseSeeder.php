<?php

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
         $this->call(ServicePointStatesSeeder::class);
         $this->call(ServicePointTypesSeeder::class);
         $this->call(ServiceGroupsSeeder::class);
         $this->call(ServicePointsSeeder::class);
    }
}
