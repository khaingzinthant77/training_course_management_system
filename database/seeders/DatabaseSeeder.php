<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\AdminSeeder;
use Database\Seeders\TimeTableSeeder;
use Database\Seeders\MajorSeeder;
use Database\Seeders\SettingSeeder;
use Database\Seeders\NRCCodeSeeder;
use Database\Seeders\NRCStateSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AdminSeeder::class);
        $this->call(TimeTableSeeder::class);
        $this->call(SettingSeeder::class);
        $this->call(MajorSeeder::class);
        $this->call(NRCCodeSeeder::class);
        $this->call(NRCStateSeeder::class);
    }
}